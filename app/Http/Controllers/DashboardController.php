<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'channelsCount' => Channel::count(),
                'employeesCount' => Employee::count(),
                'clientsCount' => Client::count(),
            ]
        ]);
    }
}
