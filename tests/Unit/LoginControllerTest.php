<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_cannot_login_with_incorrect_credentials()
    {
        //Crear un nuevo usuario
            $user = new User();
            $user->email = 'test@example.com';
            $user->password = Hash::make('password');
            $user->estado = 1;
            $user->verificacion_email = 0;
            $user->save();
        

        // Intentar iniciar sesión con credenciales incorrectas
        $response = $this->post('/inicia-sesion', [
            'email' => 'test@example.com',  // El email correcto
            'password' => 'incorrectpassword'  // La contraseña incorrecta
        ]);

        // Asegurarse de que el sistema redirige de nuevo al login
        $response->assertRedirect('/login');
        
        // Verificar que se muestre el mensaje de error adecuado
        $response->assertSessionHas('error', 'Las credenciales proporcionadas son incorrectas.');

        // Verificar que el usuario no esté autenticado
        $this->assertGuest();
    }
}
