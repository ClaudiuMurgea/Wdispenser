@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4">
              <div class="card text-white bg-info mb-3">
                <div class="card-header">All locations</div>
                <div class="card-body">
                  <h5 class="card-title">Info card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
            </div>

            <div class="col-xl-4">
              <div class="card text-white bg-dark mb-3">
                <div class="card-header">Location Name</div>
                <div class="card-body">
                    <table class="table table-bordered table-sm table-stripped">
                        <tbody>
                            <tr>
                                <td class="text-left text-white"><img src="css/res/c_rosu.png">In: 0 (0)</td>
                                <td class="text-left"><img src="{{ asset('css/res/c_rosu.png') }}">Out: 0 (0)</td>
                              </tr>
                              
                              <tr>
                                <td class="text-left"><img src="res/c_rosu.png">Win: 0 (0)</td>
                                <td class="text-left"><img src="res/c_verde.png">Slots: 20 from 20 (100%)</td>
                              </tr>
                              
                              <tr>
                                <td class="text-left"><img src="res/c_rosu.png">Bet: 0 (0)</td>
                                <td class="text-left"><img src="res/c_rosu.png">Active: 0 from 20 (0%)</td>
                              </tr>
                              <tr>
                                <td class="text-left"><img src="res/c_rosu.png">Profit: 0 (0)</td>
                                <td class="text-left"><img src="res/c_rosu.png">Cards: 0 from 0 (0%)</td>
                              </tr>
                              <tr>
                                <td class="text-left"><img src="res/c_rosu.png">Games: 0 (0)</td>
                                <td class="text-left"><img src="res/c_verde.png">Cred: 15 (1)</td>
                              </tr>
                              <tr>
                                <td class="text-left"><img src="res/c_rosu.png">Profit M: 14,201 (710)</td>
                                <td class="text-left"><img src="res/c_rosu.png">M/D: 1 (5%)/1 (5%)</td>
                              </tr>
                        </tbody>
                    </table>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4">
                <div class="card text-white bg-dark mb-3">
                  <div class="card-header">Location Name</div>
                  <div class="card-body">
                    <h5 class="card-title">Dark card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  </div>
                  
                </div>
              </div>
              
        </div>
    </div>
@endsection