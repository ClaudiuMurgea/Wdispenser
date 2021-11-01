<?php

namespace App\Http\Controllers\admin;

use App\Helpers\DatabaseConnection;
use App\Http\Controllers\Controller;
use App\Models\LocationMasterIp;
use App\Models\PyramidUser;
use Illuminate\Http\Request;

class   PyramidUsersController extends Controller
{
    public function index(Request $request, $selectedlocationId){
        //$fromLocation = $request->get('from_location');

        if($selectedlocationId == 0){
            $currentLocationId = 1;
        }
        else{
            $currentLocationId = $selectedlocationId;
        }

        //print_r($fromLocation);

        return view('layouts.admin.users')
            ->with('users', PyramidUser::all())
            ->with('currentLocationId', $currentLocationId)
            ->with('locations', LocationMasterIp::orderBy('ServerType')->get()) ;
    }

    public function show($id){
        return PyramidUser::find($id);
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
}
