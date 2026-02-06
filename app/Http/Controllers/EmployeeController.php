<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Channel;
use App\Models\ChannelEmployee;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // $employee = Employee::paginate(10);

    //     //   return Inertia::render('employees/index', [
    //     //     'employees' => $employee
    //     // ]);

    //     $employee = Employee::orderBy('created_at', 'desc')->get();
    //     $employee->load('channel');
    //     $employee->load('client');
    //     $employee->load('user');

    //     // return EmployeeResource::collection($employee);

    //      return Inertia::render('employees/index', [
    //         'employees' => EmployeeResource::collection($employee)
    //     ]);
    // }

    public function index()
    {
        $employees = Employee::with(['channel', 'client', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10); // Adjust '10' to however many rows you want per page
                    

        return Inertia::render('employees/index', [
            'employees' => $employees // Raw data, no resource wrapper
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
            'email' => 'required|email|max:250|unique:users,email',
            'phone' => 'required|string|max:15',
            'occupation' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        return DB::transaction(function () use ($request, $validated) {

            $user = User::create(array_merge($validated, ['role' => 'employee']));

            $client_id = Channel::where('id', $request->channel_id)->value('client_id');

            if($user) {
                $data = [
                    'user_id' => $user->id,
                    'client_id' => $client_id, // This is your new direct link!
                    'channel_id' => $request->channel_id,
                ];
                $employee = Employee::create($data);

                // 3. Link the Channel(s)
                // This goes into the channel_employee pivot table automatically
                if ($request->has('channel_id')) {
                    $employee->channel()->syncWithoutDetaching($request->channel_id);
                }

                return redirect()->back()->with('success', 'Employee created and assigned to ' . ($employee->client->name ?? 'client'));

                //  return redirect()->back()->with('success', 'Employee created successfully!');

            }

            return redirect()->back()->with('error', 'Failed to create employee.');

        });

    

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
    public function edit(Employee $employee)
    {
        return Inertia::render('employee.index', ['employee' => $employee->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => [
            'required',
            'email',
            'max:250',
            Rule::unique('users', 'email')->ignore($employee->user_id),
        ],
        'phone' => 'required|string|max:15',
        'occupation' => 'required|string',
        'channel_id' => 'required|exists:channels,id',
        'password' => 'nullable|string|min:8', // Make password optional on update
    ]);

    return DB::transaction(function () use ($request, $validated, $employee) {
        // 1. Update the User record
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'occupation' => $validated['occupation'],
        ];

        // Only update password if a new one is provided
        if (!empty($validated['password'])) {
            $userData['password'] = bcrypt($validated['password']);
        }

        $employee->user->update($userData);

        // 2. Determine client_id from the selected channel (matching your store logic)
        $client_id = Channel::where('id', $request->channel_id)->value('client_id');

        // 3. Update the Employee record
        $employee->update([
            'client_id' => $client_id,
            'phone' => $validated['phone'],
        ]);

        // 4. Sync the Channel (replaces existing links with the new selection)
        if ($request->has('channel_id')) {
            $employee->channel()->sync([$request->channel_id]);
        }

        return redirect()->back()->with('success', 'Employee updated successfully!');
    });
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $user_id = $employee->user_id;
        // First, delete the associated User record
        User::where('id', $user_id)->delete();
        $employee->delete();
        return redirect()->back()->with('success', 'Employee deleted successfully!');
    }
}
