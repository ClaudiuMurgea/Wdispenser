<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    //
    public function index(){
        return view('layouts.materials.materials')->with('materials', Material::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.materials.add_form');
    }

    public function store(Request $request)
    {
        $postData = $request->all();

        $client = Material::create([
            'material_name' => $postData['material_name'],
            'material_code' => $postData['material_code']
        ]);

        return redirect()->route('materials')->with('message', 'Material recorded');
    }
}
