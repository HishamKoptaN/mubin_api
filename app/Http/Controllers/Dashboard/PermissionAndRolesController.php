<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            $permissions = Permission::select('id', 'name')->get();
            return response()->json([
                'status' => true,
                'roles' => $roles,
                'permissions' => $permissions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve roles',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
