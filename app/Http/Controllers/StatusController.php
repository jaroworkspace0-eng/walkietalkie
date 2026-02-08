<?php

namespace App\Http\Controllers;

use App\Events\UserStatusUpdated;
use App\Models\ChannelEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{
    public function updateStatus(Request $request)
    {
        // 1. Find the user first. If not found, it automatically returns a 404.
        $user = User::findOrFail($request->user_id);

        // 2. Update the user status directly on the model
        $user->update([
            'status' => $request->status
        ]);

        Log::error('Status: ', $request->status);
        Log::error('UserId: ', $request->user_id);
        // 3. Get the employee relationship
        $employee = $user->employee; // No need for ->first() if it's a HasOne

        if ($employee) {
            // 4. Update the pivot table for the specific channel
            ChannelEmployee::where('employee_id', $employee->id)
                ->where('channel_id', $request->channel_id)
                ->update([
                    'is_online' => $request->status === 'online' ? 1 : 0,
                    'last_seen' => now(),
                ]);

            // 5. Broadcast the event for real-time UI updates
            broadcast(new UserStatusUpdated($user->id, $request->status))->toOthers();

            return response()->json(['message' => 'Status updated successfully.'], 200);
        }

        return response()->json(['error' => 'Employee profile not found.'], 404);
    }
}
