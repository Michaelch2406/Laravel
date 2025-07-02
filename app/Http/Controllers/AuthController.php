<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe tener un formato válido',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ]);

        // Intentar autenticar al usuario
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // Regenerar la sesión para prevenir ataques de fijación de sesión
            $request->session()->regenerate();
            
            // Mensaje de éxito
            Session::flash('success', '¡Bienvenido! Has iniciado sesión correctamente.');
            
            // Redirigir al dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Si las credenciales son incorrectas
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->except('password'));
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Invalidar la sesión
        $request->session()->invalidate();
        
        // Regenerar el token CSRF
        $request->session()->regenerateToken();
        
        // Mensaje de éxito
        Session::flash('success', 'Has cerrado sesión correctamente.');
        
        return redirect()->route('login');
    }

    /**
     * Verificar si el usuario está autenticado (para AJAX)
     */
    public function checkAuth()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::user()
        ]);
    }
}

