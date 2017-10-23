<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveProfileRequest;
use App\Http\Requests\SavePasswordRequest;

class ProfileController extends Controller
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
     * Show the profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile')->with( 'user', auth()->user() );
    }
    
    /**
     * Save the profile.
     *
     * @var	$request	\Illuminate\Http\Request
     *
     * @return	\Illuminate\Http\Response
     */
    public function saveProfile( SaveProfileRequest $request )
    {
    	$user = auth()->user();
    	
    	$user->name	= $request->name;
    	$user->username	= $request->username;
    	$user->email	= $request->email;
    	$user->reminder	= $request->filled('reminder');
    	
    	if( $user->save() )
	    	return redirect()->route('profile')->with( 'status', 'Your profile has been changed succesfully.' );
	    
	return redirect()->route('profile');
    }
    
    /**
     * Save new password.
     *
     * @var	$request	\Illuminate\Http\Request
     *
     * @return	\Illuminate\Http\Response
     */
    public function savePassword( SavePasswordRequest $request )
    {
    	$user = auth()->user();
    	
    	$user->password	= bcrypt( $request->newpassword );
    	
    	if( $user->save() )
	    	return redirect()->route('profile')->with( 'status', 'Your password has been changed succesfully.' );
	    
	return redirect()->route('profile');
    }
}
