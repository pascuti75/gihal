<?php

namespace Tests\Feature;

use App\Models\Equipo;
use App\Models\User;
use App\Models\Contratacion;
use App\Models\TipoEquipo;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        //peticion post para crear el equipo
        $equipo = [
            'nombre' => 'nombre test 1',
            'apellidos' => 'apellidos test 1',
            'equipo' => 'interno'
        ];
        $response = $this->actingAs($gestor)->post('/equipo', $equipo);
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a equipo
        $response->assertRedirect('equipo');
        //comprobamos que eel equipo creada exista en la tabla de la base de datos
        $this->assertDatabaseHas('equipos',  [
            'nombre' => $equipo['nombre'],
            'apellidos' => $equipo['apellidos'],
            'equipo' => $equipo['equipo']
        ]);
    }

    //test para verificar que se completan correctamente los campos al cargar el registro editado
    public function test_edicion_equipo_carga_de_campos_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una equipo aleatorio
        $equipo = Equipo::factory()->create();
        //peticion get para editar el equipo aleatorio
        $response = $this->actingAs($gestor)->get('/equipo/' . $equipo->id . '/edit');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //comprobamos que los campos se han completado en el html recuperado en el response
        $response->assertSee('value="' . $equipo->nombre . '"', false);
        $response->assertSee('value="' . $equipo->apellidos . '"', false);
        $response->assertSee('value="' . $equipo->equipo . '"', false);
    }

    //test para forzar el error por validacion al editar equipo
    public function test_edicion_equipo_error_por_validacion(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una equipo aleatorio
        $equipo = Equipo::factory()->create();
        //peticion put para editar el equipo aleatorio dejando el tipo equipol vacío para que salte la validación
        $response = $this->actingAs($gestor)->put(
            '/equipo/' . $equipo->id,
            [
                'nombre' => $equipo->nombre,
                'apellidos' => $equipo->apellidos,
                'equipo' => ''
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en el equipo
        $response->assertSessionHasErrors('equipo');
    }

    //test para editar correctamente una equipo
    public function test_edicion_equipo_ok(): void
    {
        //recuperamos el usuario gestor
        $gestor = $this->getGestorUser();
        //creamos una equipo aleatorio
        $equipo = Equipo::factory()->create();

        //peticion put para editar el equipo aleatorio
        $response = $this->actingAs($gestor)->put(
            '/equipo/' . $equipo->id,
            [
                'nombre' => $equipo->nombre,
                'apellidos' => $equipo->apellidos,
                'equipo' => 'externo'
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a equipo
        $response->assertRedirect('equipo');
        //comprobamos que el equipo editada exista en la tabla de la base de datos
        $this->assertDatabaseHas('equipos',  [
            'nombre' => $equipo['nombre'],
            'apellidos' => $equipo['apellidos'],
            'equipo' => 'externo'
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
