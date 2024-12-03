<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskProof;
use App\Models\User;

class TaskProofsDashController extends Controller
{
    public function handleRequest(
        Request $request,
        $id = null,
    ) {
        switch ($request->method()) {
            case 'GET':
                return $this->getTaskProofs(
                    $request,
                );
            case 'PATCH':
                return $this->updateTaskStatus(
                    $request,
                    $id,
                );
            default:
                return $this->failureResponse();
        }
    }
    public function getTaskProofs()
    {
        try {
            $userTasks = TaskProof::with([
                'user:id,name',
            ])->orderBy('created_at', 'desc')->get();
            $userTasks->each(
                function ($userTask) {
                    $userTask->user->makeHidden(['id']);
                },
            );
            return successResponse(
                $userTasks,
            );
        } catch (\Exception $e) {
            return failureResponse(
                $e->getMessage()
            );
        }
    }
    public function updateTaskStatus(
        Request $request,
    ) {
        $request->validate(
            [
                'status' => 'required|in:rejected,accepted',
            ],
        );
        try {
            $task = TaskProof::where('id', $request->id)
                ->with([
                    'user:id,name',
                ])->first();

            $task->status = $request->status;
            $task->save();
            if ($request->status === 'accepted') {
                $user = User::find($task->user_id);
                if ($user) {
                    $user->balance += $task->amount;
                    $user->save();
                }
            }
            return successResponse(
                $task,
            );
        } catch (\Exception $e) {
            return failureResponse(
                $e->getMessage()
            );
        }
    }
}
