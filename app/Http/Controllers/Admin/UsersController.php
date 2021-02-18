<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UsersController extends Controller
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
     * @param Request
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('admin.users.index')->with(
            [
                'users' => User::paginate(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:users'],
                'locale' => ['required', Rule::in(array_keys(config('app.locales')))],
                'email' => ['required', 'email'],
                'username' => ['required', 'min:2', 'unique:users'],
                'password' => ['required', 'min:3'],
                'reminder' => ['boolean'],
                'active' => ['boolean'],
                'is_admin' => ['boolean'],
            ]
        );

        $data = $request->only('name', 'locale', 'email', 'username', 'reminder', 'active');
        $data['password'] = bcrypt(Str::random(10));

        if ($user = User::create($data)) {
            session()->flash('status', __("The user :name has been added.", ['name' > $user->name]));

            $user->is_admin = $request->input('is_admin');

            if ($password = $request->input('password')) {
                $user->password = bcrypt($password);
            }

            $user->save();
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Factory|Application|View
     */
    public function show(User $user)
    {
        return view('admin.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Factory|Application|View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:users,name,' . $user->id],
                'locale' => ['required', Rule::in(array_keys(config('app.locales')))],
                'email' => ['required', 'email'],
                'username' => ['required', 'min:2', 'unique:users,username,' . $user->id],
                'password' => ['min:3', 'nullable'],
                'reminder' => ['boolean'],
                'active' => ['boolean'],
                'is_admin' => ['boolean'],
            ]
        );

        if ($user->update($request->only('name', 'locale', 'email', 'username', 'reminder', 'active'))) {
            session()->flash('status', __("The user :name has been changed.", ['name' => $user->name]));

            $user->is_admin = $request->input('is_admin');

            if ($password = $request->input('password')) {
                $user->password = bcrypt($password);
            }

            $user->save();
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            session()->flash('status', __("The user :name has been deleted.", ['name' => $user->name]));
        } catch (QueryException $e) {
            session()->flash('status', __("The user :name could not be deleted.", ['name' => $user->name]));
        }

        return redirect()->route('admin.users.index');
    }
}
