<?php

namespace Tests\Feature;

use App\User;
use App\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = factory(User::class)->create(['role' => 'admin']);
    }

    /** @test */
    public function it_stores_valid_client_and_normalizes_text_to_uppercase()
    {
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '12345678',
            'nombres' => "María Connor",
            'apellidos' => 'Valdés Díaz',
            'telefono' => '04121234567',
            'direccion' => 'Calle Muñoz, Edif. España',
        ]);

        $response->assertStatus(302); // Redirect back or to listing
        
        $this->assertDatabaseHas('clients', [
            'cedula' => 12345678,
            'nombres' => "MARÍA CONNOR",
            'apellidos' => 'VALDÉS DÍAZ',
            'telefono' => '04121234567',
            'direccion' => 'CALLE MUÑOZ, EDIF. ESPAÑA',
        ]);
    }

    /** @test */
    public function it_fails_if_cedula_is_invalid()
    {
        // 1. More than 8 characters
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '123456789',
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'telefono' => '04121234567',
            'direccion' => 'Calle Falsa 123',
        ]);
        $response->assertSessionHasErrors('cedula');

        // 2. Contains letters
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '1234567A',
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'telefono' => '04121234567',
            'direccion' => 'Calle Falsa 123',
        ]);
        $response->assertSessionHasErrors('cedula');
    }

    /** @test */
    public function it_fails_if_telefono_is_invalid()
    {
        // 1. Not exactly 11 characters
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '12345678',
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'telefono' => '0412123456', // 10 chars
            'direccion' => 'Calle Falsa 123',
        ]);
        $response->assertSessionHasErrors('telefono');

        // 2. Contains letters
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '12345678',
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'telefono' => '0412123456A',
            'direccion' => 'Calle Falsa 123',
        ]);
        $response->assertSessionHasErrors('telefono');
    }

    /** @test */
    public function it_fails_if_names_or_apellidos_have_unallowed_characters_or_too_long()
    {
        // 1. Forbidden character like $
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '12345678',
            'nombres' => 'Juan$Perez',
            'apellidos' => 'Perez',
            'telefono' => '04121234567',
            'direccion' => 'Calle Falsa 123',
        ]);
        $response->assertSessionHasErrors('nombres');

        // 1b. Forbidden character like '
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '12345678',
            'nombres' => "Juan O'Perez",
            'apellidos' => 'Perez',
            'telefono' => '04121234567',
            'direccion' => 'Calle Falsa 123',
        ]);
        $response->assertSessionHasErrors('nombres');

        // 1c. Forbidden character like - in apellidos
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '12345678',
            'nombres' => 'Juan',
            'apellidos' => 'Perez-Diaz',
            'telefono' => '04121234567',
            'direccion' => 'Calle Falsa 123',
        ]);
        $response->assertSessionHasErrors('apellidos');

        // 2. Too long nombres (> 50 chars)
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '12345678',
            'nombres' => str_repeat('A', 51),
            'apellidos' => 'Perez',
            'telefono' => '04121234567',
            'direccion' => 'Calle Falsa 123',
        ]);
        $response->assertSessionHasErrors('nombres');
    }

    /** @test */
    public function it_fails_if_direccion_exceeds_50_characters()
    {
        $response = $this->actingAs($this->admin)->post(route('client.store'), [
            'cedula' => '12345678',
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'telefono' => '04121234567',
            'direccion' => str_repeat('A', 51),
        ]);
        $response->assertSessionHasErrors('direccion');
    }

    /** @test */
    public function it_validates_new_client_inline_fields_when_placing_order()
    {
        // Attempting to place an order with an invalid new client
        $response = $this->actingAs($this->admin)->post(route('home.guardarorden'), [
            'cedula_name' => '123456789', // Invalid >8 chars
            'client_nom' => 'María',
            'client_ape' => 'Pérez',
            'client_tel' => '04121234567',
            'client_dir' => 'Calle Falsa 123',
            'plist' => [], // empty product list
            'mlist' => [], // empty payment methods list
        ]);

        $response->assertSessionHasErrors('cedula_name');
    }
}
