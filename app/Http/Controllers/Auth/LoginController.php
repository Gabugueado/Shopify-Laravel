<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request as ClientRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController {

    public function login(ClientRequest $request) {
        // Validamos los campos que vienen del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Buscamos el usuario por email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'El correo no existe en nuestros registros.',
            ]);
        }

        // Verificamos la contraseña
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ]);
        }

        // Si todo está bien, iniciamos sesión
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    public function showLoginForm() {
        return view('auth.login');
    }
}