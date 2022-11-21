<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'min:8', 'max:191', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8', 'max:191', Rules\Password::defaults()],
        ],
        [
            'name.required'     => 'ユーザーネームを入力してください。',
            'email.required'    => 'メールアドレスを入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'name.max'          => 'ユーザーネームは 191文字以下で入力してください。',
            'email.min'         => 'メールアドレスは 8文字以上 で入力してください。',
            'email.max'         => 'メールアドレスは 191文字以下 で入力してください。',
            'password.min'      => 'パスワードは 8文字以上 で入力してください。',
            'password.max'      => 'パスワードは 191文字以下 で入力してください。',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
