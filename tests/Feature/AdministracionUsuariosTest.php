<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdministracionUsuariosTest extends TestCase
{
    use RefreshDatabase;


    public function test_usuario_administrador_accede_a_administracion_de_usuarios(): void
    {
        //creamos un usuario administrador
        User::create([
            'username' => 'admin1',
            'password' => bcrypt('password123'),
            'es_administrador' => 1
        ]);

        //pasamos el usuario a la peticion post del login
        $response = $this->post('/login', [
            'username' => 'admin1',
            'password' => 'password123'
        ]);

        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a login
        $response->assertRedirect('home');
        //accedemos a administracion de usuarios
        $response = $this->get('/usuario');
        //obtiene el código de página correcta
        $response->assertStatus(200);
    }


    public function test_usuario_no_administrador_no_accede_a_administracion_de_usuarios(): void
    {
        //creamos un usuario no administrador
        User::create([
            'username' => 'usuario',
            'password' => bcrypt('password123'),
            'es_administrador' => 0
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
        //accedemos a administracion de usuarios
        $response = $this->get('/usuario');
        //obtiene el código de redirección a página no permitida
        $response->assertStatus(403);
    }


    public function test_vista_index_contiene_tabla_rellena(): void
    {
        //como mínimo va a tener el usuario administrador
        //obtenemos un usuario administrador
        $admin = $this->getAdminUser();
        //agregamos 10 usuarios aleatorios al sistema
        User::factory(10)->create();
        //accedemos a la vista de usuarios como administrador
        $response = $this->actingAs($admin)->get('/usuario');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos en la tabla esté el administrador
        $response->assertViewHas('users', function ($collection) use ($admin) {
            return $collection->contains($admin);
        });
    }

    public function test_busqueda_en_vista_index_encuentra_resultados(): void
    {
        //como mínimo va a tener el usuario administrador
        //obtenemos un usuario administrador
        $admin = $this->getAdminUser();
        //agregamos 10 usuarios aleatorios al sistema
        User::factory(10)->create();
        //buscamos como administrador los usuarios que contienen el texto admin
        $response = $this->actingAs($admin)->get('/usuario?query=admin');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $users
        $response->assertViewHas('users');
        //El total de usuarios obtenidos en la búsqueda mayro de 0
        $this->assertTrue($response->original->getData()['users']->count() > 0);
    }


    public function test_busqueda_en_vista_index_no_encuentra_resultados(): void
    {
        //como mínimo va a tener el usuario administrador
        //obtenemos un usuario administrador
        $admin = $this->getAdminUser();
        //agregamos 10 usuarios aleatorios al sistema
        User::factory(10)->create();
        //buscamos como administrador los usuarios que contienen el texto este_usuario_no_existe
        $response = $this->actingAs($admin)->get('/usuario?query=este_usuario_no_existe');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $users
        $response->assertViewHas('users');
        //El total de usuarios obtenidos en la búsqueda es 0
        $this->assertTrue($response->original->getData()['users']->count() == 0);
    }



    //la paginacion de la tabla esde 5 elementos, con lo cual el 6º no debe de verse
    public function test_primera_pagina_de_index_paginacion_no_contiene_sexto_elemento(): void
    {
        //agregamos 5 usuarios aleatorios al sistema
        User::factory(5)->create();
        //después agregamos el usuario administrador
        $admin = $this->getAdminUser();
        //accedemos a la vista de usuarios como administrador
        $response = $this->actingAs($admin)->get('/usuario');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos en la tabla no esté el administrador ya que es
        //el sexto elemento y la paginación es de 5 elementos
        $response->assertViewHas('users', function ($collection) use ($admin) {
            return !$collection->contains($admin);
        });
    }

    public function test_creacion_usuario_error_por_validacion(): void
    {
        //recuperamos el usuario administrador
        $admin = $this->getAdminUser();

        //peticion post para crear el usuario
        //no incluimos el acampo password para que nos salte el error de validación
        $usuario = [
            'username' => 'gestor11',
            'es_administrador' => false,
            'es_gestor' => true,
            'es_tecnico' => false,
            'es_consultor' => false
        ];
        $response = $this->actingAs($admin)->post('/usuario', $usuario);

        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la contraseña
        $response->assertSessionHasErrors('password');
    }

    public function test_creacion_usuario_ok(): void
    {
        //recuperamos el usuario administrador
        $admin = $this->getAdminUser();

        //peticion post para crear el usuario
        $usuario = [
            'username' => 'gestor11',
            'password' => '123456789',
            'es_gestor' => true
        ];
        $response = $this->actingAs($admin)->post('/usuario', $usuario);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a usario
        $response->assertRedirect('usuario');
        //comprobamos que el usuario creado exista en la tabla de la base de datos
        $this->assertDatabaseHas('users',  [
            'username' => 'gestor11'
        ]);
    }


    public function test_edicion_usuario_carga_de_campos_ok(): void
    {
        //recuperamos el usuario administrador
        $admin = $this->getAdminUser();
        //creamos un usuario aleatorio
        $usuario = User::factory()->create();
        //peticion get para editar el usuario aleatorio
        $response = $this->actingAs($admin)->get('/usuario/' . $usuario->id . '/edit');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //comprobamos que los campos se han completado en el html recuperado en el response
        $response->assertSee('value="' . $usuario->username . '"', false);
        $response->assertSee('id="es_administrador"' . $usuario->es_administrador == 1 ? ' checked' : '', false);
        $response->assertSee('id="es_gestor"' . $usuario->es_gestor == 1 ? ' checked' : '', false);
        $response->assertSee('id="es_tecnico"' . $usuario->es_tecnico == 1 ? ' checked' : '', false);
        $response->assertSee('id="es_consultor"' . $usuario->es_consultor == 1 ? ' checked' : '', false);
    }


    public function test_edicion_usuario_error_por_validacion(): void
    {

        //recuperamos el usuario administrador
        $admin = $this->getAdminUser();
        //creamos un usuario aleatorio
        $usuario = User::factory()->create();
        //peticion put para editar el usuario aleatorio
        $response = $this->actingAs($admin)->put(
            '/usuario/' . $usuario->id,
            [
                'password' => ''
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la contraseña
        $response->assertSessionHasErrors('password');
    }

    public function test_edicion_usuario_ok(): void
    {

        //recuperamos el usuario administrador
        $admin = $this->getAdminUser();
        //creamos un usuario aleatorio
        $usuario = User::factory()->create();

        //peticion put para editar el usuario aleatorio
        $response = $this->actingAs($admin)->put(
            '/usuario/' . $usuario->id,
            [
                'username' => $usuario->username,
                'password' => '123456789'
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a usario
        $response->assertRedirect('usuario');
        //comprobamos que el usuario editado exista en la tabla de la base de datos
        //no podemos comparar contraseñas con el encriptado
        $this->assertDatabaseHas('users',  [
            'username' => $usuario->username
        ]);
    }



    public function test_eliminar_usuario_ok(): void
    {

        //recuperamos el usuario administrador
        $admin = $this->getAdminUser();
        //creamos un usuario aleatorio
        $usuario = User::factory()->create();

        //peticion delete para eliminar el usuario aleatorio
        $response = $this->actingAs($admin)->delete(
            '/usuario/' . $usuario->id
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a usario
        $response->assertRedirect('usuario');
        //comprobamos que el usuario eliminado ya no exista en la base de datos
        $this->assertDatabaseMissing('users', [$usuario]);
    }


    //funcion privada para crear un usuario con acceso administrador
    private function getAdminUser()
    {
        $user = User::create([
            'username' => 'admin1',
            'password' => bcrypt('password123'),
            'es_administrador' => 1
        ]);

        return $user;
    }
}
