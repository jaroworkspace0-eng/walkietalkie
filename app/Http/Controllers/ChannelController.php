<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $channel = Channel::all();
    //     $channel->load('client');

    //     // return ChannelResource::collection($channel);

    //      return Inertia::render('Channels/index', [
    //         'channels' => ChannelResource::collection($channel)
    //     ]);
    // }
    public function index()
    {
        $channels = Channel::with('client') 
                    ->orderBy('created_at', 'desc')
                    ->paginate(10); 

        return Inertia::render('Channels/index', [
            // This keeps the structure flat: channels.data, channels.links, channels.from
            'channels' => $channels 
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'type' => 'required|string',
            'client_id' => 'required',
        ]);

        Channel::create($validated);

        return redirect()->back()->with('success', 'Channel created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
           return Channel::where('is_active', 1)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $channel)
    {
        // If you are using a separate edit page
        return Inertia::render('Channels/Edit', [
            'channel' => $channel->load('client'),
            'clients' => Client::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Channel $channel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'category' => 'required',
            'type' => 'required',
        ]);

        $channel->update($validated);

        return redirect()->back()->with('success', 'Channel updated successful.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();

            return redirect()->back()->with('success', 'Channel deleted successfully.');
    }

    public function toggleStatus(Channel $channel)
    {
        // Toggle 1 to 0 or 0 to 1
        $channel->update([
            'is_active' => !$channel->is_active
        ]);

        return redirect()->back()->with('success', 'Channels status updated successfully.');
        
    }
}
