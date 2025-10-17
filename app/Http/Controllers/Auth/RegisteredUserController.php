<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|lowercase|email|max:255|unique:'.User::class,
            'phone' => 'required|string|regex:/^09[0-9]{9}$/|unique:'.User::class,
            'personal_code' => 'required|string|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'position' => 'required|string|in:manager,supervisor,employee,operator',
            'terms' => 'required|accepted',
        ], [
            'name.required' => 'نام کامل الزامی است.',
            'phone.required' => 'شماره همراه الزامی است.',
            'phone.regex' => 'فرمت شماره همراه نامعتبر است.',
            'phone.unique' => 'این شماره همراه قبلاً ثبت شده است.',
            'personal_code.required' => 'کد پرسنلی الزامی است.',
            'personal_code.unique' => 'این کد پرسنلی قبلاً ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'position.required' => 'انتخاب پوزیشن سازمانی الزامی است.',
            'position.in' => 'پوزیشن سازمانی انتخاب شده معتبر نیست.',
            'terms.required' => 'پذیرش قوانین و مقررات الزامی است.',
            'terms.accepted' => 'لطفاً قوانین و مقررات را بپذیرید.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'personal_code' => $request->personal_code,
            'position' => $request->position,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Change this line to redirect to /profile instead of /dashboard
        return redirect('/profile');
    }
}
