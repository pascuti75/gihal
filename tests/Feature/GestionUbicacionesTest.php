<?php

namespace Tests\Feature;

use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GestionUbicacionesTest extends TestCase
{
    use RefreshDatabase;

    //test para comprobar que un usuario gestor puede acceder a la vista de gestión de ubicaciones
    public function test_usuario_gestor_accede_a_gestion_de_ubicaciones(): void
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
        //accedemos a gestion de ubicaciones
        $response = $this->get('/ubicacion');
        //obtiene el código de página correcta
        $response->assertStatus(200);
    }


    //test para comprobar que un usuario no gestor no puede acceder a la vista de gestión de ubicaciones
    public function test_usuario_no_gestor_no_accede_a_gestion_de_ubicaciones(): void
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
        //accedemos a administracion de usuarios
        $response = $this->get('/ubicacion');
        //obtiene el código de redirección a página no permitida
        $response->assertStatus(403);
    }

    //test para comprobar que se muestra la tabla de ubicaciones en la vista de gestión de ubicaciones
    public function test_vista_index_contiene_tabla_rellena(): void
    {
        //obtenemos un usuario gesstor
        $gestor = $this->getGestorUser();
        //agregamos 10 ubicaciones aleatorias al sistema
        $ubicaciones = Ubicacion::factory(10)->create();
        //accedemos a la vista de ubicaciones como gestor
        $response = $this->actingAs($gestor)->get('/ubicacion');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos esta la primera ubicacion aleatoria generada
        $response->assertViewHas('ubicaciones', function ($collection) use ($ubicaciones) {
            return $collection->contains($ubicaciones->first());
        });
    }

    //test para comprobar que se recupera resultados al buscar en la vista de gestión de ubicaciones
    public function test_busqueda_en_vista_index_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 ubicaciones aleatorias al sistema
        $ubicaciones = Ubicacion::factory(10)->create();
        //recuperamos la primera ubicacion aleatoria
        $firstUbicacion = $ubicaciones->first();
        //buscamos como gestor el servicio que coincide con la primera ubicaion aleatoria
        $response = $this->actingAs($gestor)->get('/ubicacion?query=' . $firstUbicacion->servicio);
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $ubicaciones
        $response->assertViewHas('ubicaciones');
        //El total de ubicaciones obtenidos en la búsqueda mayor de 0
        $this->assertTrue($response->original->getData()['ubicaciones']->count() > 0);
    }

    //test para comprobar que no se recupera resultados al buscar en la vista de gestión de ubicaciones
    public function test_busqueda_en_vista_index_no_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 ubicaciones aleatorias al sistema
        $ubicaciones = User::factory(10)->create();
        //buscamos como gestor las ubicaciones que contienen el texto esta_ubicacion_no_existe
        $response = $this->actingAs($gestor)->get('/ubicacion?query=esta_ubicacion_no_existe');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $ubicaciones
        $response->assertViewHas('ubicaciones');
        //El total de ubicaciones obtenidas en la búsqueda es 0
        $this->assertTrue($response->original->getData()['ubicaciones']->count() == 0);
    }

    //la paginacion de la tabla es de 5 elementos, con lo cual el sexto no debe de verse
    public function test_primera_pagina_de_index_paginacion_no_contiene_sexto_elemento(): void
    {
        //agregamos 6 ubicaciones aleatorios al sistema
        $ubicaciones = Ubicacion::factory(6)->create();
        //recuperamos la sexta/ultima ubicacion de la coleccion
        $sextaUbicacion = $ubicaciones->last();
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //accedemos a la vista de ubicaciones como gestor
        $response = $this->actingAs($gestor)->get('/ubicacion');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos en la tabla no esté la sexta ubicacion
        //ya que la paginacion es de 5 elementos
        $response->assertViewHas('ubicaciones', function ($collection) use ($sextaUbicacion) {
            return !$collection->contains($sextaUbicacion);
        });
    }

    //test para forzar el error por validacion al crear ubicacion
    public function test_creacion_ubicacion_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //peticion post para crear la ubicacion
        //no rellenamos el campo direccion para que nos salte el error de validación
        $ubicacion = [
            'servicio' => 'servicio test 1',
            'dependencia' => 'dependencia test 1',
            'direccion' => '',
            'planta' => '1'
        ];
        //enviamos el formulario por post como gestor
        $response = $this->actingAs($gestor)->post('/ubicacion', $ubicacion);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la direccion
        $response->assertSessionHasErrors('direccion');
    }


    //test para crear una ubicación de forma exitosa
    public function test_creacion_ubicacion_ok(): void
    {
        //recuperamos el usuario agestor
        $gestor = $this->getGestorUser();
        //peticion post para crear la ubicacion
        $ubicacion = [
            'servicio' => 'servicio test 1',
            'dependencia' => 'dependencia test 1',
            'direccion' => 'direccion test 1',
            'planta' => '1'
        ];
        $response = $this->actingAs($gestor)->post('/ubicacion', $ubicacion);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a ubicacion
        $response->assertRedirect('ubicacion');
        //comprobamos que ela ubicacion creada exista en la tabla de la base de datos
        $this->assertDatabaseHas('ubicaciones',  [
            'servicio' => $ubicacion['servicio'],
            'dependencia' => $ubicacion['dependencia'],
            'direccion' => $ubicacion['direccion'],
            'planta' => $ubicacion['planta'],
        ]);
    }

    //test para verificar que se completan correctamente los campos al cargar el registro editado
    public function test_edicion_ubicacion_carga_de_campos_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una ubicacion aleatoria
        $ubicacion = Ubicacion::factory()->create();
        //peticion get para editar la ubicacion aleatoria
        $response = $this->actingAs($gestor)->get('/ubicacion/' . $ubicacion->id . '/edit');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //comprobamos que los campos se han completado en el html recuperado en el response
        $response->assertSee('value="' . $ubicacion->servicio . '"', false);
        $response->assertSee('value="' . $ubicacion->dependencia . '"', false);
        $response->assertSee('value="' . $ubicacion->direccion . '"', false);
        $response->assertSee('value="' . $ubicacion->planta . '"', false);
    }

    //test para forzar el error por validacion al editar ubicacion
    public function test_edicion_ubicacion_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una ubicacion aleatoria
        $ubicacion = Ubicacion::factory()->create();
        //peticion put para editar el usuario aleatorio dejando la dirección vacía para que salte la validación
        $response = $this->actingAs($gestor)->put(
            '/ubicacion/' . $ubicacion->id,
            [
                'servicio' => $ubicacion->servicio,
                'dependencia' => $ubicacion->dependencia,
                'direccion' => '',
                'planta' => $ubicacion->planta
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la direccion
        $response->assertSessionHasErrors('direccion');
    }

    //test para editar correctamente una ubicacion
    public function test_edicion_ubicacion_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una ubicacion aleatoria
        $ubicacion = Ubicacion::factory()->create();

        //peticion put para editar la ubicacion aleatoria
        $response = $this->actingAs($gestor)->put(
            '/ubicacion/' . $ubicacion->id,
            [
                'servicio' => $ubicacion->servicio,
                'dependencia' => $ubicacion->dependencia,
                'direccion' => 'esta es una direccion de prueba',
                'planta' => $ubicacion->planta
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a ubicacion
        $response->assertRedirect('ubicacion');
        //comprobamos que la ubicacion editada exista en la tabla de la base de datos
        $this->assertDatabaseHas('ubicaciones',  [
            'servicio' => $ubicacion['servicio'],
            'dependencia' => $ubicacion['dependencia'],
            'direccion' => 'esta es una direccion de prueba',
            'planta' => $ubicacion['planta']
        ]);
    }

    //test para comprobar la eliminacion correcta de una ubicacion
    public function test_eliminar_ubicacion_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una ubicacion aleatoria
        $ubicacion = Ubicacion::factory()->create();

        //peticion delete para eliminar la ubicacion aleatoria
        $response = $this->actingAs($gestor)->delete(
            '/ubicacion/' . $ubicacion->id
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a usario
        $response->assertRedirect('ubicacion');
        //comprobamos que la ubicacion eliminada ya no exista en la base de datos
        $this->assertDatabaseMissing('ubicaciones', [$ubicacion]);
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
