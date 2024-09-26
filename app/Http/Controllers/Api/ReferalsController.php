<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ReferalsController extends Controller
{   
    public function handleReferals(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getReferrals($request);
            case 'POST':
                return $this->depositMoney($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }
    public function getReferrals(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $users = User::where('refered_by', $user->id)
            ->select('name', 'email')
            ->get()
            ->map(fn ($user) => [
                'name' => $user->name,
                'email' => preg_replace_callback(
                    '/^(.)(.*?)([^@]?)(?=@[^@]+$)/u',
                    function ($m) {
                        return $m[1]
                            . str_repeat("*", max(4, mb_strlen($m[2], 'UTF-8')))
                            . ($m[3] ?: $m[1]);
                    },
                    $user->email
                ),
            ]);
        return response()->json([
            'status' => true,
            'users' => $users,
            'user' => $request->user()
        ]);
    }
}