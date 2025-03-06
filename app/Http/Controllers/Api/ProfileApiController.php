<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfileApiController extends Controller
{
    public function handleRequest(
        Request $request,
    ) {
        switch ($request->method()) {
            case 'GET':
                return $this->get($request);
            case 'POST':
                return $this->edit($request);
            case 'PATCH':
                return $this->updateUserProfile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }
    public function edit(Request $request)
    {
        try {
            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'error' => __('User not authenticated'),
                ], 401);
            }
            $user = Auth::guard('sanctum')->user();
            $user->image =
                updateImage(
                    $request->file('image'),
                    'users',
                    $user->image
                );
            if ($request->filled('name')) {
                $user->name = $request->name;
            }

            if ($request->filled('address')) {
                $user->address = $request->address;
            }

            if ($request->filled('phone')) {
                $user->phone = $request->phone;
            }
            // $user->save();
            return successResponse(
                $user,
            );
        } catch (\Exception $e) {
            return failureResponse(
                __('Failed to update user: ') . $e->getMessage(),
            );
        }
    }
}
