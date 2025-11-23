<?php

namespace Modules\Timesheet\Http\Controllers;

use App\Models\activity\TimesheetModel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $timesheets = \App\Models\activity\TimesheetModel::with(['serviceused.proposal'])->get();
        $employeeList = \App\Models\hrd\EmployeesModel::pluck('fullname', 'id')->toArray();
        return view('timesheet::index', compact('timesheets', 'employeeList'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // Ambil data employee dan serviceused untuk select option
        $employees = \App\Models\hrd\EmployeesModel::all();
        $serviceuseds = \App\Models\marketing\ServiceusedModel::all();
        $proposals = \App\Models\marketing\ProposalModel::all();
        return view('timesheet::create', compact('employees', 'serviceuseds', 'proposals'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'timestart' => 'required|date_format:H:i',
            'timefinish' => 'required|date_format:H:i',
            'employees_id' => [
                'required',
                Rule::exists('mysql_hrd.employees', 'id'),
            ],
            'serviceused_id' => 'required|exists:serviceused,id',
            'description' => 'nullable|string',
        ]);

        \App\Models\activity\TimesheetModel::create([
            'date' => $request->date,
            'timestart' => $request->timestart . ':00',
            'timefinish' => $request->timefinish . ':00',
            'employees_id' => $request->employees_id,
            'serviceused_id' => $request->serviceused_id,
            'description' => $request->description,
        ]);

        return redirect()->route('timesheet.index')->with('success', 'Timesheet created successfully.');
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
        $timesheet = \App\Models\activity\TimesheetModel::findOrFail($id);
        $timesheet->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('timesheet.index')->with('success', 'Timesheet deleted successfully.');
    }
}