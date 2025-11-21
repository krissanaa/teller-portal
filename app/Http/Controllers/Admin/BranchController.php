<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\Branch;
use App\Models\TellerPortal\BranchUnit;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('units')->orderBy('BRANCH_CODE')->paginate(15);
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_code' => 'required|string|max:50|unique:branch,BRANCH_CODE',
            'branch_name' => 'required|string|max:255',
        ]);

        Branch::create([
            'BRANCH_CODE' => $data['branch_code'],
            'BRANCH_NAME' => $data['branch_name'],
        ]);

        return redirect()->route('admin.branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit($id)
    {
        $branch = Branch::with('units')->findOrFail($id);
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $data = $request->validate([
            'branch_code' => 'required|string|max:50|unique:branch,BRANCH_CODE,' . $branch->id . ',id',
            'branch_name' => 'required|string|max:255',
        ]);

        $branch->update([
            'BRANCH_CODE' => $data['branch_code'],
            'BRANCH_NAME' => $data['branch_name'],
        ]);

        return redirect()->route('admin.branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return back()->with('success', 'Branch deleted successfully.');
    }

    public function storeUnit(Request $request, $branchId)
    {
        $branch = Branch::findOrFail($branchId);

        $data = $request->validate([
            'unit_code' => 'required|string|max:50|unique:branch_unit,unit_code',
            'unit_name' => 'required|string|max:255',
        ]);

        BranchUnit::create([
            'branch_id' => $branch->id,
            'unit_code' => $data['unit_code'],
            'unit_name' => $data['unit_name'],
        ]);

        return back()->with('success', 'Unit added to branch.');
    }

    public function updateUnit(Request $request, $branchId, $unitId)
    {
        $branch = Branch::findOrFail($branchId);
        $unit = $branch->units()->findOrFail($unitId);

        $data = $request->validate([
            'unit_code' => 'required|string|max:50|unique:branch_unit,unit_code,' . $unit->id,
            'unit_name' => 'required|string|max:255',
        ]);

        $unit->update($data);

        return back()->with('success', 'Unit updated successfully.');
    }

    public function destroyUnit($branchId, $unitId)
    {
        $branch = Branch::findOrFail($branchId);
        $unit = $branch->units()->findOrFail($unitId);
        $unit->delete();

        return back()->with('success', 'Unit removed from branch.');
    }
}
