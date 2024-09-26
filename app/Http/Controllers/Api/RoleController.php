<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as SpatiePermission; // استخدام اسم مستعار
use App\Models\Permission as AppPermission; // استخدام اسم مستعار
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            $permissions = AppPermission::select('id', 'name')->get();
            return response()->json([
                'status' => true,
                'roles' => $roles,           
                'permissions' => $permissions // تغيير اسم المفتاح لتطابق الصيغة
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
