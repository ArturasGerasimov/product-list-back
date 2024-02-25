<?php

namespace App\Http\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->password = Hash::make($validatedData['password']);
        $user->remember_token = $request->get("rememberToken") ?: false;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
}

