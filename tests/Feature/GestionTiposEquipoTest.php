<?php

namespace Tests\Feature;

use App\Models\TipoEquipo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GestionTiposEquipoTest extends TestCase
{
    use RefreshDatabase;

    //test para comprobar que un usuario gestor puede acceder a la vista de gestión de tipos de equipo
    public function test_usuario_gestor_accede_a_gestion_de_tipos_de_equipo(): void
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
        //accedemos a gestion de tipos de equipo
        $response = $this->get('/tipo_equipo');
        //obtiene el código de página correcta
        $response->assertStatus(200);
    }


    //test para comprobar que un usuario no gestor no puede acceder a la vista de gestión de tipos de equipo
    public function test_usuario_no_gestor_no_accede_a_gestion_de_tipos_de_equipo(): void
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
        //accedemos a gestion de tipos de equipo
        $response = $this->get('/tipo_equipo');
        //obtiene el código de redirección a página no permitida
        $response->assertStatus(403);
    }

    //test para comprobar que se muestra la tabla de tipos de equipo en la vista de gestión de tipos de equipo
    public function test_vista_index_contiene_tabla_rellena(): void
    {
        //obtenemos un usuario gesstor
        $gestor = $this->getGestorUser();
        //agregamos 1 tipo de equipo aleatorio al sistema
        $tipos_equipo = TipoEquipo::factory(1)->create();
        //accedemos a la vista de tipos de equipo como gestor
        $response = $this->actingAs($gestor)->get('/tipo_equipo');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos esta el primer tipo de equipo aleatorio generado
        $response->assertViewHas('tipos_equipo', function ($collection) use ($tipos_equipo) {
            return $collection->contains($tipos_equipo->first());
        });
    }

    //test para comprobar que se recupera resultados al buscar en la vista de gestión de tipos_equipo
    public function test_busqueda_en_vista_index_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 tipos_equipo aleatorias al sistema
        $tipos_equipo = TipoEquipo::factory(10)->create();
        //recuperamos la primera tipo_equipo aleatoria
        $firstTipoEquipo = $tipos_equipo->first();
        //buscamos como gestor el tipo que coincide con la primera tipo_equipo aleatorio
        $response = $this->actingAs($gestor)->get('/tipo_equipo?query=' . $firstTipoEquipo->tipo);
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $tipos_equipo
        $response->assertViewHas('tipos_equipo');
        //El total de tipos_equipo obtenidos en la búsqueda mayor de 0
        $this->assertTrue($response->original->getData()['tipos_equipo']->count() > 0);
    }

    //test para comprobar que no se recupera resultados al buscar en la vista de gestión de tipos_equipo
    public function test_busqueda_en_vista_index_no_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 tipos_equipo aleatorias al sistema
        $tipos_equipo = User::factory(10)->create();
        //buscamos como gestor las tipos de equipo que contienen el texto este_tipo_equipo_no_existe
        $response = $this->actingAs($gestor)->get('/tipo_equipo?query=este_tipo_equipo_no_existe');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $tipos_equipo
        $response->assertViewHas('tipos_equipo');
        //El total de tipos_equipo obtenidas en la búsqueda es 0
        $this->assertTrue($response->original->getData()['tipos_equipo']->count() == 0);
    }

    //test para forzar el error por validacion al crear tipo de equipo
    public function test_creacion_tipo_equipo_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //peticion post para crear el tipo de equipo
        //insertamos un tipo vacío para que nos salte el error de validación
        $tipo_equipo = [
            'cod_tipo_equipo' => '612',
            'tipo' => ''
        ];
        //enviamos el formulario por post como gestor
        $response = $this->actingAs($gestor)->post('/tipo_equipo', $tipo_equipo);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en el tipo
        $response->assertSessionHasErrors('tipo');
    }


    //test para crear un tipo de equipo de forma exitosa
    public function test_creacion_tipo_equipo_ok(): void
    {
        //recuperamos el usuario agestor
        $gestor = $this->getGestorUser();
        //peticion post para crear el tipo de equipo
        $tipo_equipo = [
            'cod_tipo_equipo' => '612',
            'tipo' => 'tipo test 1'
        ];
        $response = $this->actingAs($gestor)->post('/tipo_equipo', $tipo_equipo);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a tipo_equipo
        $response->assertRedirect('tipo_equipo');
        //comprobamos que el tipo de equipo creado exista en la tabla de la base de datos
        $this->assertDatabaseHas('tipos_equipo',  [
            'cod_tipo_equipo' => $tipo_equipo['cod_tipo_equipo'],
            'tipo' => $tipo_equipo['tipo']
        ]);
    }

    //test para verificar que se completan correctamente los campos al cargar el registro editado
    public function test_edicion_tipo_equipo_carga_de_campos_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos un tipo de equipo aleatorio
        $tipo_equipo = TipoEquipo::factory()->create();
        //peticion get para editar el tipo de equipo aleatorio
        $response = $this->actingAs($gestor)->get('/tipo_equipo/' . $tipo_equipo->id . '/edit');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //comprobamos que los campos se han completado en el html recuperado en el response
        $response->assertSee('value="' . $tipo_equipo->cod_tipo_equipo . '"', false);
        $response->assertSee('value="' . $tipo_equipo->tipo . '"', false);
    }

    //test para forzar el error por validacion al editar el tipo de equipo
    public function test_edicion_tipo_equipo_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos un tipo de equipo aleatorio
        $tipo_equipo = TipoEquipo::factory()->create();
        //peticion put para editar el tipo de equipo aleatorio insertando un tipo vacío para que salte la validación
        $response = $this->actingAs($gestor)->put(
            '/tipo_equipo/' . $tipo_equipo->id,
            [
                'cod_tipo_equipo' => '612',
                'tipo' => ''
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en el tipo
        $response->assertSessionHasErrors('tipo');
    }

    //test para editar correctamente un tipo de equipo
    public function test_edicion_tipo_equipo_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos un tipo de equipo aleatorio
        $tipo_equipo = TipoEquipo::factory()->create();

        //peticion put para editar el tipo de equipo aleatorio
        $response = $this->actingAs($gestor)->put(
            '/tipo_equipo/' . $tipo_equipo->id,
            [
                'cod_tipo_equipo' => $tipo_equipo->cod_tipo_equipo,
                'tipo' => 'tipo test 1'
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige al tipo de equipo
        $response->assertRedirect('tipo_equipo');
        //comprobamos que el tipo de equipo editado exista en la tabla de la base de datos
        $this->assertDatabaseHas('tipos_equipo',  [
            'cod_tipo_equipo' => $tipo_equipo['cod_tipo_equipo'],
            'tipo' => 'tipo test 1'
        ]);
    }

    //test para comprobar la eliminacion correcta de una tipo_equipo
    public function test_eliminar_tipo_equipo_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una tipo_equipo aleatoria
        $tipo_equipo = TipoEquipo::factory()->create();

        //peticion delete para eliminar la tipo_equipo aleatoria
        $response = $this->actingAs($gestor)->delete(
            '/tipo_equipo/' . $tipo_equipo->id
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a usario
        $response->assertRedirect('tipo_equipo');
        //comprobamos que la tipo_equipo eliminada ya no exista en la base de datos
        $this->assertDatabaseMissing('tipos_equipo', [$tipo_equipo]);
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
