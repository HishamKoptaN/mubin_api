<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Permission;
use App\Traits\ApiResponseTrait;

class UsersDashController extends Controller
{
    use ApiResponseTrait;
    public function handleRequest(
        Request $request,
    ) {
        switch ($request->method()) {
            case 'GET':
                return $this->get(
                    $request,
                );
            case 'POST':
                return $this->uploadFile(
                    $request,
                );
            case 'PUT':
                return $this->updateFile(
                    $request,
                );
            case 'PATCH':
                return $this->updateUser(
                    $request,
                );
            case 'DELETE':
                return $this->deleteFile(
                    $request,
                );
            default:
                return $this->failureResponse();
        }
    }
    protected function get(Request $request)
    {
        try {
            $users = User::with('roles')->get();
            return $this->successResponse(
                $users,
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }
    protected function updateUser(Request $request)
    {
        try {
            $user = User::find(
                $request->id,
            );
            $updateRoles = collect($request->roles)->pluck('id')->toArray();
            $user->roles()->sync($updateRoles);
            $dataToUpdate = [
                "status" => $request->status,
                "balance" => $request->balance,
                "comment" => $request->comment,
            ];
            if ($request->status) {
                $dataToUpdate['inactivate_end_at'] = null;
            } elseif ($request->has('block_type') && $request->has('block_time')) {
                $dataToUpdate['inactivate_end_at'] = $request->block_type === 'permanent'
                    ? Carbon::now()->addYears(10)
                    : Carbon::now()->addDays($request->block_time);
            }
            $user->update(
                $dataToUpdate,
            );
            $userWithRoles = $user->load(
                'roles.permissions',
            );
            return $this->successResponse(
                $userWithRoles
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }

    // protected function updateUser(Request $request)
    // {
    //     if (!$request->has('id')) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => __('User ID is required'),
    //         ], 400);
    //     }
    //     $user = User::find($request->id);
    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => __('User not found'),
    //         ], 404);
    //     }
    //     $dataToUpdate = [
    //         "status"    => $request->status,
    //         "balance"   => $request->balance,
    //         "comment"   => $request->comment,
    //     ];

    //     if ($request->status === 'active') {
    //         $dataToUpdate['inactivate_end_at'] = null;
    //     } elseif ($request->has('block_type') && $request->has('block_time')) {
    //         $dataToUpdate['inactivate_end_at'] = $request->block_type == 'permanent'
    //             ? Carbon::now()->addYears(10)
    //             : Carbon::now()->addDays($request->block_time);
    //     }
    //     $user->update($dataToUpdate);
    //     $permissions = $request->input('permissions');
    //     if (!is_array($permissions) || empty($permissions)) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => __('Permissions should be provided as a non-empty array'),
    //         ], 400);
    //     }

    //     $modelType = 'App\\Models\\User';
    //     $userId = $user->id;
    //     $data = [];

    //     foreach ($permissions as $permissionId) {
    //         $data[] = [
    //             'permission_id' => $permissionId,
    //         ];
    //     }
    //     DB::table('model_has_permissions')->where('model_id', $userId)->delete();
    //     DB::table('model_has_permissions')->insert($data);
    //     return response()->json([
    //         'status' => true,
    //     ], 200);
    // }
}
