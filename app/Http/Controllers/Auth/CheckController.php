<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;

class CheckController extends Controller
{
    use ApiResponseTrait;
    public function check()
    {
        try {
            if (!Auth::guard('sanctum')->check()) {
                return $this->failureResponse(
                    [],
                    401,
                );
            }
            $user = Auth::guard('sanctum')->user();
            return $this->successResponse(
                $user,
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }
}
