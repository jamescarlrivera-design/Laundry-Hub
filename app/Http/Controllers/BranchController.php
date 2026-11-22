<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    // Display all branches
    public function index()
    {
        $branches = Branch::latest()->paginate(10);

        return view('admin.branches.index', compact('branches'));
    }


    public function customerindex()
    {
         $branches = Branch::where('status', 'active')
        ->latest()
        ->paginate(9);

        return view('customer.branches.index', compact('branches'));
    }

    // Show create branch form
    public function create()
    {
        return view('admin.branches.create');
    }

    // Save new branch
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'branch_code' => ['required', 'string', 'max:50', 'unique:branches,branch_code'],
            'address' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        Branch::create($validated);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch created successfully!');
    }

    // Display individual branch
    public function show(Branch $branch)
    {
        $branch->load('services', 'laundryRequests');

        return view('admin.branches.show', compact('branch'));
    }

    // Show edit branch form
    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    // Update branch
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'branch_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('branches', 'branch_code')->ignore($branch->id),
            ],
            'address' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $branch->update($validated);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch updated successfully!');
    }

    // Delete branch
    public function destroy(Branch $branch)
    {
        // Prevent deletion if branch has existing laundry requests
        if ($branch->laundryRequests()->exists()) {
            return redirect()
                ->route('admin.branches.index')
                ->with('error', 'Cannot delete this branch because it has existing laundry requests. Deactivate it instead.');
        }

        // Remove service associations from pivot table
        $branch->services()->detach();

        $branch->delete();

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully!');
    }
}
