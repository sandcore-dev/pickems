<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Series;
use Illuminate\View\View;

class SeriesController extends Controller
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
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('admin.series.index')->with('series', Series::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        return view('admin.series.create');
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
                'name' => ['required', 'min:2', 'unique:series,name'],
            ]
        );

        if ($series = Series::create($request->only('name'))) {
            session()->flash('status', __("The series :name has been added.", ['name' => $series->name]));
        }

        return redirect()->route('admin.series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Series $series
     * @return Factory|Application|View
     */
    public function show(Series $series)
    {
        return view('admin.series.show')->with('series', $series);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Series $series
     * @return Factory|Application|View
     */
    public function edit(Series $series)
    {
        return view('admin.series.edit')->with('series', $series);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Series $series
     * @return RedirectResponse
     */
    public function update(Request $request, Series $series)
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', Rule::unique('series')->ignore($series->id)],
            ]
        );

        if ($series->update($request->only('name'))) {
            session()->flash('status', __("The series :name has been changed.", ['name' => $series->name]));
        }

        return redirect()->route('admin.series.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Series $series
     * @return RedirectResponse
     */
    public function destroy(Series $series)
    {
        try {
            $series->delete();

            session()->flash('status', __("The series :name has been deleted.", ['name' => $series->name]));
        } catch (QueryException $e) {
            session()->flash('status', __("The series :name could not be deleted.", ['name' => $series->name]));
        }

        return redirect()->route('admin.series.index');
    }
}
