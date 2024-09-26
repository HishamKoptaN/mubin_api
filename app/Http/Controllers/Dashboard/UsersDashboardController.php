<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Permission;

    class UsersDashboardController extends Controller
    {
    public function handleUsers(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getAllUsers($request);
            case 'POST':
                return $this->uploadFile($request);
            case 'PUT':
                return $this->updateFile($request);
            case 'PATCH':
                return $this->updateUser($request);
            case 'DELETE':
                return $this->deleteFile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    protected function getAllUsers(Request $request)
    {
        try {
            $users = User::all();  
            $usersWithPermissions = $users->map(function ($user) {
                $user_permissions = DB::table('user_has_permissions')
                    ->join('permissions', 'user_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('user_has_permissions.user_id', $user->id)
                    ->select('permissions.name', 'user_has_permissions.permission_id')
                    ->get();
           
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status,
                    'balance' => $user->balance,
                    'plan_id' => $user->plan_id,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'comment' => $user->comment,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'upgraded_at' => $user->updated_at,
                    'inactivate_end_at' => $user->inactivate_end_at,
                    'user_permissions' => $user_permissions,
                ];
            });
            $permissions = Permission::all();
            return response()->json([
                'status' => true,
                'users' => $usersWithPermissions,
                'permissions' => $permissions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    protected function updateUser(Request $request)
    {
        if (!$request->has('id')) {
            return response()->json([
                'status' => false,
                'message' => __('User ID is required'),
            ], 400);
        }
        $user = User::find($request->id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => __('User not found'),
            ], 404);
        }
        $dataToUpdate = [
            "status"    => $request->status,
            "balance"   => $request->balance,
            "comment"   => $request->comment,
        ];
    
        if ($request->status === 'active') {
            $dataToUpdate['inactivate_end_at'] = null;
        } elseif ($request->has('block_type') && $request->has('block_time')) {
            $dataToUpdate['inactivate_end_at'] = $request->block_type == 'permanent'
                ? Carbon::now()->addYears(10)
                : Carbon::now()->addDays($request->block_time);
        }
        $user->update($dataToUpdate);
        $permissions = $request->input('permissions');
        if (!is_array($permissions) || empty($permissions)) {
            return response()->json([
                'status' => false,
                'message' => __('Permissions should be provided as a non-empty array'),
            ], 400);
        }
    
        $modelType = 'App\\Models\\User';
        $userId = $user->id;
        $data = [];
    
        foreach ($permissions as $permissionId) {
            $data[] = [
                'permission_id' => $permissionId,
            ];
        }
        DB::table('model_has_permissions')->where('model_id', $userId)->delete();
        DB::table('model_has_permissions')->insert($data);
        return response()->json([
            'status' => true,
        ], 200);
    }
}