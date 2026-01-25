<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $employee = Employee::paginate(10);

        //   return Inertia::render('employees/index', [
        //     'employees' => $employee
        // ]);

        $employee = Employee::orderBy('created_at', 'desc')->get();
        $employee->load('channel');
        $employee->load('client');
        $employee->load('user');

        // return EmployeeResource::collection($employee);

         return Inertia::render('employees/index', [
            'employees' => EmployeeResource::collection($employee)
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
            'role' => 'employee',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($validated);

        if($user) {
            $data = [
                'user_id' => $user->id,
                'channel_id' => $request->channel_id,
            ];
            Employee::create($data);
             return redirect()->back()->with('success', 'Employee created successfully!');

        }
         return redirect()->back()->with('error', 'Failed to create employee.');

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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email'      => [
            'required',
            'email',
            'max:250',
            Rule::unique('employees', 'email')->ignore($employee->id),
        ],
            'phone' => 'required|string|max:15',
            'occupation' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $employee->update($validated);

        // return response()->json($employee);

        return redirect()->route('employee.index')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employeeindex')
            ->with('success', 'Employee deleted successfully!');
    }
}
