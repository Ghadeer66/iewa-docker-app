<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /**
     * Show business login form
     */
    public function showLoginForm()
    {
        return inertia('Business/Auth/login');
    }

    /**
     * Show business registration form
     */
    public function showRegisterForm()
    {
        return inertia('Business/Auth/Register');
    }

    /**
     * Business login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|regex:/^09[0-9]{9}$/',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if user has business role
            if (!$user->hasRole('business')) {
                Auth::logout();
                return back()->withErrors([
                    'phone' => 'شما دسترسی به پنل کسب‌وکار ندارید.'
                ])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->intended('/business/dashboard');
        }

        return back()->withErrors([
            'phone' => 'اطلاعات وارد شده صحیح نیست.'
        ])->withInput();
    }

    /**
     * Business registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'business_phone' => 'required|string|max:20',
            'business_address' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|regex:/^09[0-9]{9}$/|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'business_name.required' => 'نام کسب‌وکار الزامی است.',
            'business_type.required' => 'نوع کسب‌وکار الزامی است.',
            'business_phone.required' => 'شماره تماس کسب‌وکار الزامی است.',
            'business_address.required' => 'آدرس کسب‌وکار الزامی است.',
            'name.required' => 'نام مسئول الزامی است.',
            'email.required' => 'ایمیل الزامی است.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',
            'phone.required' => 'شماره همراه الزامی است.',
            'phone.regex' => 'فرمت شماره همراه نامعتبر است.',
            'phone.unique' => 'این شماره همراه قبلاً ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد.',
            'terms.required' => 'پذیرش قوانین و مقررات الزامی است.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'business_phone' => $request->business_phone,
            'business_address' => $request->business_address,
            'password' => Hash::make($request->password),
        ]);

        // Assign business role
        $user->assignRole('business');

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/business/dashboard')->with('message', 'ثبت‌نام کسب‌وکار با موفقیت انجام شد');
    }

    /**
     * Business logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/business/login');
    }
}
