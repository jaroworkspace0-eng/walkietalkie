<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->paginate(10);
        // return $clients;

          return Inertia::render('Clients/Index', [
            'clients' => $clients
        ]);

    }

    public function clients() {
        dd('testing');
        // return new ClientResource(Client::all());
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
        // return response()->json($request);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        Client::create($validated);

        return redirect()->back()->with('success', 'Client created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Client::all();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return Inertia::render('users.index', ['user' => $client->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
             'email'      => [
            'required',
            'email',
            'max:250',
            Rule::unique('employees', 'email')->ignore($client->id),
        ],
            'phone' => 'required|string',
            'role' => 'required|string'
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

         return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
