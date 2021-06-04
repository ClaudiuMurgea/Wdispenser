<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        return view('layouts.clients.clients')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.clients.add_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validated = $request->validate([
//            'client_name' => 'required|max:100',
//            'client_address' => 'required|max:100',
//            'phone' => 'required'
//        ]);

        $postData = $request->all(
//            'client_name' => 'required|max:100',
//            'client_address' => 'required|max:100',
//            'phone' => 'required'
        );

        //dd($postData);

        $client = Client::create([
            'client_name' => $postData['client_name'],
            'client_address' => $postData['street_name'] . ', ' . $postData['street_number'] . ', ' . $postData['city_name'],
            'phone' => $postData['phone']
        ]);
//
//        dd($client);

        return redirect()->route('clients')->with('message', 'Client recorded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
