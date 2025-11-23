<?php

namespace Modules\Proposal\Http\Controllers;

use App\Models\marketing\ProposalModel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $proposals = ProposalModel::get();
        return view('proposal::index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('proposal::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'number' dihapus dari validasi
            'year' => 'required|integer',
            'description' => 'nullable|string|max:100',
            'status' => 'required|string',
        ]);

        // Generate number otomatis
        $year = $request->year;
        $last = \App\Models\marketing\ProposalModel::where('year', $year)
            ->orderByDesc('id')
            ->first();

        if ($last && preg_match('/PR-' . $year . '-(\d+)/', $last->number, $matches)) {
            $next = intval($matches[1]) + 1;
        } else {
            $next = 1;
        }
        $number = 'PR-' . $year . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);

        \App\Models\marketing\ProposalModel::create([
            'number' => $number,
            'year' => $year,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('proposal.index')->with('success', 'Proposal created successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $proposal = ProposalModel::findOrFail($id);
        return view('proposal::show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $proposal = ProposalModel::findOrFail($id);
        return view('proposal::edit', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'year' => 'required|integer',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $proposal = ProposalModel::findOrFail($id);
        $proposal->update($request->only('number', 'year', 'description', 'status'));

        return redirect()->route('proposal.index')->with('success', 'Proposal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $proposal = ProposalModel::findOrFail($id);
        $proposal->delete();

        return redirect()->route('proposal.index')->with('success', 'Proposal deleted successfully.');
    }
}