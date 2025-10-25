<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new user with personnel information
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'personal_code' => 'required|string|unique:users,personal_code',
            'phone' => 'required|string|regex:/^09[0-9]{9}$/|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'required|string|in:manager,supervisor,employee,operator',
            'terms' => 'required|accepted',
        ], [
            'name.required' => 'نام کامل الزامی است.',
            'email.email' => 'فرمت ایمیل نامعتبر است.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',
            'personal_code.required' => 'کد پرسنلی الزامی است.',
            'personal_code.unique' => 'این کد پرسنلی قبلاً ثبت شده است.',
            'phone.required' => 'شماره همراه الزامی است.',
            'phone.regex' => 'فرمت شماره همراه نامعتبر است.',
            'phone.unique' => 'این شماره همراه قبلاً ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد.',
            'password.confirmed' => 'تکرار رمز عبور با رمز عبور مطابقت ندارد.',
            'position.required' => 'انتخاب پوزیشن سازمانی الزامی است.',
            'position.in' => 'پوزیشن سازمانی انتخاب شده معتبر نیست.',
            'terms.required' => 'پذیرش قوانین و مقررات الزامی است.',
            'terms.accepted' => 'لطفاً قوانین و مقررات را بپذیرید.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, // Can be null
            'personal_code' => $request->personal_code,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'position' => $request->position,
        ]);

        // Log the user in automatically after registration
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/profile')->with('message', 'ثبت‌نام شما با موفقیت انجام شد');
    }

    /**
     * Login user with phone number or personnel code
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ], [
            'phone.required' => 'شماره همراه یا کد پرسنلی الزامی است.',
            'password.required' => 'رمز عبور الزامی است.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find user by phone or personnel code
        $user = User::where('phone', $request->phone)
                    ->orWhere('personal_code', $request->phone)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'phone' => 'شماره همراه/کد پرسنلی یا رمز عبور اشتباه است.'
            ])->withInput();
        }

        Auth::login($user, $request->remember);
        $request->session()->regenerate();

        return redirect()->intended('/')->with('message', 'ورود موفقیت آمیز بود');
    }

    public function showRegistrationForm()
{
    return inertia('auth/Register');
}

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'خروج موفقیت آمیز بود');
    }
}
