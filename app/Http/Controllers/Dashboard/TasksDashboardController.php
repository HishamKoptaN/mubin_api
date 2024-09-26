<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TasksDashboardController extends Controller
{
    public function handleTasks(Request $request,$id = null)
    {
        switch ($request->method()) {
           case 'GET':
                return $this->getTasks($request);
           case 'POST':
                return $this->createTask($request);
           case 'PATCH':
                return $this->updateTask($request,$id);
           default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    public function getTasks()
    {
         try {
            $tasks = Task::all();
            return response()->json([
                'status' => true,
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function createTask(Request $request)
    {
        try {
            if ($request->hasFile('image') && $request->file('image') instanceof \Illuminate\Http\UploadedFile) {
                $image = $request->file('image');
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('images/tasks/');
                $image->move($destinationPath, $name);
                $task = Task::create([
                    'status' => $request->input('status'),
                    'name' => $request->input('name'),
                    'link' => $request->input('link'),
                    'description' => $request->input('description'),
                    'amount' => $request->input('amount'),
                    'image' => "https://api.aquan.website/api/show/image/tasks/$name",
                ]);
                return response()->json([
                    'status' => true,
                  
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Image file is required',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
public function updateTask(Request $request, $id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json([
            'status' => false,
            'message' => 'Task not found',
        ], 404);
    }
    try {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('images/tasks/');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $task->image = $name;
        }
        $task->status = $request->input('status');
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->amount = $request->input('amount');
        $task->link = $request->input('link');
        $task->updated_at = \Carbon\Carbon::now();
        $task->save();
        return response()->json([
            'status' => true,
            'message' => 'Task updated successfully',
            'data' => $task,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred: ' . $e->getMessage(),
        ], 500);
    }
  }
}
