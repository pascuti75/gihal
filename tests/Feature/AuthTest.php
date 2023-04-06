<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_usuario_no_autentificado_no_puede_acceder_a_home(): void
    {
        $response = $this->get('/home');
        //obtiene el coodigo de redireccion
        $response->assertStatus(302);
        //redirige a login
        $response->assertRedirect('login');
    }
}
