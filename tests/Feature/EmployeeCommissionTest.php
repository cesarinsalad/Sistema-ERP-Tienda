<?php

namespace Tests\Feature;

use App\User;
use App\Empleados;
use App\Client;
use App\Product;
use App\Exchangerate;
use App\Metodo_de_pago;
use App\Order;
use App\Pagoempleados;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeCommissionTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create base super admin to manage
        $this->admin = factory(User::class)->create(['role' => 'super_admin']);
    }

    /** @test */
    public function it_creates_employee_with_commission_percent()
    {
        $response = $this->actingAs($this->admin)->post(route('empleados.store'), [
            'name' => 'John Seller',
            'email' => 'john@example.com',
            'document' => 'V-99999999',
            'phone' => '04149999999',
            'salary' => '250.00',
            'commission_percent' => '7.50',
            'role' => 'empleado',
        ]);

        $response->assertStatus(302);
        
        $this->assertDatabaseHas('empleados', [
            'document' => 'V-99999999',
            'commission_percent' => 7.50,
            'salary' => 250.00,
        ]);
    }

    /** @test */
    public function it_updates_employee_commission_percent()
    {
        $user = factory(User::class)->create(['role' => 'empleado']);
        $employee = factory(Empleados::class)->create([
            'user_id' => $user->id,
            'commission_percent' => 5.00,
        ]);

        $response = $this->actingAs($this->admin)->put(route('empleados.update', $employee->id), [
            'name' => 'John Updated',
            'email' => $user->email,
            'document' => (string) $employee->document,
            'phone' => (string) $employee->phone,
            'salary' => '300.00',
            'commission_percent' => '8.25',
            'role' => 'empleado',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('empleados', [
            'id' => $employee->id,
            'commission_percent' => 8.25,
            'salary' => 300.00,
        ]);
    }

    /** @test */
    public function it_processes_sale_with_assigned_vendedor()
    {
        // 1. Prepare database entities
        $client = factory(Client::class)->create();
        $brand = factory(\App\Brand::class)->create();
        $vendor = factory(\App\Vendor::class)->create();
        $product = factory(Product::class)->create([
            'precio' => 100.00,
            'cantidad' => 10,
            'brand_id' => $brand->id,
            'vendor_id' => $vendor->id,
        ]);
        $method = new Metodo_de_pago();
        $method->nombre_metodo = 'EFECTIVO';
        $method->ref = false;
        $method->moneda = '$';
        $method->save();
        
        $sellerUser = factory(User::class)->create(['role' => 'empleado']);
        $vendedor = factory(Empleados::class)->create([
            'user_id' => $sellerUser->id,
            'commission_percent' => 10.00,
        ]);

        // 2. Submit order form
        $response = $this->actingAs($this->admin)->post(route('home.guardarorden'), [
            'client_id_name' => $client->id,
            'vendedor_id' => $vendedor->id,
            'plist' => [
                ['id' => $product->id, 'cantidad' => 2] // Total 200.00 $
            ],
            'mlist' => [
                ['id' => $method->id, 'monto' => 200.00]
            ]
        ]);

        $response->assertStatus(302);
        
        // 3. Verify order structure
        $this->assertDatabaseHas('orders', [
            'cliente_id' => $client->id,
            'vendedor_id' => $vendedor->id,
            'monto_orden' => 200.00,
            'commission_paid' => false,
        ]);

        // 4. Verify commission getter works
        $vendedor = $vendedor->fresh();
        // 10% of 200.00 = 20.00
        $this->assertEquals(20.00, $vendedor->unpaid_commission);
    }

    /** @test */
    public function it_clears_commissions_when_payroll_payment_is_made()
    {
        // 1. Create employee
        $sellerUser = factory(User::class)->create(['role' => 'empleado']);
        $vendedor = factory(Empleados::class)->create([
            'user_id' => $sellerUser->id,
            'commission_percent' => 5.00,
            'salary' => 200.00,
        ]);

        // 2. Create orders manually associated with vendedor
        $rate = Exchangerate::updateTodayRate();
        $client = factory(Client::class)->create();
        
        $order1 = Order::create([
            'cliente_id' => $client->id,
            'user_id' => $this->admin->id,
            'vendedor_id' => $vendedor->id,
            'tasa_cambio' => $rate->id,
            'monto_orden' => 100.00, // 5.00 commission
            'commission_paid' => false,
        ]);

        $order2 = Order::create([
            'cliente_id' => $client->id,
            'user_id' => $this->admin->id,
            'vendedor_id' => $vendedor->id,
            'tasa_cambio' => $rate->id,
            'monto_orden' => 300.00, // 15.00 commission
            'commission_paid' => false,
        ]);

        $this->assertEquals(20.00, $vendedor->unpaid_commission);

        // 3. Process payroll payment of $220.00 (Salary 200.00 + 20.00 Commission)
        $response = $this->actingAs($this->admin)->post(route('pagoempleados.store'), [
            'empleado_id' => $vendedor->id,
            'amount' => 220.00,
            'payment_date' => now()->format('Y-m-d'),
            'payment_method' => 'Efectivo',
        ]);

        $response->assertStatus(302);
        
        // 4. Verify orders marked as commission_paid
        $this->assertDatabaseHas('orders', ['id' => $order1->id, 'commission_paid' => true]);
        $this->assertDatabaseHas('orders', ['id' => $order2->id, 'commission_paid' => true]);

        // 5. Verify unpaid commission is now 0
        $vendedor = $vendedor->fresh();
        $this->assertEquals(0.00, $vendedor->unpaid_commission);
    }
}
