<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Mail\Confirmation;
use App\Mail\Reset;
use App\Models\JobExperience;
use App\Models\User;
use App\Notifications\ConfirmNotification;
use App\Notifications\NewUserNotification;
use App\Rules\Phone;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
        public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user = auth()->user();
        $path = $request->file('image')->store('profile_pictures', 'public');

        $user->image = $path;
        $user->save();

        return response()->json(['message' => 'Profile picture uploaded successfully', 'path' => $path], 200);
    }

    public function getProfilePicture($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_picture) {
            $path = storage_path('app/public/' . $user->image);
            if (file_exists($path)) {
                return response()->file($path);
            }
        }

        return response()->json(['message' => 'Profile picture not found'], 404);
    }
    
   public function updateAccountInfo(Request $request)
    {
        $user = Auth::user(); 

        // Validate the request
        $request->validate([
            'accountInfo' => 'required|array',
            'accountInfo.*.currency' => 'required|string',
            'accountInfo.*.value' => 'required|numeric',
        ]);

        // Update the user's account info
        $user->account_info = json_encode($request->accountInfo);
        $user->save();

        return response()->json([
            'message' => 'Account information updated successfully',
            'user' => $user,
        ], 200);
    }
      public function index()
    {
         
         return response()->json([
                'status' => false,
                'user' => User::all()
            ]);
    }

    // تخزين مستخدم جديد
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => true,
            'user' => $user
        ]);
    }

    // عرض مستخدم محدد
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // تحديث مستخدم
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return response()->json([
            'status' => true,
            'user' => $user
        ]);
    }

    // حذف مستخدم
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => __('User deleted successfully.')
        ]);
    }
    
    
    
    
    public function getEmployees()
    {
        $employees = User::where('role', 'employee')->get();
        return response()->json($employees);
    }
    public function addRoleToUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $role = $request->role;

        if (Role::where('name', $role)->where('guard_name', 'api')->exists()) {
            $user->assignRole($role, 'api');
            return response()->json(['status' => true, 'message' => 'Role added successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Role does not exist']);
        }
    }

    public function checkUserRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $role = $request->role;

        if ($user->hasRole($role, 'api')) {
            return response()->json(['status' => true, 'message' => 'User has the role']);
        } else {
            return response()->json(['status' => false, 'message' => 'User does not have the role']);
        }
    }

    public function getUserRoles(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $roles = $user->getRoleNames();

        return response()->json(['status' => true, 'roles' => $roles]);
    }
    
 //Resend code
    public function Resendcode(Request $request)
    {
        try {
            $input = $request->validate([
                'email' => 'required',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Enter a valid email address',
               'status' => false,
            ], 400);
        }
        $user = User::where('id', auth()->id())->first();
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified',
                'status' => false,
            ], 403);
        }
        $user->confirmation_code = rand(111111, 999999);
        $user->email = $input['email'];
        $user->save();
        Mail::send(new Confirmation($user));
        return response()->json([
            'message' => 'Resend code successful',
           'status' => true,
        ], 200);
    }

    public function checkUserStatus($userId)
    {
        // البحث عن المستخدم حسب معرف المستخدم
        $user = User::find($userId);

        // التحقق مما إذا كان المستخدم موجودًا
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // التحقق من حالة المستخدم
        $isActive = ($user->status === 'active');

        // إرجاع الاستجابة بحالة المستخدم
        return response()->json([
            'status' => $isActive,
        ], 200);
    }

    //Create nwe user
    public function createUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'user_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            // 'phone_number' => ['required', 'unique:users,phone_number', new Phone],
            'password' => 'required|string',

        ]);
        if ($validate->fails()) {
            return $this->sendResponse($validate->errors()->all(), null, 400);
        }
        if ($request->hasFile('image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $data['image'] = $uploadedFileUrl;
        }

        $password = Hash::make($request->password);
        $code = rand(000000, 999999);
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->user_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => $password,
                'confirmation_code' => $code,
            ]);
        } catch (Exception $e) {
            return $this->sendResponse($e->getMessage(), null, 400);
        }
        Notification::send($user, new NewUserNotification($user, $user->confirmation_code));
        return $this->sendResponse('Account created successfully, proceed to login', null, 201);
    }

    public function confirmEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|exists:user.email',
            ]);


            $user = auth()->user();
            if ($user->email !== $request->email) return $this->sendResponse('Please enter a correct email address', null, 400);
           return $this->sendResponse('kkk', $user, 200);

            if (!$user) {
                return $this->sendResponse('User not found', null, 404);
            }

            if ($user->hasVerifiedEmail()) {
                return $this->sendResponse('Email already verified', null, 403);
            }
            $user->confirmation_code = rand(100000, 999999);
            $user->save();

            Notification::send($user, new ConfirmNotification($user, $user->confirmation_code));

            return $this->sendResponse('Confirmation code sent successfully', null, 200);
        } catch (Exception $e) {
            return $this->sendResponse($e->getMessage(), $user, 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors()->all(), null, 422);
        }
        $user = auth()->user();
        if ($user->hasVerifiedEmail()) {
            return $this->sendResponse('Email already verified', null, 403);
        }
        if ($request->code == $user->confirmation_code) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
                try {
                    // sendSms($user->phone_number, 'Email verified');
                } catch (Exception $e) {
                     return response()->json([
                'status' => false,
                'error' => $th->getMessage(),
                ]);
                }
            }
             return response()->json([
                    'status' => true,
                ]);
        } else {
          return response()->json([
                    'status' => false,
                ]);
        }
    }

  

    //Logout
    public function logout(Request $request)
    {
        $user = User::where('id', auth()->id())->first();
        auth()->user()->token()->revoke();


        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }

    //Get user with token on main page
    public function getUser(Request $request)
    {
        $authUser = auth()->user()->load('experience', 'education');

        return $this->sendResponse('User returned successfully', $authUser, 200);
    }

    public function getUserListing()
    {
        $user = User::whereId(auth()->id())->first();
        $userPost = $user->thejob;
        if ($userPost === null) return $this->sendResponse('User has no jobs', null, 400);
        return $this->sendResponse('User jobs returned successfully', $userPost, 200);
    }

  

   

    public function ResetPassword(Request $request)
    {
        try {
            $input = $request->validate([
                'email' => 'required|email',
            ]);
        } catch (Exception) {
            return response()->json([
                'message' => 'Enter a valid email address',
                'error' => true,
                'data' => null,
            ], 400);
        }

        $email = $input['email'];
        $user = User::where('email', $email)->first();
        $user['reset_code'] = rand(33333, 99999);
        $user->save();
        Mail::send(new Reset($user));

        return response()->json([
            'message' => 'Reset code was sent successfully',
            'error' => false,
        ], 200);
    }

    public function VerifyResetCode(Request $request)
    {
        try {
            $input = $request->validate([
                'reset_code' => 'required',
            ]);
        } catch (Exception) {
            return response()->json([
                'message' => 'Enter a valid reset code',
                'error' => true,
                'data' => null,
            ], 400);
        }

        $user = User::where('reset_code', $input['reset_code'])->first();
        $token = $user->createToken('access-token')->accessToken;

        return response()->json([
            'message' => 'Reset code was successfully confirmed',
            'token' => $token,
        ], 200);
    }

    public function ChangePassword(Request $request)
    {
        try {
            $input = $request->validate([
                'password' => 'required',
                'confirm_password' => 'required',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
                'data' => null,
            ], 400);
        }

        $user = User::where('id', auth()->id())->first();
        if ($input['password'] == $input['confirm_password']) {
            $user->password = bcrypt($input['password']);
            $user->save();

            return response()->json([
                'message' => 'Password changed successfully',
                'data' => $user,
                'error' => false,
            ], 200);
        }
    }

    public function updateProfile(Request $request)
    {
    $user = auth()->user();
    $data = $request->only(['name', 'phone_number', 'image', 'cv']); // فقط الحقول المسموح بتحديثها
    // تحديث الصورة إذا كانت موجودة في الطلب
    if ($request->hasFile('image')) {
        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        $data['image'] = $uploadedFileUrl;
    }
    // تحديث السيرة الذاتية (CV) إذا كانت موجودة في الطلب
    if ($request->hasFile('cv')) {
        $uploadedFileUrl = Cloudinary::uploadFile($request->file('cv')->getRealPath())->getSecurePath();
        $data['cv'] = $uploadedFileUrl;
    }
    // تحديث البيانات الأخرى
    if ($request->has('name')) {
        $data['name'] = $request->input('name');
    }
    if ($request->has('phone_number')) {
        $data['phone_number'] = $request->input('phone_number');
    }
    $user->update($data);
    return $this->sendResponse('Updated successfully', null, 200);
    }

    public function notAuth()
    {
        $this->sendResponse('User not authenticated', null, 401);
    }
}
