<?php

namespace App\Http\Controllers;

use App\Models\SmartLocker;

use Illuminate\Http\Request;

class SmartLockerController extends Controller
{
    //
    public function index(){

        return view('layouts.user.smart_locker')->with('products', SmartLocker::all());
    }
}
