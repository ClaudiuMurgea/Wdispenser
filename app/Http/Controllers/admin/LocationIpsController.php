<?php

namespace App\Http\Controllers\admin;

use App\Helpers\DatabaseConnection;
use App\Http\Controllers\Controller;
use App\Models\LocationMasterIp;

class LocationIpsController extends Controller
{
    //
    public function index(){
//        $params = [
//            'driver' => 'mysql',
//            'host' => '10.109.254.214', //
//            'port' => 3306,
//            'database' => 'Mystery',
//            'username' => 'app',
//            'password' => 'sau03magen'
//        ];
////
////        $conn = DatabaseConnection::setConnection($params);
////        $locationIps = $conn->table('MasterIP')->get()->map(function($i){
////            return (array)$i;
////        })->toArray();
//
//        $locationEntity = new LocationMasterIp();
//
//        //$locationEntity->setCustomConnection($params);
//
//        DatabaseConnection::setConnection($params);
//
//        $locationEntity->setConnection('mysql_main');
//
//        $locationIps = $locationEntity->all();

        return view('layouts.admin.location.ips')->with('locationIps', LocationMasterIp::orderBy('ServerType')->get());
    }

    public function list(){
        return response()->json(LocationMasterIp::orderBy('ServerType')->get());
    }
}
