<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    public function check()
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => false,
            ], 401);
        }
        $user = Auth::guard('sanctum')->user();
        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }
}
