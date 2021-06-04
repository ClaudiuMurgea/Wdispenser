<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'      => 'System Guru',
            'username'  => 'eurogames',
            'email'     => 'the.guru@mordor.com',
            'password'  => Hash::make('pyramid'),
            'is_admin'  => true,
        ]);
    }
}
