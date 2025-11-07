<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TellerPortal\Branch;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderByDesc('created_at')->paginate(10);
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'contact' => 'nullable|string|max:255',
        ]);

        Branch::create($request->only('name', 'address', 'contact') + ['status' => 'active']);

        return redirect()->route('admin.branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->update($request->only('name', 'address', 'contact', 'status'));

        return redirect()->route('admin.branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return back()->with('success', 'Branch deleted successfully.');
    }
}
