<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu = "[
            [
                'is_new' => false,
                'name' => 'Clients',
                'is_updated' => true,
                'checklists' => [
                    ['id' => 1, 'name'=>'name', 'is_new'=>false, 'is_updated'=>true],
                    ['id' => 1, 'name'=>'name', 'is_new'=>false, 'is_updated'=>true],
                    ['id' => 1, 'name'=>'name', 'is_new'=>false, 'is_updated'=>true],
                ]
            ]
        ]";
        return view('home' compact(['home']));
    }
}
