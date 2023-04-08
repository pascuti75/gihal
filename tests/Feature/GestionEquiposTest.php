<?php

namespace Tests\Feature;

use App\Models\Equipo;
use App\Models\User;
use App\Models\Contratacion;
use App\Models\TipoEquipo;
use App\Models\Ubicacion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GestionEquiposTest extends TestCase
{
    use RefreshDatabase;

    //test para comprobar que un usuario gestor puede acceder a la vista de gestión de equipos
    public function test_usuario_gestor_accede_a_gestion_de_equipos(): void
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
        //accedemos a gestion de equipos
        $response = $this->get('/equipo');
        //obtiene el código de página correcta
        $response->assertStatus(200);
    }


    //test para comprobar que un usuario no gestor no puede acceder a la vista de gestión de equipos
    public function test_usuario_no_gestor_no_accede_a_gestion_de_equipos(): void
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
        //accedemos a gestión de equipos
        $response = $this->get('/equipo');
        //obtiene el código de redirección a página no permitida
        $response->assertStatus(403);
    }

    //test para comprobar que se muestra la tabla de equipos en la vista de gestión de equipos
    public function test_vista_index_contiene_tabla_rellena(): void
    {
        //obtenemos un usuario gesstor
        $gestor = $this->getGestorUser();
        //agregamos 10 equipos aleatorios al sistema
        $equipos = Equipo::factory(10)->create();
        //accedemos a la vista de equipos como gestor
        $response = $this->actingAs($gestor)->get('/equipo');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //verificamos que entre los resultados devueltos esta el primer equipo aleatorio generado
        $response->assertViewHas('equipos', function ($collection) use ($equipos) {
            return $collection->contains($equipos->first());
        });
    }

    //test para comprobar que se recupera resultados al buscar en la vista de gestión de equipos
    public function test_busqueda_en_vista_index_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 equipos aleatorios al sistema
        $equipos = Equipo::factory(10)->create();
        //recuperamos el primer equipo aleatorio
        $firstequipo = $equipos->first();
        //buscamos como gestor el equipo que coincide con el primer equipo aleatorio
        $response = $this->actingAs($gestor)->get('/equipo?query=' . $firstequipo->cod_interno);
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $equipos
        $response->assertViewHas('equipos');
        //El total de equipos obtenidos en la búsqueda mayor de 0
        $this->assertTrue($response->original->getData()['equipos']->count() > 0);
    }

    //test para comprobar que no se recupera resultados al buscar en la vista de gestión de equipos
    public function test_busqueda_en_vista_index_no_encuentra_resultados(): void
    {
        //obtenemos un usuario gestor
        $gestor = $this->getGestorUser();
        //agregamos 10 equipos aleatorios al sistema
        $equipos = User::factory(10)->create();
        //buscamos como gestor los equipos que contienen el texto este_equipo_no_existe
        $response = $this->actingAs($gestor)->get('/equipo?query=este_equipo_no_existe');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $equipos
        $response->assertViewHas('equipos');
        //El total de equipos obtenidas en la búsqueda es 0
        $this->assertTrue($response->original->getData()['equipos']->count() == 0);
    }


    //test para forzar el error por validacion al crear equipo
    public function test_creacion_equipo_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();

        //peticion post para crear el equipo
        //no rellenamos el campo tipo para que nos salte el error de validación
        $equipo = [
            'cod_interno' => 'cod_interno test 1',
            'cod_externo' => 'cod_externo test 1',
            'marca' => 'marca test 1',
            'modelo' => 'modelo test 1',
            'product_number' => 'product_number test 1',
            'num_serie' => 'num_serie test 1'
        ];
        //enviamos el formulario por post como gestor
        $response = $this->actingAs($gestor)->post('/equipo', $equipo);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en el cod_interno
        $response->assertSessionHasErrors('id_tipo_equipo');
    }


    //test para crear una equipo de forma exitosa
    public function test_creacion_equipo_ok(): void
    {
        //recuperamos el usuario agestor
        $gestor = $this->getGestorUser();

        //creamos la ubicacion almacen para la operacion de almacenaje que se crea en paralelo al equipo
        $ubicacion = Ubicacion::factory()->create([
            'id' => 1,
        ]);

        //creamos un tipo de equipo para poder asociarlo con el equipo
        $tipo_equipo = TipoEquipo::factory()->create();

        //creamos an contratacion para poder asociarla con el equipo
        $contratacion = Contratacion::factory()->create();

        //peticion post para crear el equipo cómo gestor
        $equipo = [
            'cod_interno' => 'cod_interno test 1',
            'cod_externo' => 'cod_externo test 1',
            'marca' => 'marca test 1',
            'modelo' => 'modelo test 1',
            'product_number' => 'product_number test 1',
            'num_serie' => 'num_serie test 1',
            'id_tipo_equipo' =>  $tipo_equipo->id,
            'id_contratacion' =>  $contratacion->id
        ];

        $response = $this->actingAs($gestor)->post('/equipo', $equipo);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a equipo
        $response->assertRedirect('equipo');
        //comprobamos que el equipo creado exista en la tabla de la base de datos

        $this->assertDatabaseHas('equipos',  [
            'cod_interno' => $equipo['cod_interno'],
            'cod_externo' => $equipo['cod_externo'],
            'marca' => $equipo['marca'],
            'modelo' => $equipo['modelo'],
            'product_number' => $equipo['product_number'],
            'num_serie' => $equipo['num_serie'],
            'id_tipo_equipo' => $equipo['id_tipo_equipo'],
            'id_contratacion' => $equipo['id_contratacion'],
        ]);


        //obtenemos el equipo que acabamos de crear
        $equipo = DB::table('equipos')
            ->where('cod_interno',  $equipo['cod_interno'])
            ->where('cod_externo', $equipo['cod_externo'])
            ->where('marca', $equipo['marca'])
            ->where('modelo', $equipo['modelo'])
            ->where('product_number', $equipo['product_number'])
            ->where('num_serie', $equipo['num_serie'])
            ->first();

        $id_equipo = $equipo->id;

        //comprobamos que se ha creado correctamente la operacion de almacenaje asociada a la creacion del equipo
        $this->assertDatabaseHas('operaciones',  [
            'tipo_operacion' => 'almacenaje',
            'id_equipo' => $id_equipo,
            'id_ubicacion' => 1
        ]);
    }

    //test para verificar que se completan correctamente los campos al cargar el registro editado
    public function test_edicion_equipo_carga_de_campos_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos un tipo de equipo para poder asociarlo con el equipo
        $tipo_equipo = TipoEquipo::factory()->create();
        //creamos una equipo aleatorio asociado al tipo de equipo anterior
        $equipo = Equipo::factory()->create(['id_tipo_equipo' => $tipo_equipo->id]);
        //peticion get para editar el equipo aleatorio
        $response = $this->actingAs($gestor)->get('/equipo/' . $equipo->id . '/edit');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //comprobamos que los campos se han completado en el html recuperado en el response
        $response->assertSee('value="' . $equipo->marca . '"', false);
        $response->assertSee('value="' . $equipo->modelo . '"', false);
        $response->assertSee('value="' . $equipo->product_number . '"', false);
        $response->assertSee('value="' . $equipo->num_serie . '"', false);
        $response->assertSee('value="' . $equipo->cod_interno . '"', false);
        $response->assertSee('value="' . $equipo->cod_externo . '"', false);
        $response->assertSee('value="' . $equipo->id_tipo_equipo . '" selected', false);
    }

    //test para forzar el error por validacion al editar equipo
    public function test_edicion_equipo_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos un tipo de equipo para poder asociarlo con el equipo
        $tipo_equipo = TipoEquipo::factory()->create();
        //creamos una equipo aleatorio asociado al tipo de equipo anterior
        $equipo = Equipo::factory()->create(['id_tipo_equipo' => $tipo_equipo->id]);
        //peticion put para editar el equipo aleatorio dejando el id_tipo_equipo vacío para que salte la validación
        $response = $this->actingAs($gestor)->put(
            '/equipo/' . $equipo->id,
            [
                'cod_interno' => $equipo->cod_interno,
                'cod_externo' => $equipo->cod_externo,
                'marca' => $equipo->marca,
                'modelo' => $equipo->modelo,
                'product_number' => $equipo->product_number,
                'num_serie' => $equipo->num_serie,
                'id_tipo_equipo' => null
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en el equipo
        $response->assertSessionHasErrors('id_tipo_equipo');
    }

    //test para editar correctamente una equipo
    public function test_edicion_equipo_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos un tipo de equipo para poder asociarlo con el equipo
        $tipo_equipo = TipoEquipo::factory()->create();
        //creamos una equipo aleatorio asociado al tipo de equipo anterior
        $equipo = Equipo::factory()->create(['id_tipo_equipo' => $tipo_equipo->id]);

        //peticion put para editar el equipo aleatorio
        $response = $this->actingAs($gestor)->put(
            '/equipo/' . $equipo->id,
            [
                'cod_interno' => $equipo->cod_interno,
                'cod_externo' => $equipo->cod_externo,
                'marca' => $equipo->marca,
                'modelo' => $equipo->modelo,
                'product_number' => '1234567890',
                'num_serie' => $equipo->num_serie,
                'id_tipo_equipo' => $tipo_equipo->id
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a equipo
        $response->assertRedirect('equipo');
        //comprobamos que el equipo editado exista en la tabla de la base de datos
        $this->assertDatabaseHas('equipos',  [
            'cod_interno' => $equipo['cod_interno'],
            'cod_externo' => $equipo['cod_externo'],
            'marca' => $equipo['marca'],
            'modelo' => $equipo['modelo'],
            'product_number' => '1234567890',
            'num_serie' => $equipo['num_serie'],
            'id_tipo_equipo' => $equipo['id_tipo_equipo']
        ]);
    }

    //test para comprobar la eliminacion correcta de una equipo
    public function test_eliminar_equipo_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una equipo aleatorio
        $equipo = Equipo::factory()->create();

        //peticion delete para eliminar el equipo aleatorio
        $response = $this->actingAs($gestor)->delete(
            '/equipo/' . $equipo->id
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a usario
        $response->assertRedirect('equipo');
        //comprobamos que el equipo eliminada ya no exista en la base de datos
        $this->assertDatabaseMissing('equipos', [$equipo]);
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
