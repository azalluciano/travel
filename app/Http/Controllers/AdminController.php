<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Http\Requests\DestinationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller for handling admin operations on destinations
 */
class AdminController extends Controller
{
    /**
     * Display a listing of the destinations in admin panel
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $destinations = Destination::latest()->paginate(10);
        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new destination
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.destinations.create');
    }

    /**
     * Store a newly created destination in storage
     *
     * @param  \App\Http\Requests\DestinationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DestinationRequest $request)
    {
        // Create new destination with validated data
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('destinations', 'public');
        }
        
        Destination::create($data);
        
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination created successfully');
    }

    /**
     * Show the form for editing the specified destination
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\View\View
     */
    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    /**
     * Update the specified destination in storage
     *
     * @param  \App\Http\Requests\DestinationRequest  $request
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DestinationRequest $request, Destination $destination)
    {
        // Update destination with validated data
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($destination->image) {
                Storage::disk('public')->delete($destination->image);
            }
            
            $data['image'] = $request->file('image')->store('destinations', 'public');
        }
        
        $destination->update($data);
        
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination updated successfully');
    }

    /**
     * Remove the specified destination from storage
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Destination $destination)
    {
        // Delete image if exists
        if ($destination->image) {
            Storage::disk('public')->delete($destination->image);
        }
        
        $destination->delete();
        
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination deleted successfully');
    }
}