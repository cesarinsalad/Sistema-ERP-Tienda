<?php

namespace Tests\Feature;

use App\User;
use App\Empleados;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeRolePositionTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create base super admin to manage employees
        $this->admin = factory(User::class)->create(['role' => 'super_admin']);
    }

    /** @test */
    public function it_creates_employee_without_position_input_and_sets_position_to_role_name()
    {
        $response = $this->actingAs($this->admin)->post(route('empleados.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'document' => 'V-12345678',
            'phone' => '04141234567',
            'salary' => '300.00',
            'role' => 'empleado',
        ]);

        $response->assertStatus(302); // Redirects to index
        
        $this->assertDatabaseHas('empleados', [
            'document' => 'V-12345678',
            'position' => 'Empleado',
            'salary' => 300.00,
        ]);
        
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'empleado',
        ]);
    }

    /** @test */
    public function it_updates_employee_role_and_automatically_updates_position()
    {
        // 1. Create a base employee
        $user = factory(User::class)->create(['role' => 'empleado']);
        $employee = factory(Empleados::class)->create([
            'user_id' => $user->id,
            'position' => 'Empleado',
        ]);

        // 2. Update to admin
        $response = $this->actingAs($this->admin)->put(route('empleados.update', $employee->id), [
            'name' => 'John Updated',
            'email' => $user->email,
            'document' => (string) $employee->document,
            'phone' => (string) $employee->phone,
            'salary' => '400.00',
            'role' => 'admin',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('empleados', [
            'id' => $employee->id,
            'position' => 'Administrador',
            'salary' => 400.00,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Updated',
            'role' => 'admin',
        ]);
    }
}
