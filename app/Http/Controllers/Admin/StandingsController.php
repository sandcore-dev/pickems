<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Season;

class StandingsController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware( [ 'auth', 'admin' ] );
	}

	/**
	 * Recalculate standings of the given season.
	 *
	 * @param	\App\Season	$season
	 *
	 * @return	\Illuminate\Http\Response
	 */
	public function recalculate( Season $season )
	{
		return redirect()->back();
	}
}
