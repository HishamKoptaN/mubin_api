<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Traits\ApiResponseTrait;
use App\Models\CampaignTemplate as Template;

class TemplateDashController extends Controller
{
    use ApiResponseTrait;
    public function handleRequest(
        Request $request,
        $id = null,
    ) {
        switch ($request->method()) {
            case 'GET':
                return $this->get(
                    $request,
                );
            case 'POST':
                return $this->post(
                    $request,
                );
            case 'PATCH':
                return $this->patch(
                    $request,
                );
            case 'PUT':
                return $this->put(
                    $request,
                    $id,

                );
            case 'DELETE':
                return $this->delete(
                    $id,
                );
            default:
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Invalid request method',
                    ],
                );
        }
    }
    public function get()
    {
        try {
            $templates = Template::all();
            return $this->successResponse(
                $templates,
            );
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }
    public function patch(
        Request $request,
    ) {
        try {
            $template = Template::find(
                $request->id,
            );
            if (!$template) {
                return $this->failureResponse('Template not found');
            }
            $template->update($request->all());
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
    public function put(Request $request)
    {
        try {
            $template = Template::find(
                $request->id,
            );
            if (!$template) {
                return $this->failureResponse('Coupon not found');
            }
            $template->update(
                [
                    'id' => $request->id,
                    '1' => $request->one,
                    '2' => $request->two,
                ],
            );
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
    public function editImage(
        Request $request,
        $id,
    ) {
        try {
            $template = Template::findOrFail(
                $id,
            );
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(
                    public_path('storage/Template'),
                    $imageName,
                );
                $url = asset(
                    'storage/Template/' . $imageName,
                );
            } else {
                $url = $template->image;
            }
            $template->update(
                [
                    'image' => $url,
                ],
            );
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }
    public function delete($id)
    {
        try {
            $template = Template::findOrFail($id);
            $template->delete();
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->failureResponse(
                $e->getMessage(),
            );
        }
    }
}
