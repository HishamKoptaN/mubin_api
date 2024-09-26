<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{    
    public function handleImages(Request $request, $file, $image)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->showImage($file, $image);
            case 'PATCH':
                return $this->updateDeposit($request, $file);
            case 'POST':
                return $this->uploadImage($request);
            case 'PUT':
                return $this->updateFile($request);
            case 'DELETE':
                return $this->deleteFile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    public function showImage($file, $image)
    {
        $pathToFile = public_path('images' . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . $image);
        if (file_exists($pathToFile)) {
            return response()->file($pathToFile);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $path = $request->file('image')->move(public_path('images'), $request->file('image')->getClientOriginalName());
        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => 'images/' . $request->file('image')->getClientOriginalName()
        ]);
    }
}
