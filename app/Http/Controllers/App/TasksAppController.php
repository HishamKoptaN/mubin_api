<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;

class TasksAppController extends Controller
{
    public function handleRequest(
        Request $request,
        $id = null,
    ) {
        switch ($request->method()) {
            case 'GET':
                if ($id) {
                    return $this->getTaskDetails(
                        $request,
                        $id,
                    );
                } else {
                    return $this->getTasks(
                        $request,
                    );
                }
            case 'POST':
                return $this->SubmitTask(
                    $request,
                    $id,
                );
            case 'PUT':
                return $this->updateFile(
                    $request,
                );
            case 'DELETE':
                return $this->deleteFile(
                    $request,
                );
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }

    public function getTasks(): JsonResponse
    {
        $tasks = Task::where([
            'status' => 'active',
        ])->get();
        return response()->json(
            [
                'status' => true,
                'tasks' => $tasks
            ],
        );
    }

    public function getTaskDetails(
        Request $request,
        $id,
    ) {
        $task = Task::where([
            'id' => $id,
            'status' => 'active',
        ])->first();
        if (!$task) {
            return response()->json(
                [
                    'status' => false,
                    'message' => __('Task not found!!')
                ],
            );
        }
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(
                [
                    'status' => false,
                    'message' => __('User not authenticated')
                ],
            );
        }
        return response()->json(
            [
                'status' => true,
                'task' => $task,
                'completed' => UserTask::where(['user_id' => $user->id, 'task_id' => $task->id])->count() > 0
            ],
        );
    }

    protected function SubmitTask(Request $request, $id)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => __('User not authenticated')
            ]);
        }
        $task = Task::withCount([
            'users' => fn($builder) => $builder->where('user_id', $user->id)
        ])
            ->where([
                'id' => $id,
                'status' => 'active',
            ])->first();
        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => __('Task not found')
            ]);
        }
        if ($task->users_count != 0) {
            return response()->json([
                'status' => false,
                'error' => __('You already have completed this task')
            ]);
        }
        $image = $request->image;
        if ($image instanceof \Illuminate\Http\UploadedFile) {
            $name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('images/user_tasks/');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            UserTask::create([
                'status' => "pending",
                'image' => "https://aquan.aquan.website/api/show/image/user_tasks/$name",
                'amount' => $task->amount,
                'task_id' => $task->id,
                'user_id' => $user->id
            ]);
            return response()->json([
                'status' => true,
                'message' => __('Proof has been sent'),
                'completed' => true,
                'task' => $task
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => __('Error try again later.')
        ]);
    }
}
