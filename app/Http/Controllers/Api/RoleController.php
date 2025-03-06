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
            $permissions = AppPermission::select(
                'id', 'name',
            )->get();
            return successRes([
                'roles' => $roles,
                'permissions' => $permissions
            ],
            );
        } catch (\Exception $e) {
            return failureRes(
                $e->getMessage(),
            );
        }
    }
}
