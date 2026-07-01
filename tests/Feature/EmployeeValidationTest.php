<?php

namespace Tests\Feature;

use App\User;
use App\Empleados;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = factory(User::class)->create(['role' => 'admin']);
    }

    /** @test */
    public function it_stores_valid_employee()
    {
        $response = $this->actingAs($this->admin)->post(route('empleados.store'), [
            'name' => 'Juan Perez',
            'email' => 'juan@gigifashion.com',
            'document' => '25123456',
            'phone' => '04121234567',
            'salary' => 200,
            'commission_percent' => 5,
            'role' => 'empleado'
        ]);

        $response->assertStatus(302);
        
        $this->assertDatabaseHas('empleados', [
            'document' => '25123456',
            'phone' => '04121234567',
            'salary' => 200.00,
        ]);
    }

    /** @test */
    public function it_fails_if_document_has_letters_or_too_long()
    {
        // 1. Contains letters
        $response = $this->actingAs($this->admin)->post(route('empleados.store'), [
            'name' => 'Juan Perez',
            'email' => 'juan@gigifashion.com',
            'document' => '2512345A',
            'phone' => '04121234567',
            'salary' => 200,
            'commission_percent' => 5,
            'role' => 'empleado'
        ]);
        $response->assertSessionHasErrors('document');

        // 2. Too long document (> 8 chars)
        $response = $this->actingAs($this->admin)->post(route('empleados.store'), [
            'name' => 'Juan Perez',
            'email' => 'juan@gigifashion.com',
            'document' => '123456789',
            'phone' => '04121234567',
            'salary' => 200,
            'commission_percent' => 5,
            'role' => 'empleado'
        ]);
        $response->assertSessionHasErrors('document');
    }

    /** @test */
    public function it_fails_if_phone_has_letters_or_too_long()
    {
        // 1. Contains letters
        $response = $this->actingAs($this->admin)->post(route('empleados.store'), [
            'name' => 'Juan Perez',
            'email' => 'juan@gigifashion.com',
            'document' => '25123456',
            'phone' => '0412123456A',
            'salary' => 200,
            'commission_percent' => 5,
            'role' => 'empleado'
        ]);
        $response->assertSessionHasErrors('phone');

        // 2. Too long phone (> 11 chars)
        $response = $this->actingAs($this->admin)->post(route('empleados.store'), [
            'name' => 'Juan Perez',
            'email' => 'juan@gigifashion.com',
            'document' => '25123456',
            'phone' => '041212345678',
            'salary' => 200,
            'commission_percent' => 5,
            'role' => 'empleado'
        ]);
        $response->assertSessionHasErrors('phone');
    }
}
