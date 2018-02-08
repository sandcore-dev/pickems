<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\League;
use App\User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/picks';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
			'token'		=> 'required|exists:leagues,access_token',
            'name'		=> 'required|string|max:255|unique:users',
            'username'	=> 'required|string|max:255|unique:users',
            'email'		=> 'required|string|email|max:255|unique:users',
            'password'	=> 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active' => 1,
        ]);
    }
    
    /**
     * Show the registration form if the token is valid.
     * 
     * @param	string	$token
     * @return	\Illuminate\Http\Response
     */
    public function showRegistrationForm( $token )
    {
		$league = $this->getLeagueByTokenOrFail( $token );
		
    	return view('auth.register')->with( 'league', $league );
    }
    
    /**
     * Find the league with this token.
     * If not found, abort immediately.
     * 
     * @param	string	$token
     * @return	\App\League
     */
    protected function getLeagueByTokenOrFail( $token )
    {
		$league = League::byToken( $token )->get();
		
		if( $league->isEmpty() )
			abort(404, 'Forbidden');
		
		return $league->first();
    }
    
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $league = $this->getLeagueByTokenOrFail( $request->input('token') );
        
        $user->leagues()->sync( $league->id );
        
        $user->save();
    }
}
