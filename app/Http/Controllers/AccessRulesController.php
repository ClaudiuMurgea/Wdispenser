<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccessRulesController extends Controller
{
    public function index(Request $request){
        $users = User::all()->toArray();

        //dd($request->user()->id);

        return view('layouts.access-rules')->with('users', $users) ;
    }

    public function tokenReset(Request $request){
        //dd($request->post()['id']);

        if(!empty($request->post()['id'])){
            $user = User::find($request->post()['id']);

            // remove all old tokens
            $user->tokens()->delete();

            // generate new token
            $token = $user->createToken('cmsapitoken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }
        else{
            return response()->json(['message' => 'Error'], 401);
        }
    }
}
