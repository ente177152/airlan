<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function Reg(Request $request) {
        $validation = Validator::make($request->all(), [
            'fio'=>['required', 'regex:/[А-Яа-яЁё-]/u'],
            'birthday'=>['required'],
            'passport'=>['required', 'numeric'],
            'login'=>['required', 'unique:users', 'regex:/[A-Za-z0-9-]/u'],
            'phone'=>['required', 'numeric'],
            'email'=>['required', 'unique:users', 'email:frc'],
            'password'=>['required', 'min:6', 'confirmed'],
            'password_confirmation'=>['required'],
            'rules'=>['required'],
        ],
        [
            'fio.required'=>'Поле обязательно для заполнения',
            'fio.regex'=>'Разрешенные символы: кириллица, пробел и тире',
            'birthday.required'=>'Поле обязательно для заполнения',
            'passport.required'=>'Поле обязательно для заполнения',
            'passport.numeric'=>'Разрешены только цифры',
            'login.required'=>'Поле обязательно для заполнения',
            'login.unique'=>'Пользователь с таким логином уже существует',
            'login.regex'=>'Разрешенные символы: латиница, цифры и тире',
            'phone.required'=>'Поле обязательно для заполнения',
            'phone.numeric'=>'Разрешены только цифры',
            'email.required'=>'Поле обязательно для заполнения',
            'email.unique'=>'Пользователь с такой почтой уже существует',
            'email.email'=>'Тип должен соответстовать почте',
            'password.required'=>'Поле обязательно для заполнения',
            'password.min'=>'Минимальное количество симмолов - 6',
            'password.confirmed'=>'Пароли не совпадают',
            'password_confirmation.required'=>'Поле обязательно для заполнения',
            'rules.required'=>'Поле обязательно для заполнения',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $user = new User();

        $user->fio = $request->fio;
        $user->birthday = $request->birthday;
        $user->passport = $request->passport;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->login = $request->login;
        $user->password = md5($request->password);

        $user->save();

        return redirect()->route('AuthPage');
    }

    public function Auth(Request $request) {
        $validation = Validator::make($request->all(), [
            'login'=>['required'],
            'password'=>['required'],
        ],
            [
                'login.required'=>'Поле обязательно для заполнения',
                'password.required'=>'Поле обязательно для заполнения',
            ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $user = User::query()
            ->where('login', $request->login)
            ->where('password', md5($request->password))
            ->first();

        if ($user) {
            Auth::login($user);

            return redirect()->route('HomePage');
        } else {
            return response()->json('Неверный логин или пароль!', 403);
        }
    }

    public function Logout() {
        Auth::logout();

        return redirect()->route('HomePage');
    }

    public function EditProfile(Request $request) {

        $validation = Validator::make($request->all(), [
            'fio'=>['required', 'regex:/[А-Яа-яЁё-]/u'],
            'birthday'=>['required'],
            'passport'=>['required', 'numeric'],
            'login'=>['required', 'regex:/[A-Za-z0-9-]/u'],
            'phone'=>['required', 'numeric'],
            'email'=>['required', 'email:frc'],
            'password'=>['nullable', 'confirmed'],
            'old_password'=>['required', 'min:6'],
        ],
            [
                'fio.required'=>'Поле обязательно для заполнения',
                'fio.regex'=>'Разрешенные символы: кириллица, пробел и тире',
                'birthday.required'=>'Поле обязательно для заполнения',
                'passport.required'=>'Поле обязательно для заполнения',
                'passport.numeric'=>'Разрешены только цифры',
                'login.required'=>'Поле обязательно для заполнения',
                'login.unique'=>'Пользователь с таким логином уже существует',
                'login.regex'=>'Разрешенные символы: латиница, цифры и тире',
                'phone.required'=>'Поле обязательно для заполнения',
                'phone.numeric'=>'Разрешены только цифры',
                'email.required'=>'Поле обязательно для заполнения',
                'email.unique'=>'Пользователь с такой почтой уже существует',
                'email.email'=>'Тип должен соответстовать почте',
                'password.required'=>'Поле обязательно для заполнения',
                'password.min'=>'Минимальное количество симмолов - 6',
                'password.confirmed'=>'Пароли не совпадают',
                'password_confirmation.required'=>'Поле обязательно для заполнения',
                'rules.required'=>'Поле обязательно для заполнения',
            ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $user = User::query()
            ->where('id', Auth::id())
            ->first();

        dd(md5($request->old_password));

        if ($user->password == md5($request->old_password)) {
            $user->fio = $request->fio;
            $user->birthday = $request->birthday;
            $user->passport = $request->passport;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->login = $request->login;
            if ($user->password) {
                $user->password = md5($request->password);
            }
        } else {
            return response()->json('Неверный пароль!', 403);
        }

        $user->update();

            return redirect()->route('UserProfile');
        }
}
