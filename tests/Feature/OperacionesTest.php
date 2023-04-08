<?php

namespace Tests\Feature;

use App\Models\Operacion;
use App\Models\User;
use App\Models\Persona;
use App\Models\Ubicacion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OperacionesTest extends TestCase
{
    use RefreshDatabase;

    //test para comprobar que un usuario tecnico puede acceder a la vista de operaciones
    public function test_usuario_tecnico_accede_a_operaciones(): void
    {
        //creamos un usuario tecnico
        User::create([
            'username' => 'tecnico1',
            'password' => bcrypt('password123'),
            'es_tecnico' => 1
        ]);

        //pasamos el usuario a la peticion post del login
        $response = $this->post('/login', [
            'username' => 'tecnico1',
            'password' => 'password123'
        ]);

        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a login
        $response->assertRedirect('home');
        //accedemos a gestion de operaciones
        $response = $this->get('/operacion');
        //obtiene el código de página correcta
        $response->assertStatus(200);
    }


    //test para comprobar que un usuario no tecnico no puede acceder a la vista de operaciones
    public function test_usuario_no_tecnico_no_accede_a_operaciones(): void
    {
        //creamos un usuario no tecnico
        User::create([
            'username' => 'usuario',
            'password' => bcrypt('password123'),
            'es_tecnico' => 0
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
        //accedemos a operaciones
        $response = $this->get('/operacion');
        //obtiene el código de redirección a página no permitida
        $response->assertStatus(403);
    }


    /*
    //test para comprobar que se recupera resultados al buscar en la vista de operaciones
    //No se puede usuar este test porque el sistema de test esta montado sobre una base datos sqlite en memoria
    //y en el sistema de busquedas utilizo la funcion CONCAT que no existe en sqlite 
    public function test_busqueda_en_vista_index_encuentra_resultados(): void
    {
        //obtenemos un usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //agregamos 10 operaciones aleatorios al sistema
        $operaciones = Operacion::factory(10)->create();
        //recuperamos el primer operacion aleatorio
        $firstOperacion = $operaciones->first();
        //buscamos como tecnico la operacion que coincide con la primera operacion aleatorio
        $response = $this->actingAs($tecnico)->get('/operacion?query=' . $firstOperacion->tipo_operacion);
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $operaciones
        $response->assertViewHas('operaciones');
        //El total de operaciones obtenidos en la búsqueda mayor de 0
        $this->assertTrue($response->original->getData()['operaciones']->count() > 0);
    }
    */
    /*
    //test para comprobar que no se recupera resultados al buscar en la vista de operaciones
     //No se puede usuar este test porque el sistema de test esta montado sobre una base datos sqlite en memoria
    //y en el sistema de busquedas utilizo la funcion CONCAT que no existe en sqlite 
    public function test_busqueda_en_vista_index_no_encuentra_resultados(): void
    {
        //obtenemos un usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //agregamos 10 operaciones aleatorios al sistema
        $operaciones = User::factory(10)->create();
        //buscamos como tecnico los operaciones que contienen el texto este_operacion_no_existe
        $response = $this->actingAs($tecnico)->get('/operacion?query=esta_operacion_no_existe');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //La vista tiene el parámetro de elementos $operaciones
        $response->assertViewHas('operaciones');
        //El total de operaciones obtenidas en la búsqueda es 0
        $this->assertTrue($response->original->getData()['operaciones']->count() == 0);
    }
    */

    //test para verificar que se completan correctamente los campos al instalar
    public function test_instalar_carga_de_campos_ok(): void
    {
        //recuperamos el usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //creamos una operacion aleatoria a
        $operacion = Operacion::factory()->create();
        //peticion get para editar la operacion aleatoria
        $response = $this->actingAs($tecnico)->get('/operacion/' . $operacion->id . '/instalar');
        //obtiene el código de página correcta
        $response->assertStatus(200);
        //comprobamos que los campos se han completado en el html recuperado en el response
        $response->assertSee('value="instalacion"', false);
        $response->assertSee('value="' . $operacion->id_equipo . isset($operacion->id_equipo) ? ' selected' : '' . '"', false);
        $response->assertSee('value="' . $operacion->id_persona . isset($operacion->id_persona) ? ' selected' : '' . '"', false);
        $response->assertSee('value="' . $operacion->id_ubicacion . isset($operacion->id_ubicacion) ? ' selected' : '' . '"', false);
        $response->assertSee('value="' . $operacion->id_user . isset($operacion->id_user) ? ' selected' : '' . '"', false);
    }


    //test para forzar el error al instalar un equipo en baja
    public function test_instalar_equipo_en_baja_error_por_validacion(): void
    {
        //recuperamos el usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //creamos una operacion aleatoria con tipo_operacion = baja
        $operacion = Operacion::factory()->create(['tipo_operacion' => 'baja']);
        //peticion put para instalar un equipo con  tipo_operacion = baja

        $response = $this->actingAs($tecnico)->put(
            '/operacion/' . $operacion->id,
            [
                'tipo_operacion' => 'instalacion',
                'id_equipo' => $operacion->id_equipo,
                'id_persona' => $operacion->id_persona,
                'id_ubicaciona' => $operacion->id_ubicaciona,
                'id_user' => $operacion->id_user
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la operacion
        $this->assertNotEmpty(session('error'));
    }

    //test para instalar correctamente un equipo
    public function test_instalar_equipo_ok(): void
    {
        //recuperamos el usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //creamos una persona aleatoria para asignarle la operacion
        $persona = Persona::factory()->create();
        $id_persona = $persona->id;
        //creamos una ubicacion aleatoria para asignarle la operacion
        $ubicacion = Ubicacion::factory()->create();
        $id_ubicacion = $ubicacion->id;
        //creamos una operacion aleatoria con tipo_operacion = almacenaje
        $operacion = Operacion::factory()->create(['tipo_operacion' => 'almacenaje']);

        //peticion put para editar el operacion aleatorio
        $response = $this->actingAs($tecnico)->put(
            '/operacion/' . $operacion->id,
            [
                'tipo_operacion' => 'instalacion',
                'id_equipo' => $operacion->id_equipo,
                'id_persona' => $id_persona,
                'id_ubicacion' => $id_ubicacion,
                'id_user' => $operacion->id_user
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a operacion
        $response->assertRedirect('operacion');
        //comprobamos que el operacion editado exista en la tabla de la base de datos

        $this->assertDatabaseHas('operaciones',  [
            'tipo_operacion' => 'instalacion',
            'id_equipo' => $operacion->id_equipo,
            'id_persona' => $id_persona,
            'id_ubicacion' => $id_ubicacion,
            'id_user' => $operacion->id_user
        ]);

        //nos va a indicar que hay un mensaje de operacion correcta en la operacion
        $this->assertNotEmpty(session('mensaje'));
    }


    //test para forzar el error al almacenar un equipo en baja
    public function test_almacenaje_equipo_en_baja_error_por_validacion(): void
    {
        //recuperamos el usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //creamos una operacion aleatoria con tipo_operacion = baja
        $operacion = Operacion::factory()->create(['tipo_operacion' => 'baja']);
        //peticion put para almacenar un equipo con  tipo_operacion = baja

        $response = $this->actingAs($tecnico)->put(
            '/operacion/' . $operacion->id,
            [
                'tipo_operacion' => 'almacenaje',
                'id_equipo' => $operacion->id_equipo,
                'id_persona' => $operacion->id_persona,
                'id_ubicaciona' => $operacion->id_ubicaciona,
                'id_user' => $operacion->id_user
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la operacion
        $this->assertNotEmpty(session('error'));
    }

    //test para almacenar correctamente un equipo
    public function test_almacenaje_equipo_ok(): void
    {
        //recuperamos el usuario tecnico
        $tecnico = $this->getTecnicoUser();

        //creamos una operacion aleatoria con tipo_operacion = instalacion
        $operacion = Operacion::factory()->create(['tipo_operacion' => 'instalacion']);

        //peticion put para editar el operacion aleatorio
        $response = $this->actingAs($tecnico)->put(
            '/operacion/' . $operacion->id,
            [
                'tipo_operacion' => 'almacenaje',
                'id_equipo' => $operacion->id_equipo,
                'id_persona' => $operacion->id_persona,
                'id_ubicacion' => $operacion->id_ubicacion
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a operacion
        $response->assertRedirect('operacion');
        //comprobamos que el operacion editado exista en la tabla de la base de datos

        $this->assertDatabaseHas('operaciones',  [
            'tipo_operacion' => 'almacenaje',
            'id_equipo' => $operacion->id_equipo,
            'id_persona' => null, //al almacenar se elimina la asociacion con la persona
            'id_ubicacion' => $operacion->id_ubicacion
        ]);

        //nos va a indicar que hay un mensaje de operacion correcta en la operacion
        $this->assertNotEmpty(session('mensaje'));
    }



    //test para forzar el error alenviar a reparar un equipo en baja
    public function test_reparacion_equipo_en_baja_error_por_validacion(): void
    {
        //recuperamos el usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //creamos una operacion aleatoria con tipo_operacion = baja
        $operacion = Operacion::factory()->create(['tipo_operacion' => 'baja']);
        //peticion put para almacenar un equipo con  tipo_operacion = baja

        $response = $this->actingAs($tecnico)->put(
            '/operacion/' . $operacion->id,
            [
                'tipo_operacion' => 'reparacion',
                'id_equipo' => $operacion->id_equipo,
                'id_persona' => $operacion->id_persona,
                'id_ubicaciona' => $operacion->id_ubicaciona,
                'id_user' => $operacion->id_user
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la operacion
        $this->assertNotEmpty(session('error'));
    }

    //test para enviar a reparar correctamente un equipo
    public function test_reparacion_equipo_ok(): void
    {
        //recuperamos el usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //creamos una operacion aleatoria con tipo_operacion = instalacion
        $operacion = Operacion::factory()->create(['tipo_operacion' => 'instalacion']);

        //peticion put para editar el operacion aleatorio
        $response = $this->actingAs($tecnico)->put(
            '/operacion/' . $operacion->id,
            [
                'tipo_operacion' => 'reparacion',
                'id_equipo' => $operacion->id_equipo,
                'id_persona' => $operacion->id_persona,
                'id_ubicacion' => $operacion->id_ubicacion
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //redirige a operacion
        $response->assertRedirect('operacion');
        //comprobamos que el operacion editado exista en la tabla de la base de datos

        $this->assertDatabaseHas('operaciones',  [
            'tipo_operacion' => 'reparacion',
            'id_equipo' => $operacion->id_equipo,
            'id_persona' => $operacion->id_persona,
            'id_ubicacion' => $operacion->id_ubicacion
        ]);

        //nos va a indicar que hay un mensaje de operacion correcta en la operacion
        $this->assertNotEmpty(session('mensaje'));
    }

    //test para forzar el error al dar de baja un equipo en baja
    public function test_baja_equipo_en_baja_error_por_validacion(): void
    {
        //recuperamos el usuario tecnico
        $tecnico = $this->getTecnicoUser();
        //creamos una operacion aleatoria con tipo_operacion = baja
        $operacion = Operacion::factory()->create(['tipo_operacion' => 'baja']);
        //peticion put para almacenar un equipo con  tipo_operacion = baja

        $response = $this->actingAs($tecnico)->put(
            '/operacion/' . $operacion->id,
            [
                'tipo_operacion' => 'baja',
                'id_equipo' => $operacion->id_equipo,
                'id_persona' => $operacion->id_persona,
                'id_ubicaciona' => $operacion->id_ubicaciona,
                'id_user' => $operacion->id_user
            ]
        );
        //obtiene el código de redirección
        $response->assertStatus(302);
        //nos va a indicar que hay un error en la operacion
        $this->assertNotEmpty(session('error'));
    }


    //funcion privada para crear un usuario con acceso tecnico
    private function getTecnicoUser()
    {
        $user = User::create([
            'username' => 'tecnico1',
            'password' => bcrypt('password123'),
            'es_tecnico' => 1
        ]);

        return $user;
    }
}
