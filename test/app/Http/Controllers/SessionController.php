<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');  
    }

    public function store() 
    {
        $attrs = request()->validate([
            'email'    => ['required', 'email'],
            'password' => ['required']
        ]); 
        
        if( ! Auth::attempt($attrs) )
        {
            $email = User::where('email', $attrs['email'])->first();
            if( !$email )
            {
                throw ValidationException::withMessages([
                    'email' => 'Sorry, This email is not right!'
                ]);
            }
            else 
            {
                throw ValidationException::withMessages([
                    'password' => 'Sorry, This password is not right!'
                ]);
            }
        }

        // 重新生成 token
        request()->session()->regenerate();
        

        return redirect('/notes');
    }

    public function destory() 
    {
        Auth::logout();  
        return redirect('/');  
    }
}
