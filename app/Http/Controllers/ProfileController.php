<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
		
		$request->validate([
			'name'		=> [ 'required', 'unique:users,name,' . $user->id ],
			'username'	=> [ 'required', 'unique:users,username,' . $user->id ],
			'email'		=> [ 'required', 'email', 'unique:users,email,' . $user->id ],
			'locale'	=> [ 'required', Rule::in( array_keys(config('app.locales')) ) ],
		]);
    	
    	$user->name		= $request->name;
    	$user->username	= $request->username;
    	$user->email	= $request->email;
    	$user->locale	= $request->locale;
    	$user->reminder	= $request->filled('reminder');
    	
    	if( $user->save() )
    	{
			app()->setLocale( $user->locale );
			
	    	return redirect()->route('profile')->with( 'status', __('Your profile has been changed succesfully.') );
	    }
	    
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
	    	return redirect()->route('profile')->with( 'status', __('Your password has been changed succesfully.') );
	    
	return redirect()->route('profile');
    }
}
