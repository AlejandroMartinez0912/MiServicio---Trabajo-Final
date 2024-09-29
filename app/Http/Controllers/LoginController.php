<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class LoginController extends Controller
{
    //
    public function register(Request $request){
        //Validar datos
        /**$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);*/

        //Crear nuevo usuario
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Guardar el usuario en la base de datos
        $user->save();

        // Iniciar sesión automáticamente después de registrarse
        Auth::login($user); 

        return redirect(route('privada')); // Redirigir a la ruta privada
    }   
    //
    public function login(Request $request){
        //Validacion (falta completar)

         $credentials = [
            "email"=>$request->email,
            "password"=>$request->password,

         ];
         $remember =($request->has('remember') ? true: false);

         if (Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();
            return redirect()->intended(route('privada'));
         }
         else{
            return redirect(route('login'));
         }
    }

    //
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
