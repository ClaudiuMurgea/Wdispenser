<?php

namespace App\Http\Controllers;

use App\Models\WineDispenser;

use Illuminate\Http\Request;

class WineDispenserController extends Controller
{
    //
    public function index(){

        return view('layouts.user.wine_dispenser')->with('products', WineDispenser::all());
    }
}
