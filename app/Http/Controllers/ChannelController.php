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
   
    public function index()
    {
       
    }

// fetch channels for the app
    public function getChannels(Request $request)
    {
        
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
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
       

    }

    public function toggleStatus(Channel $channel)
    {
       

        
    }

public function getUnits(Channel $channel)
{

}
}
