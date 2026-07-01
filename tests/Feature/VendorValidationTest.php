<?php

namespace Tests\Feature;

use App\User;
use App\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendorValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = factory(User::class)->create(['role' => 'admin']);
    }

    /** @test */
    public function it_stores_valid_vendor()
    {
        $response = $this->actingAs($this->admin)->post(route('vendors.store'), [
            'name' => 'Proveedor S.A.',
            'type_document' => 'RIF',
            'document' => 'J-12345678-9',
            'email' => 'vendor@proveedor.com',
            'phone' => '02121234567',
            'description' => 'Servicios generales de tecnología',
        ]);

        $response->assertStatus(302);
        
        $this->assertDatabaseHas('vendors', [
            'name' => 'Proveedor S.A.',
            'type_document' => 'RIF',
            'document' => 'J-12345678-9',
            'email' => 'vendor@proveedor.com',
            'phone' => '02121234567',
        ]);
    }

    /** @test */
    public function it_fails_if_document_has_unallowed_characters_or_too_long()
    {
        // 1. Forbidden character like $
        $response = $this->actingAs($this->admin)->post(route('vendors.store'), [
            'name' => 'Proveedor S.A.',
            'type_document' => 'RIF',
            'document' => 'J-12345678$',
            'email' => 'vendor@proveedor.com',
            'phone' => '02121234567',
            'description' => 'Servicios',
        ]);
        $response->assertSessionHasErrors('document');

        // 2. Too long document (> 15 chars)
        $response = $this->actingAs($this->admin)->post(route('vendors.store'), [
            'name' => 'Proveedor S.A.',
            'type_document' => 'RIF',
            'document' => 'J-12345678-901234',
            'email' => 'vendor@proveedor.com',
            'phone' => '02121234567',
            'description' => 'Servicios',
        ]);
        $response->assertSessionHasErrors('document');
    }

    /** @test */
    public function it_fails_if_phone_has_letters_or_too_long()
    {
        // 1. Phone with letters
        $response = $this->actingAs($this->admin)->post(route('vendors.store'), [
            'name' => 'Proveedor S.A.',
            'type_document' => 'RIF',
            'document' => 'J-12345678-9',
            'email' => 'vendor@proveedor.com',
            'phone' => '0212123456A',
            'description' => 'Servicios',
        ]);
        $response->assertSessionHasErrors('phone');

        // 2. Too long phone (> 11 chars)
        $response = $this->actingAs($this->admin)->post(route('vendors.store'), [
            'name' => 'Proveedor S.A.',
            'type_document' => 'RIF',
            'document' => 'J-12345678-9',
            'email' => 'vendor@proveedor.com',
            'phone' => '021212345678',
            'description' => 'Servicios',
        ]);
        $response->assertSessionHasErrors('phone');
    }
}
