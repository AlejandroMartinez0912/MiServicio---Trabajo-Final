<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;
use App\Models\Auditoria;


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
        //Validar usuario
        $this->validateRegister($request);

        // Crear un nuevo usuario
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "user";
        $user->estado = 1;
        $user->save();

        // Crear automáticamente el perfil (persona) asociado al usuario
        $persona = new Persona();
        $persona->user_id = $user->id;
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->domicilio = $request->domicilio;
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->documento = $request->documento;
        $persona->telefono = $request->telefono;

        $persona->save();

        $auditoria = new Auditoria();
        $auditoria->user_id = $user->id;
        $auditoria->accion = 'Creación';
        $auditoria->modulo = 'Usuarios';
        $auditoria->detalles = 'El usuario creó un nuevo usuario';
        $auditoria->ip = request()->ip();
        $auditoria->save();
        


        // Iniciar sesión automáticamente después de registrarse
        Auth::login($user);
        
        // Redirigir a la ruta privada
        return redirect()->route('homein');
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

            // Verificar si el usuario es administrador
            $user = Auth::user(); // Obtén al usuario autenticado

            if ($user->role === 'admin') {
                // Redirigir al panel de administrador
                return redirect()->route('index-admin');
            }

            // Verificar el estado del usuario
            if ($user->estado == 0) {
                // Redirigir con un mensaje de error si el estado es 0
                return redirect()->route('login')->with(['error' => 'Tu cuenta está inactiva. Por favor, contacta al administrador.']);
            }

            // Redirigir a la página principal de usuarios normales
            return redirect()->route('homein');
        }

        // Redirigir de vuelta a la página de inicio de sesión con un mensaje de error
        return redirect()->route('home')->withErrors(['email' => 'Las credenciales proporcionadas son incorrectas.']);
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
   /**
    * Funcion para validar registro
    */
    public function validateRegister(Request $request){
        // Validar los datos de entrada con mensajes personalizados
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'domicilio' => 'nullable|string|max:100',
            'fecha_nacimiento' => [
                'required',
                'date',
                'before:today',
                function ($attribute, $value, $fail) {
                    $edad = \Carbon\Carbon::parse($value)->age;
                    if ($edad < 18) {
                        $fail('Debes tener al menos 18 años.');
                    }
                }
            ],
            'documento' => 'nullable|numeric|unique:persona,documento|max:999999999', // Máximo 9 dígitos
            'telefono' => 'nullable|string|max:15',
        ], [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 50 caracteres.',
            'apellido.required' => 'El campo apellido es obligatorio.',
            'apellido.max' => 'El apellido no debe superar los 50 caracteres.',
            'domicilio.max' => 'El domicilio no debe superar los 100 caracteres.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'Debes tener al menos 18 años.',
            'documento.numeric' => 'El documento debe contener solo números.',
            'documento.unique' => 'Este documento ya está registrado.',
            'documento.max' => 'El documento no debe tener más de 9 dígitos.',
            'telefono.max' => 'El teléfono no debe superar los 15 caracteres.',
        ]);
    }
}
