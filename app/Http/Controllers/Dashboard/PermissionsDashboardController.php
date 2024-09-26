<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission as SpatiePermission;
class PermissionsDashboardController extends Controller
{
   
    public function handlePermissions(Request $request)
    {
        switch ($request->method()) {
              case 'GET':
                return $this->getPermissions($request);
            case 'POST':
                return $this->uploadFile($request);
          
            case 'PUT':
                return $this->updateFile($request);
            case 'DELETE':
                return $this->deleteFile($request);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    
    public function getPermissions()
    {
        $permissions = Permission::get();        
        return response()->json([
            'permissions'=>$permissions,
            'status' => true
        ]);
    }
    public function updateUserPermissions(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $permissions = $request->input('permissions');
        $user->syncPermissions($permissions);
        return response()->json(['message' => 'Permissions updated successfully.']);
    }
    public function addPermissionsToUser(Request $request)
    {
        $user = User::find($request->user_id);
  
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $permissions = $request->input('permissions');
        if (!is_array($permissions) || empty($permissions)) {
            return response()->json(['message' => 'Permissions should be provided as a non-empty array'], 400);
        }
        foreach ($permissions as $permissionName) {
            $permission = Permission::findOrCreate($permissionName);
            $user->givePermissionTo($permission);
        }
        return response()->json(['message' => 'Permissions added successfully']);
    }  
}
