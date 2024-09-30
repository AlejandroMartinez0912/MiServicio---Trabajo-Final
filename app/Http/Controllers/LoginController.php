<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Registra un nuevo usuario en la aplicación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validar los datos de entrada
        /*
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]); */

        // Crear un nuevo usuario
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password = Hash::make($request->password);

        // Guardar el usuario en la base de datos
        $user->save();

        // Iniciar sesión automáticamente después de registrarse
        Auth::login($user); 
        // Redirigir a la ruta privada
        return redirect()->route('privada');
    }

    /**
     * Inicia sesión en la aplicación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validar los datos de entrada
        
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Obtener las credenciales del usuario
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Verificar si el usuario desea que se lo recuerde

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials, $remember)) {
            // Regenerar la sesión para mayor seguridad
            $request->session()->regenerate();

            // Redirigir a la ruta privada después de iniciar sesión
            return redirect()->intended(route('privada'));
        }

        // Redirigir de vuelta a la página de inicio de sesión con un mensaje de error
        return redirect()->route('login')->withErrors(['email' => 'Las credenciales proporcionadas son incorrectas.']);
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Cerrar la sesión del usuario
        Auth::logout();

        // Invalidar la sesión y regenerar el token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir a la página principal
        return redirect()->route('home');
    }
}
