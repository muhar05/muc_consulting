<?php

namespace Modules\Timesheet\Http\Controllers;

use App\Models\activity\TimesheetModel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $timesheets = TimesheetModel::all();
        return view('timesheet::index', compact('timesheets'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('timesheet::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('timesheet::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $timesheet = \App\Models\activity\TimesheetModel::findOrFail($id);
        return view('timesheet::edit', compact('timesheet'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'timestart' => 'required|date_format:H:i',
            'timefinish' => 'required|date_format:H:i',
            'description' => 'nullable|string',
        ]);

        $timesheet = \App\Models\activity\TimesheetModel::findOrFail($id);
        $timesheet->update([
            'date' => $request->date,
            'timestart' => $request->timestart . ':00',
            'timefinish' => $request->timefinish . ':00',
            'description' => $request->description,
        ]);

        return redirect()->route('timesheet.index')->with('success', 'Timesheet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}