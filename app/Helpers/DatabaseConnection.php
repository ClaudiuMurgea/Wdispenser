<?php

namespace App\Helpers;

use Config;
use DB;
use PDO;

class DatabaseConnection{
    public static function setConnection($params){
        config(['database.connections.remoteServer' => [
            'driver'    => $params['driver'] ?? 'mysql',
            'url'       => $params['url'] ?? env('MASTER_DATABASE_URL'),
            'host'      => $params['host'] ?? env('MASTER_DB_HOST'),
            'port'      => $params['port'] ?? env('MASTER_DB_PORT'),
            'database'  => $params['database'] ?? env('MASTER_DB_DATABASE'),
            'username'  => $params['username'] ?? env('MASTER_DB_USERNAME'),
            'password'  => $params['password'] ?? env('MASTER_DB_PASSWORD'),
            'unix_socket' => env('REMOTE_DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ]]);

        DB::purge('mysql');

        return DB::connection('remoteServer');
    }

    public function closeConnection(){
        DB::disconnect('remoteServer');
    }
}
