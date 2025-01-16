<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;

class OrdersAppController extends Controller
{
    public function handleOrders(
        Request $request,
    ) {
        switch ($request->method()) {
            case 'GET':
                return $this->getOrders();
            case 'POST':
                return $this->addOrder(
                    $request
                );
            case 'PUT':
            case 'PATCH':
                $id = $request->id;
                if (!$id) {
                    return response()->json(['status' => false, 'message' => 'ID is required'], 400);
                }
                return $this->update($request, $id);
            case 'DELETE':
                $id = $request->id;
                if (!$id) {
                    return response()->json(['status' => false, 'message' => 'ID is required'], 400);
                }
                return $this->destroy($id);
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method'], 405);
        }
    }
    public function getOrders()
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $firstPermission = $user->permissions()->first();
        if (!$firstPermission) {
            return response()->json(['message' => 'No permissions found for the user'], 404);
        }
        $orders = Order::where('branch_id', $firstPermission->id)->get();
        return response()->json([
            'status'     => true,
            'permission' => $firstPermission->name,
            'orders'     => $orders,
        ], 200);
    }

    public function addOrder(Request $request)
    {
        try {
            $validatedData = $request->validate(
                [
                    'latitude'  => 'required',
                    'longitude' => 'required',
                    'image_one' => 'required|file|mimes:jpeg,png,jpg,gif',
                    'image_two' => 'required|file|mimes:jpeg,png,jpg,gif',
                    'video'     => 'required|file|mimes:mp4',
                    'place'     => 'required',
                    'client_id' => 'required',
                ],
            );
            $user = Auth::guard('sanctum')->user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $firstPermission = $user->permissions()->first();
            if (!$firstPermission) {
                return response()->json(['message' => 'No permissions found for the user'], 404);
            }
            $order = Order::create(
                [
                    'latitude'  => $validatedData['latitude'],
                    'longitude' => $validatedData['longitude'],
                    'place'     => $validatedData['place'],
                    'branch_id' => $firstPermission->id,
                    'client_id' => $validatedData['client_id'],
                ],
            );
            $permissionName = $firstPermission->name;
            $orderId = $order->id;
            $orderFolder = $permissionName . '/' . $orderId;
            $orderPath = public_path('orders/' . $orderFolder);
            if (!file_exists($orderPath)) {
                mkdir($orderPath, 0777, true);
            }
            $imageOnePath = $request->hasFile('image_one')
                ? $request->file('image_one')->move($orderPath, 'image_one.' . $request->file('image_one')->getClientOriginalExtension())
                : null;

            $imageTwoPath = $request->hasFile('image_two')
                ? $request->file('image_two')->move($orderPath, 'image_two.' . $request->file('image_two')->getClientOriginalExtension())
                : null;

            $videoPath = $request->hasFile('video')
                ? $request->file('video')->move($orderPath, 'video.' . $request->file('video')->getClientOriginalExtension())
                : null;
            $order->update(
                [
                    'image_one' => $imageOnePath ? "https://mubin.aquan.website/api/show/file/$permissionName/$orderId/" . basename($imageOnePath) : null,
                    'image_two' => $imageTwoPath ? "https://mubin.aquan.website/api/show/file/$permissionName/$orderId/" . basename($imageTwoPath) : null,
                    'video'     => $videoPath    ? "https://mubin.aquan.website/api/show/file/$permissionName/$orderId/" . basename($videoPath)    : null,
                ],
            );
            return response()->json(['status' => true], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $orderFolder = $order->branch->name . '/' . $order->id;
        $orderPath = storage_path('app/orders/' . $orderFolder);
        if (file_exists($orderPath)) {
            array_map('unlink', glob("$orderPath/*"));
            rmdir($orderPath);
        }
        $order->delete();
        return response()->json(
            null,
            204,
        );
    }
}
