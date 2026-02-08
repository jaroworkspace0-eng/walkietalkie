<?php

use App\Http\Controllers\BroadcastAudioController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Models\User;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 1. Eager load the employee and channels immediately to save database queries
    $user = User::with('employee.channel')->where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // 2. Block Admins
    if ($user->role === 'admin') {
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied. Admins must use the web dashboard.'
        ], 403);
    }

    if($user->is_active === 0) {
        return response()->json([
            'status' => 'error',
            'message' => 'Your account is inactive. Please contact the administrator.'
        ], 403);
    }

    // 3. Security: Revoke old tokens before creating a new one (prevents token bloating)
    $user->tokens()->delete();
    $token = $user->createToken('mobile')->plainTextToken;

    // 4. Clean Data Extraction
    // Use optional chaining (?) and collect the names
    // $channels = $user->employee?->channel->pluck('name', 'id') ?? collect([]);

        // 4. Clean Data Extraction
    // We transform the collection into an array of objects
    $channels = $user->employee?->channel->map(function($channel) {
        return [
            'id' => $channel->id,
            'name' => $channel->name,
            // Assuming your Channel model has a relationship to a Company/Client
        ];
    }) ?? collect([]);


    return response()->json([
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'occupation' => $user->occupation,
            'user_id' => $user->id,
        ],
        'channels' => $channels,
        'token' => $token,
        'test' => 'Testin',
    ]);
});

Route::post('/broadcast-audio', [BroadcastAudioController::class, 'store'])
     ->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->post('/broadcast-audio', function (Request $request) {
//     $request->validate([
//         'audio' => 'required|file|mimes:mp3,wav,m4a',
//     ]);

//     $file = $request->file('audio');
//     $path = $file->store('public/audio');

//     // Return the public URL
//     $url = Storage::url($path);

//     return response()->json([
//         'message' => 'Audio uploaded successfully',
//         'url' => $url,
//     ]);
// });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/update-status', [StatusController::class, 'updateStatus'])
    ->middleware('auth:sanctum');


// Route::resource("employees", EmployeeController::class);
Route::prefix('v1')->name('api.')->group(function () {
    Route::apiResource('employees', EmployeeController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('channels', ChannelController::class);
    Route::get('clients/list', [ClientController::class, 'clients']);
    // Route::get('channels/{channel}/units', [ChannelController::class, 'getUnits']);
});

Route::get('channels/{channel}/units', [ChannelController::class, 'getUnits']);





