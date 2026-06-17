<?php

namespace Tests\Feature;

use App\User;
use App\Exchangerate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ManualExchangeRateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_force_update_the_exchange_rate_from_dolarapi()
    {
        // 1. Mock DolarApi response
        Http::fake([
            'https://ve.dolarapi.com/v1/dolares/oficial' => Http::response([
                'promedio' => 45.20,
            ], 200),
        ]);

        // 2. Create admin user
        $admin = factory(User::class)->create([
            'role' => 'admin',
        ]);

        // 3. Make POST request from /home
        $response = $this->actingAs($admin)
            ->from(route('home'))
            ->post(route('listadotasa.fetchFromApi'));

        // 4. Assertions
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success');

        // Assert that the record was created in DB
        $this->assertDatabaseHas('exchangerates', [
            'value' => '45.2',
        ]);
    }

    /** @test */
    public function a_regular_user_cannot_force_update_the_exchange_rate_from_dolarapi()
    {
        $regularUser = factory(User::class)->create([
            'role' => 'employee',
        ]);

        $response = $this->actingAs($regularUser)
            ->post(route('listadotasa.fetchFromApi'));

        $response->assertStatus(403); // Forbidden
    }
}
