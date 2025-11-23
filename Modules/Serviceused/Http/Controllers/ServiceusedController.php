<?php

namespace Modules\Serviceused\Http\Controllers;

use App\Models\marketing\ServiceusedModel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ServiceusedController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // Ambil data serviceused dan proposal
        $serviceuseds = ServiceusedModel::query()
            ->select([
                'serviceused.*',
                'proposal.number as proposal_number',
                'serviceused.service_name',
                'serviceused.status',
            ])
            ->leftJoin('proposal', 'serviceused.proposal_id', '=', 'proposal.id')
            ->get();

        // Untuk setiap serviceused, hitung total timespent (dalam menit)
        foreach ($serviceuseds as $item) {
            $timesheets = DB::connection('mysql_activity')
                ->table('timesheet')
                ->where('serviceused_id', $item->id)
                ->get(['timestart', 'timefinish']);

            $totalMinutes = 0;
            foreach ($timesheets as $ts) {
                // Hitung selisih menit antara timefinish dan timestart
                $start = strtotime($ts->timestart);
                $finish = strtotime($ts->timefinish);
                if ($finish > $start) {
                    $totalMinutes += ($finish - $start) / 60;
                }
            }
            $item->timespent = $totalMinutes;
        }

        return view('serviceused::index', compact('serviceuseds'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // Ambil data proposal untuk select option
        $proposals = \App\Models\marketing\ProposalModel::all();
        return view('serviceused::create', compact('proposals'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'proposal_id' => 'required|exists:proposal,id',
            'service_name' => 'required|string|max:255',
            'status' => 'required|in:pending,ongoing,done',
        ]);

        \App\Models\marketing\ServiceusedModel::create([
            'proposal_id' => $request->proposal_id,
            'service_name' => $request->service_name,
            'status' => $request->status,
        ]);

        return redirect()->route('serviceused.index')->with('success', 'Service Used created successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('serviceused::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $serviceused = \App\Models\marketing\ServiceusedModel::findOrFail($id);
        $proposals = \App\Models\marketing\ProposalModel::all();
        return view('serviceused::edit', compact('serviceused', 'proposals'));
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
            'proposal_id' => 'required|exists:proposal,id',
            'service_name' => 'required|string|max:255',
            'status' => 'required|in:pending,ongoing,done',
        ]);

        $serviceused = \App\Models\marketing\ServiceusedModel::findOrFail($id);
        $serviceused->update([
            'proposal_id' => $request->proposal_id,
            'service_name' => $request->service_name,
            'status' => $request->status,
        ]);

        return redirect()->route('serviceused.index')->with('success', 'Service Used updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $serviceused = \App\Models\marketing\ServiceusedModel::findOrFail($id);
        $serviceused->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('serviceused.index')->with('success', 'Service Used deleted successfully.');
    }
}