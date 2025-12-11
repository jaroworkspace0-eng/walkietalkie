<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $channel = Channel::paginate(10);

         return Inertia::render('channels.index', [
            'channels' => $channel
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

        return redirect()->route('channels.index')
            ->with('success', 'Channel created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $channel)
    {
        // $channel->load('channel');
        return Inertia::render('channel.index', ['channel' => $channel->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Channel $channel)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'type' => 'required|string',
            'client_id' => 'required',
        ]);

        $channel->update();

        return redirect()->route('channels.index')
            ->with('success', 'Channel updated successfully!');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();

        return redirect()->route('channels.index')
            ->with('success', 'Channel deleted successfully!');
    }
}
