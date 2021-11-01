<?php

namespace App\Http\Controllers\admin;

use App\Helpers\DatabaseConnection;
use App\Http\Controllers\Controller;
use App\Models\LocationMasterIp;
use Illuminate\Http\Request;

class LocationIpsController extends Controller
{
    //
    public function index(Request $request){
        // check if server is master or slave
        $allowAddAction = false;
        $masterRequired = false;

        //sleep(2);

        if(true){// if master, allow to add ip addresses
            $allowAddAction = true;
        }

        return view('layouts.admin.location.ips')
            ->with('locationIps', LocationMasterIp::orderBy('ServerType')->get())
            ->with('allowAdd', $allowAddAction)
            ->with('masterRequired', $masterRequired);
    }

    public function list(){
        return response()->json(LocationMasterIp::orderBy('ServerType')->get());
    }

    public function validateIp(Request $request){
        $serverIp = $request->get('ip_address');

        $serverData = $this->getServerLocationData($serverIp);
        if(!empty($serverData) && $serverData['success']){
            $response = [
                'server_found'  => true,
                'location_id'   => $serverData['location_id'],
                'location_name' => $serverData['location_name'],
                'sub_company'   => $serverData['sub_company'],
            ];
        }
        else{
            $response = [
                'server_found'  => false,
                'message'       => $serverData['message']
            ];
        }

        return response()->json($response);
    }

    private function getServerLocationData($serverIp){
        $serverData = ['success' => false];

        $targetServerParams = [
            'driver' => 'mysql',
            'host' => $serverIp,
            'port' => 3306,
            'database' => 'lmi',
            'username' => 'app',
            'password' => 'sau03magen'
        ];

        try{
            $targetConn = DatabaseConnection::setConnection($targetServerParams);

            $targetConn->getPdo();
        }
        catch(\Throwable $e){
            $serverData['message'] = 'Server error: ' . $e->getMessage();

            return $serverData;
        }

        try{
            $queryResponse = $targetConn->table('locations_last')->get()->toArray();
        }
        catch(\Throwable $e){
            $serverData['message'] = 'Mysql error!';

            return $serverData;
        }

        $queryResponse = (array)$queryResponse[0];

        $serverData = [
            'success'       => true,
            'message'       => 'Success',
            'location_id'   => $queryResponse['location_id']    ?? 0,
            'location_name' => $queryResponse['location_name']  ?? '',
            'sub_company'   => $queryResponse['sub_company']    ?? ''
        ];

        return $serverData;
    }
}
