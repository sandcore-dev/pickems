<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RulesPageController extends Controller
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
     * Show rules page depending on current user locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return view('rules.index')->with( 'locale', auth()->user()->locale );
    }
}
