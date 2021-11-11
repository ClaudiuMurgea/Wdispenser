<?php

namespace App\Http\Controllers\admin;

use App\Helpers\DatabaseConnection;
use App\Http\Controllers\Controller;
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

            if(!empty($masterLocation)){// master found
                $currentLocationId = $masterLocation['LocationID'] ?? 0;
                $selectedLocationData = [
                    'location_ip'   => $masterLocation['IP'],
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

        $usersList = PyramidUser::all();

        $locationsList = LocationMasterIp::orderBy('ServerType')->get();

        return view('layouts.admin.users')
            ->with('selectedLocationData', $selectedLocationData)
            ->with('users', $usersList)
            ->with('currentLocationId', $currentLocationId)
            ->with('locations', $locationsList) ;
    }

    public function show($id){
        return PyramidUser::find($id);
    }

    public function store(Request $request){
        $response = ['success' => false, 'message' => ''];

        $forArray = [
            'Login'     => $request['user_name'] ?? null,
            'Password'  => $request['user_password'] ?? null,
            'FirstName' => $request['first_name'] ?? null,
            'LastName'  => $request['last_name'] ?? null,
            'Mobile'    => $request['user_phone'] ?? null,
            'Email'     => $request['user_email'] ?? null,
            'MAC'       => $request['mac_address'] ?? null,
            'CanLogBack'=> $request['can_log_back'] ?? null,
            'Card'      => $request['user_card'] ?? null,
            //'Mobile'    => $request['user_phone'] ?? null,
        ];

        $response = ['success' => false, 'message' => ''];

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
            try{
                $insertActionState = PyramidUser::insert($forArray);

                if($insertActionState){
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

        // todo: implement server from
        if(!empty($formData) && is_array($formData)){
            foreach ($formData as $name => $value){
                if($name != '_token'){
                    if(strpos($name, 'location') > -1) $selectedLocations[] = ['location_id' => $value];
                    if(strpos($name, 'user') > -1) $selectedUsers[] = ['user_id' => $value];
                }
            }
        }

        if(empty($selectedLocations) || empty($selectedUsers)) return redirect()->route('users_list');

        $mainDbParams = [
            'driver'    => 'mysql',
            'url'       => env('MASTER_DATABASE_URL'),
            'host'      => env('SMASTER_DB_HOST', '127.0.0.1'),
            'port'      => env('MASTER_DB_PORT', '3306'),
            'database'  => env('MASTER_DB_DATABASE', 'forge'),
            'username'  => env('MASTER_DB_USERNAME', 'forge'),
            'password'  => env('MASTER_DB_PASSWORD', ''),
        ];

        $sourceConn = DatabaseConnection::setConnection($mainDbParams);
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

        print '<pre>';

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
                            'Position'      => $_selectedUser['Position']
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
                }
            }
        }

        return redirect()->route('users_list');
    }

    public function accessRulesShow($userId, $locationId){
        // $restrictionListModel = new RestrictionList();
        // $restrictionListModel->setConnection('mysql_main');

        $accessRulesList = (new RestrictionList())->on('mysql_main')->get()->toArray();

        // print_r($accessRulesList);


    }

    private function getMasterLocation(){
        return LocationMasterIp::where('ServerType', 'Master')->get()->toArray();
    }
}
