<?php

namespace Tests\Feature;

use App\Brand;
use App\Product;
use App\User;
use App\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddStockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_add_stock_to_a_product()
    {
        // 1. Create dependencies
        $brand = factory(Brand::class)->create();
        $vendor = factory(Vendor::class)->create();

        // 2. Create product
        $product = factory(Product::class)->create([
            'brand_id' => $brand->id,
            'vendor_id' => $vendor->id,
            'cantidad' => 10,
        ]);

        // 3. Create admin user
        $admin = factory(User::class)->create([
            'role' => 'admin',
        ]);

        // 4. Request adding stock
        $response = $this->actingAs($admin)
            ->from(route('articulo.index'))
            ->post(route('articulo.addStock', $product->id), [
                'cantidad_adicional' => 15,
                'vendor_id' => $vendor->id,
                'costo_unitario' => 5.50,
                'fecha_compra' => '2026-06-17',
                'lote_factura' => 'LOTE-100200',
            ]);

        // 5. Assertions
        $response->assertRedirect(route('articulo.index'));
        $response->assertSessionHas('success');

        $this->assertEquals(25, $product->fresh()->cantidad);

        // Assert purchase log was created
        $this->assertDatabaseHas('stock_purchases', [
            'product_id' => $product->id,
            'vendor_id' => $vendor->id,
            'cantidad' => 15,
            'costo_unitario' => 5.50,
            'fecha_compra' => '2026-06-17',
            'lote_factura' => 'LOTE-100200',
        ]);
    }

    /** @test */
    public function non_admin_cannot_add_stock_to_a_product()
    {
        $brand = factory(Brand::class)->create();
        $vendor = factory(Vendor::class)->create();
        $product = factory(Product::class)->create([
            'brand_id' => $brand->id,
            'vendor_id' => $vendor->id,
            'cantidad' => 10,
        ]);

        $regularUser = factory(User::class)->create([
            'role' => 'employee',
        ]);

        $response = $this->actingAs($regularUser)
            ->post(route('articulo.addStock', $product->id), [
                'cantidad_adicional' => 15,
                'vendor_id' => $vendor->id,
                'costo_unitario' => 5.50,
                'fecha_compra' => '2026-06-17',
            ]);

        $response->assertStatus(403); // Forbidden
        $this->assertEquals(10, $product->fresh()->cantidad);
    }
}
