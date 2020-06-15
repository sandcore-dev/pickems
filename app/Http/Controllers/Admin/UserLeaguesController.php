<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\User;
use App\League;

class UserLeaguesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.userleagues.index')->with('users', User::with('leagues')->paginate());
    }

    /**
     * Edit leagues of this user
     *
     * @param \App\User
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.userleagues.edit')->with(
            [
                'user' => $user,
                'leagues' => League::paginate(),
            ]
        );
    }

    /**
     * Attach league of this user
     *
     * @param \App\User
     * @param \App\League
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attach(User $user, League $league)
    {
        $user->leagues()->attach($league->id);

        session()->flash('status', __("League :name attached.", ['name' => $league->name]));

        return redirect()->back();
    }

    /**
     * Detach league of this user
     *
     * @param \App\User
     * @param \App\League
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function detach(User $user, League $league)
    {
        try {
            $user->leagues()->detach($league->id);

            session()->flash('status', __("League :name detached.", ['name' => $league->name]));
        } catch (QueryException $e) {
            session()->flash('error', __("Cannot detach league :name.", ['name' => $league->name]));
        }

        return redirect()->back();
    }
}
