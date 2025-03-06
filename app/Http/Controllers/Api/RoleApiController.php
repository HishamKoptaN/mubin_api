<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\Permission as AppPermission;
use App\Models\Role;

class RoleApiController extends Controller
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
