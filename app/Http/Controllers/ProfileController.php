<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Http\Requests\SaveProfileRequest;
use App\Http\Requests\SavePasswordRequest;
use Illuminate\View\View;

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
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('profile')->with('user', auth()->user());
    }

    /**
     * Save the profile.
     *
     * @param SaveProfileRequest $request
     * @return RedirectResponse
     */
    public function saveProfile(SaveProfileRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $request->validate(
            [
                'name' => ['required', 'unique:users,name,' . $user->id],
                'username' => ['required', 'unique:users,username,' . $user->id],
                'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                'locale' => ['required', Rule::in(array_keys(config('app.locales')))],
            ]
        );

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->locale = $request->input('locale');
        $user->reminder = $request->filled('reminder');

        if ($user->save()) {
            app()->setLocale($user->locale);

            return redirect()->route('profile')
                ->with('status', __('Your profile has been changed succesfully.'));
        }

        return redirect()->route('profile');
    }

    /**
     * Save new password.
     *
     * @param SavePasswordRequest $request
     * @return RedirectResponse
     */
    public function savePassword(SavePasswordRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->password = bcrypt($request->input('newpassword'));

        if ($user->save()) {
            return redirect()
                ->route('profile')
                ->with('status', __('Your password has been changed succesfully.'));
        }

        return redirect()->route('profile');
    }
}
