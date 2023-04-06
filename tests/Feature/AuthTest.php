<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{


    use RefreshDatabase;

    public function test_login_correcto_redirige_a_home(): void
    {
        //creamos un usuario
        User::create([
            'username' => 'usuario',
            'password' => bcrypt('password123')
        ]);

        //pasamos el usuario a la peticion post del login
        $response = $this->post('/login', [
            'username' => 'usuario',
            'password' => 'password123'
        ]);

        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a login
        $response->assertRedirect('home');
    }

    public function test_nombre_usuario_incorrecto(): void
    {
        //creamos un usuario
        User::create([
            'username' => 'usuario',
            'password' => bcrypt('password123')
        ]);

        //pasamos el usuario a la peticion post del login con el nombre de usuario incorrecto
        $response = $this->post('/login', [
            'username' => 'usuario_incorrrecto',
            'password' => 'password123'
        ]);

        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a página principal
        $response->assertRedirect('/');
        //La sesión contiene el error de nombre de usuario incorrecto
        $response->assertSessionHasErrors('username');
    }


    public function test_password_incorrecta(): void
    {
        //creamos un usuario
        User::create([
            'username' => 'usuario',
            'password' => bcrypt('password123')
        ]);

        //pasamos el usuario a la peticion post del login con la contraseña incorrecta
        $response = $this->post('/login', [
            'username' => 'usuario',
            'password' => ''
        ]);

        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a página principal
        $response->assertRedirect('/');
        //La sesión contiene el error de nombre de usuario incorrecto
        $response->assertSessionHasErrors('password');
    }



    public function test_usuario_no_autentificado_no_puede_acceder_a_home(): void
    {
        $response = $this->get('/home');
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a login
        $response->assertRedirect('login');
    }
}
