<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfileAppController extends Controller
{
    public function handleProfile(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getProfile($request);
            case 'POST':
                return $this->updateImage($request);
            case 'PATCH':
                return $this->updateUserProfile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }
    public function updateImage(Request $request)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => false,
                'error' => __('User not authenticated')
            ], 401);
        }
        $user = Auth::guard('sanctum')->user();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $destinationPath = public_path('images/users/');
            $oldImage = basename($user->image);
            if ($oldImage && File::exists($destinationPath . $oldImage)) {
                File::delete($destinationPath . $oldImage);
            }
            $name = time() . '_' . $image->getClientOriginalName();
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $user->image = "https://aquan.aquan.website/api/show/image/users/$name";
            $user->save();
            return response()->json([
                'status' => true,
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'error' => __('No image uploaded or invalid image')
            ], 400);
        }
    }
    public function updateUserProfile(Request $request)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => false,
                'error' => __('User not authenticated')
            ], 401);
        }
        $user = Auth::guard('sanctum')->user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();
        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }
}
