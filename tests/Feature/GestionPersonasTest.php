<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GestionPersonasTest extends TestCase
{
    use RefreshDatabase;

    //test para comprobar que un usuario gestor puede acceder a la vista de gestión de personas
    public function test_usuario_gestor_accede_a_gestion_de_personas(): void
    {
        //creamos un usuario gestor
        User::create([
            'username' => 'gestor1',
            'password' => bcrypt('password123'),
            'es_gestor' => 1
        ]);

        //pasamos el usuario a la peticion post del login
        $response = $this->post('/login', [
            'username' => 'gestor1',
            'password' => 'password123'
        ]);

        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a login
        $response->assertRedirect('home');
        //accedemos a gestion de personas
        $response = $this->get('/persona');
        //obtiene el código de página correcta
        $response->assertStatus(200);
    }


    //test para comprobar que un usuario no gestor no puede acceder a la vista de gestión de personas
    public function test_usuario_no_gestor_no_accede_a_gestion_de_personas(): void
    {
        //creamos un usuario no gestor
        User::create([
            'username' => 'usuario',
            'password' => bcrypt('password123'),
            'es_gestor' => 0
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
        //accedemos a gestión de personas
        $response = $this->get('/persona');
        //obtiene el código de redirección a página no permitida
        $response->assertStatus(403);
    }

    //test para comprobar que se muestra la tabla de personas en la vista de gestión de personas
    public function test_vista_index_contiene_tabla_rellena(): void
    {
        //obtenemos un usuario gesstor
        $gestor = $this->getGestorUser();
        //agregamos 10 personas aleatorias al sistema
        $personas = Persona::factory(10)->create();
        //accedemos a la vista de personas como gestor
        $response = $this->actingAs($gestor)->get('/persona');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos esta la primera persona aleatoria generada
        $response->assertViewHas('personas', function ($collection) use ($personas) {
            return $collection->contains($personas->first());
        });
    }

    //test para comprobar que se recupera resultados al buscar en la vista de gestión de personas
    public function test_busqueda_en_vista_index_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 personas aleatorias al sistema
        $personas = Persona::factory(10)->create();
        //recuperamos la primera persona aleatoria
        $firstPersona = $personas->first();
        //buscamos como gestor la persona que coincide con la primera persona aleatoria
        $response = $this->actingAs($gestor)->get('/persona?query=' . $firstPersona->nombre);
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $personas
        $response->assertViewHas('personas');
        //El total de personas obtenidos en la búsqueda mayor de 0
        $this->assertTrue($response->original->getData()['personas']->count() > 0);
    }

    //test para comprobar que no se recupera resultados al buscar en la vista de gestión de personas
    public function test_busqueda_en_vista_index_no_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 personas aleatorias al sistema
        $personas = User::factory(10)->create();
        //buscamos como gestor las personas que contienen el texto esta_persona_no_existe
        $response = $this->actingAs($gestor)->get('/persona?query=esta_persona_no_existe');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $personas
        $response->assertViewHas('personas');
        //El total de personas obtenidas en la búsqueda es 0
        $this->assertTrue($response->original->getData()['personas']->count() == 0);
    }

    //la paginacion de la tabla es de 5 elementos, con lo cual el sexto no debe de verse
    public function test_primera_pagina_de_index_paginacion_no_contiene_sexto_elemento(): void
    {
        //agregamos 6 personas aleatorios al sistema
        $personas = Persona::factory(6)->create();
        //recuperamos la sexta/ultima persona de la coleccion
        $sextapersona = $personas->last();
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //accedemos a la vista de personas como gestor
        $response = $this->actingAs($gestor)->get('/persona');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos en la tabla no esté la sexta persona
        //ya que la paginacion es de 5 elementos
        $response->assertViewHas('personas', function ($collection) use ($sextapersona) {
            return !$collection->contains($sextapersona);
        });
    }

    //test para forzar el error por validacion al crear persona
    public function test_creacion_persona_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //peticion post para crear la persona
        //no rellenamos el campo tipo_personal para que nos salte el error de validación
        $persona = [
            'nombre' => 'nombre test 1',
            'apellidos' => 'apellidos test 1',
            'tipo_personal' => ''
        ];
        //enviamos el formulario por post como gestor
        $response = $this->actingAs($gestor)->post('/persona', $persona);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en el tipo_personal
        $response->assertSessionHasErrors('tipo_personal');
    }


    //test para crear una persona de forma exitosa
    public function test_creacion_persona_ok(): void
    {
        //recuperamos el usuario agestor
        $gestor = $this->getGestorUser();
        //peticion post para crear la persona
        $persona = [
            'nombre' => 'nombre test 1',
            'apellidos' => 'apellidos test 1',
            'tipo_personal' => 'interno'
        ];
        $response = $this->actingAs($gestor)->post('/persona', $persona);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a persona
        $response->assertRedirect('persona');
        //comprobamos que ela persona creada exista en la tabla de la base de datos
        $this->assertDatabaseHas('personas',  [
            'nombre' => $persona['nombre'],
            'apellidos' => $persona['apellidos'],
            'tipo_personal' => $persona['tipo_personal']
        ]);
    }

    //test para verificar que se completan correctamente los campos al cargar el registro editado
    public function test_edicion_persona_carga_de_campos_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una persona aleatoria
        $persona = Persona::factory()->create();
        //peticion get para editar la persona aleatoria
        $response = $this->actingAs($gestor)->get('/persona/' . $persona->id . '/edit');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //comprobamos que los campos se han completado en el html recuperado en el response
        $response->assertSee('value="' . $persona->nombre . '"', false);
        $response->assertSee('value="' . $persona->apellidos . '"', false);
        $response->assertSee('value="' . $persona->tipo_personal . '"', false);
    }

    //test para forzar el error por validacion al editar persona
    public function test_edicion_persona_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una persona aleatoria
        $persona = Persona::factory()->create();
        //peticion put para editar la persona aleatoria dejando el tipo personal vacío para que salte la validación
        $response = $this->actingAs($gestor)->put(
            '/persona/' . $persona->id,
            [
                'nombre' => $persona->nombre,
                'apellidos' => $persona->apellidos,
                'tipo_personal' => ''
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en el tipo_personal
        $response->assertSessionHasErrors('tipo_personal');
    }

    //test para editar correctamente una persona
    public function test_edicion_persona_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una persona aleatoria
        $persona = Persona::factory()->create();

        //peticion put para editar la persona aleatoria
        $response = $this->actingAs($gestor)->put(
            '/persona/' . $persona->id,
            [
                'nombre' => $persona->nombre,
                'apellidos' => $persona->apellidos,
                'tipo_personal' => 'externo'
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a persona
        $response->assertRedirect('persona');
        //comprobamos que la persona editada exista en la tabla de la base de datos
        $this->assertDatabaseHas('personas',  [
            'nombre' => $persona['nombre'],
            'apellidos' => $persona['apellidos'],
            'tipo_personal' => 'externo'
        ]);
    }

    //test para comprobar la eliminacion correcta de una persona
    public function test_eliminar_persona_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una persona aleatoria
        $persona = Persona::factory()->create();

        //peticion delete para eliminar la persona aleatoria
        $response = $this->actingAs($gestor)->delete(
            '/persona/' . $persona->id
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a usario
        $response->assertRedirect('persona');
        //comprobamos que la persona eliminada ya no exista en la base de datos
        $this->assertDatabaseMissing('personas', [$persona]);
    }

    //funcion privada para crear un usuario con acceso gestor
    private function getGestorUser()
    {
        $user = User::create([
            'username' => 'gestor1',
            'password' => bcrypt('password123'),
            'es_gestor' => 1
        ]);

        return $user;
    }
}
