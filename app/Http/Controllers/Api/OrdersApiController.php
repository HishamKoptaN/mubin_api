<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Client;
use App\Models\User;
use App\Models\UserBranch;

class OrdersApiController extends Controller
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
                    return failureRes(
                        'ID is required',
                        400,
                    );
                }
                return $this->update(
                    $request,
                    $id,
                );
            case 'DELETE':
                $id = $request->id;
                if (!$id) {
                    return failureRes(
                        'ID is required',
                        400,
                    );
                }
                return $this->destroy(
                    $id,
                );
            default:
                return failureRes(
                    null,
                    405,
                );
        }
    }
    public function uploadImage(Request $request)
{
    if (!$request->hasFile('image')) {
        return response()->json(['error' => 'لم يتم إرسال أي صورة'], 400);
    }

    $image = $request->file('image');

    if (!$image->isValid()) {
        return response()->json(['error' => 'الملف المرفوع غير صالح'], 400);
    }

    // التحقق من الامتداد
    $extension = $image->getClientOriginalExtension();
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array(strtolower($extension), $allowedExtensions)) {
        return response()->json(['error' => 'نوع الملف غير مسموح به'], 400);
    }

    // المسار المباشر داخل public
    $uploadPath = public_path('uploads');

    // التأكد من وجود المجلد
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    // توليد اسم عشوائي للصورة
    $imageName = uniqid() . '.' . $extension;

    // حفظ الصورة في public/uploads
    $image->move($uploadPath, $imageName);

    // التأكد أن الصورة انحفظت فعلاً
    if (!file_exists($uploadPath . '/' . $imageName)) {
        return response()->json(['error' => 'فشل في رفع الصورة'], 500);
    }

    // إرجاع الرابط الكامل
    $imageUrl = asset('uploads/' . $imageName);

    return response()->json([
        'image_url' => $imageUrl
    ]);
}

    public function getOrders()
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return failureRes('Unauthorized', 401);
        }
        $branchIds = UserBranch::where('user_id', $user->id)->pluck('branch_id');
        $orders = Order::orderBy('created_at', 'desc')->whereIn('branch_id', $branchIds)->paginate(10);
        return successRes(
            new OrderCollection(
                $orders,
            ),
        );
    }
        public function addOrder(Request $request,
        )
        {
            try {
                $user = Auth::guard('sanctum')->user();
                if (!$user) {
                    // إذا لم يكن المستخدم مصادق، استخدم المستخدم الافتراضي (ID=1)
                    $user = User::find(1);
                    if (!$user) {
                        return failureRes('Fallback user not found', 404);
                    }
                }
                // $firstRole = $user->roles()->first();
                // if (!$firstRole) {
                //     return failureRes(
                //         'No roles found for the user',
                //         404,
                //     );
                // }
                $clientExists = Client::where('id', $request->client_id)->exists();
                if (!$clientExists) {
                    return failureRes('Client not found', 404);
                }
                $order = Order::create(
                    [
                        'client_id' => $request->client_id,
                        'place'     =>  $request->place,
                        'latitude'  => $request->latitude,
                        'longitude' => $request->longitude,
                        'branch_id' =>  $firstRole->id ?? 1,
                    ],
                );
                $storagePath = "{$request->client_id}/{$order->id}";
                $imageOnePath = $request->file('image_one')
                    ? $request->file('image_one')->storeAs($storagePath, 'image_one.' . $request->file('image_one')->getClientOriginalExtension(), 'orders')
                    : null;
                $imageTwoPath = $request->file('image_two')
                    ? $request->file('image_two')->storeAs($storagePath, 'image_two.' . $request->file('image_two')->getClientOriginalExtension(), 'orders')
                    : null;
                $videoPath = $request->file('video')
                    ? $request->file('video')->storeAs($storagePath, 'video.' . $request->file('video')->getClientOriginalExtension(), 'orders')
                    : null;
                $order->update(
                    [
                        'image_one' => asset('orders/' . $imageOnePath),
                        'image_two' => asset('orders/' . $imageTwoPath),
                        'video'     =>  asset('orders/' . $videoPath),
                    ],
                );
                return successRes(
                    new OrderResource(
                        $order->fresh(),
                    ),
                );
            } catch (\Exception $e) {
                return failureRes(
                    $e->getMessage(),
                );
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
        return  successRes(
            null,
            204,
        );
    }
}
