<?php

namespace Tests\Feature;

use App\Models\Contratacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GestionContratacionesTest extends TestCase
{
    use RefreshDatabase;

    //test para comprobar que un usuario gestor puede acceder a la vista de gestión de contrataciones
    public function test_usuario_gestor_accede_a_gestion_de_contrataciones(): void
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
        //accedemos a gestion de contrataciones
        $response = $this->get('/contratacion');
        //obtiene el código de página correcta
        $response->assertStatus(200);
    }


    //test para comprobar que un usuario no gestor no puede acceder a la vista de gestión de contrataciones
    public function test_usuario_no_gestor_no_accede_a_gestion_de_contrataciones(): void
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
        //accedemos a gestión de contrataciones
        $response = $this->get('/contratacion');
        //obtiene el código de redirección a página no permitida
        $response->assertStatus(403);
    }

    //test para comprobar que se muestra la tabla de contrataciones en la vista de gestión de contrataciones
    public function test_vista_index_contiene_tabla_rellena(): void
    {
        //obtenemos un usuario gesstor
        $gestor = $this->getGestorUser();
        //agregamos 10 contrataciones aleatorias al sistema
        $contrataciones = Contratacion::factory(10)->create();
        //accedemos a la vista de contrataciones como gestor
        $response = $this->actingAs($gestor)->get('/contratacion');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos esta la primera contratacion aleatoria generada
        $response->assertViewHas('contrataciones', function ($collection) use ($contrataciones) {
            return $collection->contains($contrataciones->first());
        });
    }

    //test para comprobar que se recupera resultados al buscar en la vista de gestión de contrataciones
    public function test_busqueda_en_vista_index_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 contrataciones aleatorias al sistema
        $contrataciones = Contratacion::factory(10)->create();
        //recuperamos la primera contratacion aleatoria
        $firstcontratacion = $contrataciones->first();
        //buscamos como gestor el titulo que coincide con la primera contratacion aleatoria
        $response = $this->actingAs($gestor)->get('/contratacion?query=' . $firstcontratacion->titulo);
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $contrataciones
        $response->assertViewHas('contrataciones');
        //El total de contrataciones obtenidos en la búsqueda mayor de 0
        $this->assertTrue($response->original->getData()['contrataciones']->count() > 0);
    }

    //test para comprobar que no se recupera resultados al buscar en la vista de gestión de contrataciones
    public function test_busqueda_en_vista_index_no_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 contrataciones aleatorias al sistema
        $contrataciones = User::factory(10)->create();
        //buscamos como gestor las contrataciones que contienen el texto esta_contratacion_no_existe
        $response = $this->actingAs($gestor)->get('/contratacion?query=esta_contratacion_no_existe');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $contrataciones
        $response->assertViewHas('contrataciones');
        //El total de contrataciones obtenidas en la búsqueda es 0
        $this->assertTrue($response->original->getData()['contrataciones']->count() == 0);
    }

    //test para forzar el error por validacion al crear contratacion
    public function test_creacion_contratacion_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //peticion post para crear la contratacion
        //insertamos una fecha_fin menor a la fecha_inicio para que nos salte el error de validación
        $contratacion = [
            'titulo' => 'titulo test 1',
            'empresa' => 'empresa test 1',
            'fecha_inicio' => '2023-04-01',
            'fecha_fin' => '2023-03-15',
        ];
        //enviamos el formulario por post como gestor
        $response = $this->actingAs($gestor)->post('/contratacion', $contratacion);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en fecha_fin
        $response->assertSessionHasErrors('fecha_fin');
    }


    //test para crear una contratacion de forma exitosa
    public function test_creacion_contratacion_ok(): void
    {
        //recuperamos el usuario agestor
        $gestor = $this->getGestorUser();
        //peticion post para crear la contratacion
        $contratacion = [
            'titulo' => 'titulo test 1',
            'empresa' => 'empresa test 1',
            'fecha_inicio' => '2023-04-01',
            'fecha_fin' => '2026-05-15',
        ];
        $response = $this->actingAs($gestor)->post('/contratacion', $contratacion);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a contratacion
        $response->assertRedirect('contratacion');
        //comprobamos que ela contratacion creada exista en la tabla de la base de datos
        $this->assertDatabaseHas('contrataciones',  [
            'titulo' => $contratacion['titulo'],
            'empresa' => $contratacion['empresa'],
            'fecha_inicio' => $contratacion['fecha_inicio'],
            'fecha_fin' => $contratacion['fecha_fin']
        ]);
    }

    //test para verificar que se completan correctamente los campos al cargar el registro editado
    public function test_edicion_contratacion_carga_de_campos_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una contratacion aleatoria
        $contratacion = Contratacion::factory()->create();
        //peticion get para editar la contratacion aleatoria
        $response = $this->actingAs($gestor)->get('/contratacion/' . $contratacion->id . '/edit');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //comprobamos que los campos se han completado en el html recuperado en el response
        $response->assertSee('value="' . $contratacion->titulo . '"', false);
        $response->assertSee('value="' . $contratacion->empresa . '"', false);
        $response->assertSee('value="' . $contratacion->fecha_inicio . '"', false);
        $response->assertSee('value="' . $contratacion->fecha_fin . '"', false);
    }

    //test para forzar el error por validacion al editar contratacion
    public function test_edicion_contratacion_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una contratacion aleatoria
        $contratacion = Contratacion::factory()->create();
        //peticion put para editar la contratacion aleatoria insertando una fecha_fin menor a fecha_inicio para que salte la validación
        $response = $this->actingAs($gestor)->put(
            '/contratacion/' . $contratacion->id,
            [
                'titulo' => 'titulo test 1',
                'empresa' => 'empresa test 1',
                'fecha_inicio' => '2023-04-01',
                'fecha_fin' => '2023-03-15',
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la fecha_fin
        $response->assertSessionHasErrors('fecha_fin');
    }

    //test para editar correctamente una contratacion
    public function test_edicion_contratacion_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una contratacion aleatoria
        $contratacion = Contratacion::factory()->create();

        //peticion put para editar la contratacion aleatoria
        $response = $this->actingAs($gestor)->put(
            '/contratacion/' . $contratacion->id,
            [
                'titulo' => $contratacion->titulo,
                'empresa' => $contratacion->empresa,
                'fecha_inicio' => $contratacion->fecha_inicio,
                'fecha_fin' => '2023-03-15'
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a contratacion
        $response->assertRedirect('contratacion');
        //comprobamos que la contratacion editada exista en la tabla de la base de datos
        $this->assertDatabaseHas('contrataciones',  [
            'titulo' => $contratacion['titulo'],
            'empresa' => $contratacion['empresa'],
            'fecha_inicio' => $contratacion['fecha_inicio'],
            'fecha_fin' => '2023-03-15'
        ]);
    }

    //test para comprobar la eliminacion correcta de una contratacion
    public function test_eliminar_contratacion_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una contratacion aleatoria
        $contratacion = Contratacion::factory()->create();

        //peticion delete para eliminar la contratacion aleatoria
        $response = $this->actingAs($gestor)->delete(
            '/contratacion/' . $contratacion->id
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a usario
        $response->assertRedirect('contratacion');
        //comprobamos que la contratacion eliminada ya no exista en la base de datos
        $this->assertDatabaseMissing('contrataciones', [$contratacion]);
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
