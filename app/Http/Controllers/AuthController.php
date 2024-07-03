<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $user = User::where('username', $request->username)->first();

        //التحقق من وجود المستخدم
        if (! $user) {
            return response()->json(["message"=>"User not found!"],401);
        }
        //التحقق من كلمة المرور
        if ($user->password!=$request->input("password")) {
            return response()->json(["message"=>"Wrong password!"]);
        }

       return response()->json(['id'=>$user->id]);



    }






































// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;
// use Illuminate\Validation\ValidationException;

// class AuthController extends Controller
// {
//     public function login(Request $request)
//     {
//         // التحقق من صحة البيانات المدخلة
//         $request->validate([
//             'username' => 'required',
//             'password' => 'required',
//         ]);

//         $credentials = $request->only('username', 'password');

//         // محاولة تسجيل الدخول باستخدام البيانات المدخلة
//         if (Auth::attempt($credentials)) {
//             // تسجيل الدخول بنجاح، استرجاع معلومات المستخدم
//             $user = Auth::user();
//             return response()->json(['user' => $user], 200);
//         }

//         // في حالة عدم التوافق، إرسال رد برسالة خطأ
//         return response()->json(['error' => 'المعلومات المدخلة غير صحيحة.'], 401);
//     }

//     public function logout(Request $request)
//     {
//         Auth::logout();
//         return response()->json(['message' => 'تم تسجيل الخروج بنجاح.']);
//     }
}
















































?>
