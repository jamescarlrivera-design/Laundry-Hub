<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    // Display all services (Admin)
    public function index()
    {
        $services = Service::latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    // Display services available to customers
    public function customerIndex()
    {
        $services = Service::where('status', 'active')
            ->latest()
            ->paginate(10);

        return view('customer.services.index', compact('services'));
    }

  

    // Show create service form
    public function create()
    {
        return view('admin.services.create');
    }

    // Save new service
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:services,name',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully!');
    }

    // Display one service
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    // Show edit form
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // Update service
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')->ignore($service->id),
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully!');
    }

    // Delete service
    public function destroy(Service $service)
    {
        // Prevent deletion if service is already used in orders
        if ($service->requestItems()->exists()) {
            return redirect()
                ->route('admin.services.index')
                ->with('error', 'This service is already used in laundry requests. Deactivate it instead.');
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted successfully!');
    }
}
