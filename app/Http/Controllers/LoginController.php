<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

         if(!auth()->attempt($validated)) {
                    return redirect()->back()
                        ->withInput($validated)
                        ->withErrors([
                            'password' => 'Password does not match the email',
                        ]);
                }

                return redirect()->route('admin.dito-numbers.index');
    }
}
