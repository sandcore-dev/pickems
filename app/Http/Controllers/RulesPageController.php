<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;

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
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('rules.index')->with('locale', auth()->user()->locale);
    }
}
