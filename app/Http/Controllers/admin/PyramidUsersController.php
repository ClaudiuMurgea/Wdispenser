<?php

namespace App\Http\Controllers\admin;

use DB;

use App\Helpers\DatabaseConnection;
use App\Http\Controllers\Controller;
use App\Models\AdminRestriction;
use App\Models\AdminRestrictionsTemplate;
use App\Models\LocationMasterIp;
use App\Models\PyramidUser;
use App\Models\RestrictionList;
use Illuminate\Http\Request;

class   PyramidUsersController extends Controller
{
    public function index(Request $request, $selectedlocationId){
        $selectedLocationData = [
            'location_ip'   => '',
            'server_type'   => '',
            'location_name' => ''
        ];

        if($selectedlocationId == 0){ // search for master location
            $masterLocation = $this->getMasterLocation()[0] ?? [];

            //dd($masterLocation);

            if(!empty($masterLocation)){// master found
                $currentLocationId = $masterLocation['LocationID'] ?? 0;
                $selectedLocationData = [
                    'location_ip'   => env('MASTER_DB_HOST', $masterLocation['IP']),
                    'server_type'   => $masterLocation['ServerType'],
                    'location_name' => $masterLocation['LocationName']
                ];
            }
            else{// no master, probably slave server, get first record found
                $locationData = LocationMasterIp::orderBy('ServerType')->get()->toArray()[0] ?? [];

                if(!empty($locationData)){// slave found
                    $currentLocationId = $locationData['LocationID'] ?? 0;
                    $selectedLocationData = [
                        'location_ip'   => $locationData['IP'],
                        'server_type'   => $locationData['ServerType'],
                        'location_name' => $locationData['LocationName']
                    ];
                }
                else{// empty list, not recorded yet
                }
            }
        }
        else{// get location data
            $locationData = LocationMasterIp::where('LocationID', $selectedlocationId)->get()->toArray()[0] ?? [];
            $currentLocationId = $selectedlocationId;
            $selectedLocationData = [
                'location_ip'   => $locationData['IP'],
                'server_type'   => $locationData['ServerType'],
                'location_name' => $locationData['LocationName']
            ];
        }

        $usersList = [];

        //$usersList = PyramidUser::all();
        // get target location details from main server database
        $params = [
            'driver' => 'mysql',
            'host' => $selectedLocationData['location_ip'],
            'port' => 3306,
            'database' => env('MASTER_DB_DATABASE', 'Mystery'),
            'username' => env('MASTER_DB_USERNAME', 'app'),
            'password' => env('MASTER_DB_PASSWORD', 'sau03magen')
        ];
        $targetConn = DatabaseConnection::setConnection($params);


        // get full locations list from master
        //$locationData = LocationMasterIp::where('LocationID', $locationId)->get()->toArray()[0] ?? [];

        $usersList = $targetConn->table('lmi.AdminInfo')->get()->toArray() ?? [];

        foreach($usersList as &$userData){
            $userLocations = [];

            // search user in each location

            $userData->locations = $userLocations;
        }

        //dd($usersList);
        //exit;
        
        $locationsList = LocationMasterIp::orderBy('ServerType')->get();
        return view('layouts.admin.users')
            ->with('selectedLocationData', $selectedLocationData)
            ->with('users', $usersList)
            ->with('currentLocationId', $currentLocationId)
            ->with('locations', $locationsList) ;
    }

    // get user for view/edit
    public function show($locationId, $userId){
        $adminData = [];

        // get full locations list from master
        $locationData = LocationMasterIp::where('LocationID', $locationId)->get()->toArray()[0] ?? [];

        // get target location details from main server database
        $params = [
            'driver' => 'mysql',
            'host' => $locationData['IP'],
            'port' => 3306,
            'database' => env('MASTER_DB_DATABASE', 'Mystery'),
            'username' => env('MASTER_DB_USERNAME', 'app'),
            'password' => env('MASTER_DB_PASSWORD', 'sau03magen')
        ];
        $targetConn = DatabaseConnection::setConnection($params);

        $userData = $targetConn->table('lmi.AdminInfo')->where('ID', $userId)->get()->toArray()[0] ?? [];

        if(!empty($userData)){
            $adminData = [
                'edit_admin_name'               => $userData->Login ?? '',
                'edit_admin_passwd'             => null,
                'edit_first_name'               => $userData->FirstName ?? '',
                'edit_last_name'                => $userData->LastName ?? '',
                'edit_user_phone'               => $userData->Mobile ?? '',
                'edit_user_email'               => $userData->Email ?? '',
                'edit_mac_address'              => $userData->MAC ?? '',
                'edit_can_log_back'             => $userData->CanLogBack ?? '',
                'edit_user_card'                => $userData->Card ?? '',
                'edit_user_position'            => $userData->Position ?? '',
                'edit_user_max_inactive_time'   => $userData->MaxInactiveMin ?? ''
            ];

            $adminData['positions_options'] = (new AdminRestrictionsTemplate)->select('TemplateName')->groupBy('TemplateName')->get()->toArray();
        }

        return response()->json($adminData);
    }

    // record new user to database
    public function store(Request $request, $selectedlocationId){
        $formData = $request->all();

        $response = ['success' => false, 'message' => ''];

        if(empty($formData['admin_passwd'])){
            $response['message'] = 'Password required';
            return response()->json($response);
        }

        $pass = $this->processPassword($formData['admin_passwd'], 'ENCRYPT') ?? null;
        $formArray = [
            'Login'     => strtoupper($formData['login_name']) ?? null,
            'Password'  => $pass,
            'FirstName' => $formData['first_name'] ?? '',
            'LastName'  => $formData['last_name'] ?? '',
            'Mobile'    => $formData['user_phone'] ?? '',
            'Email'     => $formData['user_email'] ?? '',
            'MAC'       => $formData['mac_address'] ?? '',
            'CanLogBack'=> $formData['can_log_back'] ?? '',
            'Card'      => $formData['user_card'] ?? -1,
            'Position'  => $request['user_position'] ?? '',
            'MaxInactiveMin' => $request['max_inactive_time'] ?? ''
        ];

        $formValid = true;
        // form validation
        // foreach($forArray as $fieldName => $fieldValue){
        //     if(empty($fieldValue) || $fieldValue == null){
        //         $formValid = false;
        //         $response['message'] = 'All fields are mandatory!';

        //         break;
        //     }
        // }

        // end form validation

        if($formValid){
            // get full locations list from master
            $locationData = LocationMasterIp::where('LocationID', $selectedlocationId)->get()->toArray()[0] ?? [];

            // get target location details from main server database
            $params = [
                'driver' => 'mysql',
                'host' => $locationData['IP'],
                'port' => 3306,
                'database' => env('MASTER_DB_DATABASE', 'Mystery'),
                'username' => env('MASTER_DB_USERNAME', 'app'),
                'password' => env('MASTER_DB_PASSWORD', 'sau03magen')
            ];
            $targetConn = DatabaseConnection::setConnection($params);

            try{
                $insertedId = $targetConn->table('lmi.AdminInfo')->insertGetId($formArray);

                if($insertedId){
                    // clear access rules for user
                    $targetConn->table('lmi.AdminRestriction')->where('AdminID', $insertedId)->delete();

                    // get default access rules
                    $accessRulesList = (new RestrictionList())->on('mysql_main')->get()->toArray();

                    // save user access rules with defaults
                    if(!empty($accessRulesList)){
                        foreach($accessRulesList as $restriction){
                            $targetConn->table('lmi.AdminRestriction')->insert([
                                'AdminID'           => $insertedId,
                                'Restriction'       => $restriction['Restriction'],
                                'RestrictionValue'  => $restriction['DefaultValue']
                            ]);
                        }
                    }

                    $response['success'] = true;
                }
            }
            catch(\Throwable $e){
                $response['message'] = $e->getMessage();
            }
        }
        
        return response()->json($response);
    }

    public function copyAction(Request $request){
        $formData = $request->all();

        $selectedLocations = [];
        $selectedUsers = [];

        // // todo: implement server from
        if(!empty($formData) && is_array($formData)){
            foreach ($formData as $name => $value){
                if($name != '_token'){
                    if(strpos($name, 'location') > -1) $selectedLocations[] = ['location_id' => $value];
                    if(strpos($name, 'user') > -1) $selectedUsers[] = ['user_id' => $value];
                }
            }
        }

        if(empty($selectedLocations) || empty($selectedUsers)){
            return response()->json(['success' => false, 'message' => 'Missing data!']);
        };

        // temporary: LocationID must be received from frontend
        $masterLocation = $this->getMasterLocation();
        $locationId = $masterLocation[0]['LocationID'];
        // end temporary

        // get full locations list from master
        $locationData = LocationMasterIp::where('LocationID', $locationId)->get()->toArray()[0] ?? [];

        // get target location details from main server database
        $params = [
            'driver' => 'mysql',
            'host' => $locationData['IP'],
            'port' => 3306,
            'database' => env('MASTER_DB_DATABASE', 'Mystery'),
            'username' => env('MASTER_DB_USERNAME', 'app'),
            'password' => env('MASTER_DB_PASSWORD', 'sau03magen')
        ];

        $sourceConn = DatabaseConnection::setConnection($params);
        $locationUsers = $sourceConn->table('lmi.AdminInfo')->get()->map(function($i){
            return (array)$i;
        })->keyBy('ID')->toArray();

        // get users details from source database
        foreach ($selectedUsers as &$selectedUser){
            $selectedUser = $locationUsers[$selectedUser['user_id']];
            $selectedUser['restrictions'] = $sourceConn->table('lmi.AdminRestriction')->where('AdminId', $selectedUser['ID'])->get()->map(function($i){
                return (array)$i;
            })->toArray();
        }
        $sourceConn->disconnect();

        // get full locations list from master
        $locationsList = LocationMasterIp::all()->keyBy('LocationID')->toArray();

        foreach ($selectedLocations as $targetLocation){
            // get target location details from main server database
            $params = [
                'driver' => 'mysql',
                'host' => $locationsList[$targetLocation['location_id']]['IP'],
                'port' => 3306,
                'database' => 'Mystery',
                'username' => 'app',
                'password' => 'sau03magen'
            ];
            $targetConn = DatabaseConnection::setConnection($params);

            foreach($selectedUsers as $_selectedUser){
                $targetLocationUsers = $targetConn->table('lmi.AdminInfo')->where('Login', $_selectedUser['Login'])->get()->map(function($i){
                    return (array)$i;
                })->toArray();

                if(empty($targetLocationUsers)){// add
                    $insertedId = $targetConn->table('lmi.AdminInfo')->insertGetId(
                        array(
                            'Login'         => $_selectedUser['Login'],
                            'Password'      => $_selectedUser['Password'],
                            'FirstName'     => $_selectedUser['FirstName'],
                            'LastName'      => $_selectedUser['LastName'],
                            'Mobile'        => $_selectedUser['Mobile'],
                            'Email'         => $_selectedUser['Email'],
                            'MAC'           => $_selectedUser['MAC'],
                            'CanLogBack'    => $_selectedUser['CanLogBack'],
                            'Card'          => $_selectedUser['Card'],
                            'Position'      => $_selectedUser['Position'],
                            'MaxInactiveMin'=> $_selectedUser['MaxInactiveMin'],
                            'RestrictionTemplate' => $_selectedUser['RestrictionTemplate']
                        ));

                    $targetConn->table('lmi.AdminRestriction')->where('AdminID', $insertedId)->delete();
                    foreach ($_selectedUser['restrictions'] as $usrRestriction){
                        $targetConn->table('lmi.AdminRestriction')->insert(
                            array(
                                'AdminID'           => $insertedId,
                                'Restriction'       => $usrRestriction['Restriction'],
                                'RestrictionValue'  => $usrRestriction['RestrictionValue']
                            ));
                    }
                }
                else{// update
                    // 1831
                    // update user data


                    // remove old restrictions
                    $targetConn->table('lmi.AdminRestriction')->where('AdminID', $targetLocationUsers[0]['ID'])->delete();

                    // save new restrictions
                    foreach ($_selectedUser['restrictions'] as $usrRestriction){
                        $targetConn->table('lmi.AdminRestriction')->insert(
                            array(
                                'AdminID'           => $targetLocationUsers[0]['ID'],
                                'Restriction'       => $usrRestriction['Restriction'],
                                'RestrictionValue'  => $usrRestriction['RestrictionValue']
                            ));
                    }
                }

                $targetConn->closeConnection();
            }
        }

        return response()->json(['success' => true]);
    }

    public function accessRulesShow($locationId, $userId){
        $accessRulessTree = [];

        $accessRulesList = (new RestrictionList())->on('mysql_main')->get()->toArray();
        $userRestrictions = [];

        // get full locations list from master
        $locationData = LocationMasterIp::where('LocationID', $locationId)->get()->toArray()[0] ?? [];

        // get target location details from main server database
        $params = [
            'driver' => 'mysql',
            'host' => $locationData['IP'],
            'port' => 3306,
            'database' => env('MASTER_DB_DATABASE', 'Mystery'),
            'username' => env('MASTER_DB_USERNAME', 'app'),
            'password' => env('MASTER_DB_PASSWORD', 'sau03magen')
        ];

        $sourceConn = DatabaseConnection::setConnection($params);
        $userRestrictions = $sourceConn->table('lmi.AdminRestriction')
            ->where('AdminID', $userId)
            ->get()
            ->mapWithKeys(function($item){ return [$item->Restriction => $item->RestrictionValue]; })
            ->toArray();

        $userData = $sourceConn->table('lmi.AdminInfo')->where('ID', $userId)->first();

        if(!empty($accessRulesList)){
            foreach($accessRulesList as $accessRule){
                $children = explode("/", $accessRule['Restriction']);
                $isRoot = count($children) == 1;

                $name = array_pop($children);

                // $accessRule['children'] = [];
                $accessRule['r_name'] = $name;
                $accessRule['f_name'] = strtolower(str_replace('/', '', str_replace(' ', '', $accessRule['Restriction'])));
                $accessRule['additional'] = explode(",", $accessRule['Additional']);

                if($accessRule['Type'] == 'ShowHide' || $accessRule['Type'] == 'Select'){
                    $accessRule['UserValue'] = $userRestrictions[$accessRule['Restriction']] ?? '';
                }
                else{
                    // send as array to can match on front
                    if(!empty($userRestrictions[$accessRule['Restriction']])){
                        $accessRule['UserValue'] =  explode(',', $userRestrictions[$accessRule['Restriction']]);
                    }
                    else{
                        $accessRule['UserValue'] = '';
                    }
                }

                // Parinte - de la primul nivel
                if ($isRoot) {
                    $accessRulessTree[$name] = $accessRule;
                // Copil - peste nivelul 1
                } else {
                    $children[] = $name;
                    $key = implode('.children.', $children);

                    \Arr::set($accessRulessTree, $key, $accessRule);
                }
            }
        }

        $accessRulesFor = $userData->Login . ' | ' . $locationData['LocationName'];

        $responseArray = [
            "access_rules_tree"     => $accessRulessTree, 
            "access_rules_for"      => $accessRulesFor, 
            "templates"             => $this->getAllTemplatesNames(), 
            "RestrictionTemplate"   => ($sourceConn->table('lmi.AdminInfo')->select('RestrictionTemplate')->where('ID', $userId)->first())->RestrictionTemplate ?? ''
        ];

        return response()->json($responseArray);
    }

    public function accessRulesStore(Request $request, $locationId, $userId){
        $selectedRestrictions = $request->all();
        $accessRulesList = (new RestrictionList())->on('mysql_main')->get()->toArray();

        // get full locations list from master
        $locationsList = LocationMasterIp::all()->keyBy('LocationID')->toArray();

        // get target location details from main server database
        $targetConn = DatabaseConnection::setConnection($this->getConnectionParams($locationsList[$locationId]));

        // save template name in users table
        $targetConn->table('lmi.AdminInfo')->where('ID', $userId)->update(array('RestrictionTemplate' => ($selectedRestrictions['TemplateName'] ?? '')));

        $userRestrictions = [];
        if(!empty($accessRulesList)){
            // remove existent restrictions
            $targetConn->table('lmi.AdminRestriction')->where('AdminID', $userId)->delete();

            foreach($accessRulesList as $accessRule){
                $searchKey = strtolower(str_replace('/', '', str_replace(' ', '', $accessRule['Restriction'])));
                if($accessRule['Type'] == 'ShowHide'){
                    $usersRestriction = 'Hide';
                    if(isset($selectedRestrictions[$searchKey])) $usersRestriction = 'Show';
                }
                elseif($accessRule['Type'] == 'Choice'){
                    if(isset($selectedRestrictions[$searchKey])) $usersRestriction = $selectedRestrictions[$searchKey];
                }
                elseif($accessRule['Type'] == 'CheckList'){
                    if(isset($selectedRestrictions[$searchKey])) $usersRestriction = implode(',', $selectedRestrictions[$searchKey]);
                }

                $userRestrictions[] = [
                    'AdminID'           => $userId,
                    'Restriction'       => $accessRule['Restriction'],
                    'RestrictionValue'  => $usersRestriction
                ];
            }

            $targetConn->table('lmi.AdminRestriction')->insert($userRestrictions);
        }

        // if is master server update user restrictions in all slave locations
        $updatedServers = [];
        if($locationsList[$locationId]['ServerType'] == 'Master'){
            $masterLocationUserData = (new PyramidUser())->on('mysql_main')->where('ID', $userId)->first();

            foreach($locationsList as $location){
                if($location['ServerType'] == 'Master') continue;

                $params = $this->getConnectionParams($location);
                config(['database.connections.mysql_dinamic_connection.host' => $params['host']]);

                try{
                    //$targetConn->getPdo();
                    // search for user
                    $targetLocationUserData = DB::connection('mysql_dinamic_connection')->table('lmi.AdminInfo')->where('Login', $masterLocationUserData->Login)->first();
                    
                    if(!empty($targetLocationUserData->ID && !empty($userRestrictions))){
                        // just update user id
                        foreach($userRestrictions as &$usrRestriction){
                            $usrRestriction['AdminID'] = $targetLocationUserData->ID;
                        }

                        // update template name in users table
                        DB::connection('mysql_dinamic_connection')
                            ->table('lmi.AdminInfo')
                            ->where('ID', $targetLocationUserData->ID)
                            ->update(array('RestrictionTemplate' => ($selectedRestrictions['TemplateName'] ?? '')));
                        // remove existent restrictions
                        DB::connection('mysql_dinamic_connection')
                            ->table('lmi.AdminRestriction')
                            ->where('AdminID', $targetLocationUserData->ID)
                            ->delete();
                        // add new restrictions
                        DB::connection('mysql_dinamic_connection')
                            ->table('lmi.AdminRestriction')
                            ->insert($userRestrictions);
                        
                        $updatedServers[] = [
                            'location_host'     => $params['host'],
                            'location_name'     => $location['LocationName'],
                            'username'          => $targetLocationUserData->Login ?? 0
                        ];
                    }

                    // close connection
                    DB::disconnect('mysql_dinamic_connection');
                }
                catch(\Throwable $e){
                    // print_r('error');
                }
            }
        }

        return response()->json(['status' => true, 'updated_servers' => $updatedServers]);
    }

    private function getMasterLocation(){
        return LocationMasterIp::where('ServerType', 'Master')->get()->toArray();
    }

    private function processPassword($pass, $operation){
        $returnArray = [];

        for($i=0; $i<strlen($pass); $i++){
            $returnArray[] = chr(1+ord($pass[$i]));
        }

        return implode('', $returnArray);
    }

    private function getAllTemplatesNames(){
        return (new AdminRestrictionsTemplate)->select('TemplateName')->groupBy('TemplateName')->get()->toArray();
    }

    private function getConnectionParams($location){
        return $params = [
            'driver' => 'mysql',
            'host' => $location['IP'],
            'port' => 3306,
            'database' => env('MASTER_DB_DATABASE', 'Mystery'),
            'username' => env('MASTER_DB_USERNAME', 'app'),
            'password' => env('MASTER_DB_PASSWORD', 'sau03magen')
        ];
    }

}
