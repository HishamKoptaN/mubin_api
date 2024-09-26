<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserTask;
use App\Models\User;

class UserTasksDashboardController extends Controller
{
    public function handleUserTasks(Request $request,$id = null)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getUserTasks($request);
            case 'PATCH':
                return $this->updateTaskStatus($request,$id);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    public function getUserTasks()
    {
           try {
            $userTasks = UserTask::with([
                'user:id,name',
            ])->orderBy('created_at', 'desc')->get();  
            $userTasks->each(function ($userTask) {
                $userTask->user->makeHidden(['id']);
            });
            return response()->json([
                'status' => true,
                'user_tasks' => $userTasks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve User tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateTaskStatus(Request $request, $id)
    {
    $request->validate([
        'status' => 'required|in:rejected,accepted',
    ]);
    try {
        $task = UserTask::find($id);
        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found',
            ], 404);
        }
        $task->status = $request->status;
        $task->save();
        if ($request->status === 'accepted') {
            $user = User::find($task->user_id);
            if ($user) {
                $user->balance += $task->amount;
                $user->save();
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Task status updated successfully',
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
  }
}
