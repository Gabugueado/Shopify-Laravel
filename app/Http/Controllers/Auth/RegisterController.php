<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request as ClientRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController {
    public function register(ClientRequest $request){

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $hashedPass = Hash::make($password);
        $user = User::create([
            'name'=> $name,
            'email'=> $email,
            'password'=> $hashedPass
        ]);
        Auth::login($user);
        return redirect()->route('login')->with('status', 'Usuario creado con éxito.');
    }

    public function showRegisterForm() {
        return view('auth.register');
    }
}
