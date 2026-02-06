<?php

namespace App\Http\Controllers;

use App\Events\UserStatusUpdated;
use App\Models\User;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function updateStatus(Request $request)
    {

        $update = User::where('id', $request->user_id)
                    ->update([
                        'status' => $request->status
                    ]);

        if($update) {

            // UserStatusUpdated::dispatch($request->user_id, $request->status);
            broadcast(new UserStatusUpdated($request->user_id, $request->status))->toOthers();
            return response()->json(['message' => 'Status updated successfully.'], 200);
        }

        return response()->json(['error' => 'User not found.'], 404);
    }
}
