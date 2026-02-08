<?php

namespace App\Http\Controllers;

use App\Events\UserStatusUpdated;
use App\Models\ChannelEmployee;
use App\Models\User;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function updateStatus(Request $request)
    {

        $user = User::where('id', $request->user_id)
                    ->update([
                        'status' => $request->status
                    ]);

        if($user) {

           ChannelEmployee::where('employee_id', $user->employee->id) // Eloquent handles the fetch automatically
                ->where('channel_id', $request->channel_id)
                ->update([
                    'is_online' => $request->status === 'online' ? 1 : 0,
                    'last_seen' => now(), // 💡 Add this to track heartbeats!
                ]);
            broadcast(new UserStatusUpdated($request->user_id, $request->status))->toOthers();
            return response()->json(['message' => 'Status updated successfully.'], 200);
        }

        return response()->json(['error' => 'User not found.'], 404);
    }
}
