<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Core configurations and Base Admin
        $this->call(BaseSeeder::class);

        // 3. Populate base entities
        factory(\App\Client::class, 50)->create();
        factory(\App\Category::class, 10)->create();
        factory(\App\Brand::class, 10)->create();
        factory(\App\Vendor::class, 10)->create();

        // 4. Populate Products and attach Categories
        factory(\App\Product::class, 100)->create()->each(function ($product) {
            // Attach 1 to 3 random categories
            $categories = \App\Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $product->category()->attach($categories);
        });

        // 5. Populate Employees and their payments
        factory(\App\Empleados::class, 15)->create();
        factory(\App\Pagoempleados::class, 100)->create();

        // 6. Populate Orders and OrderDetails
        factory(\App\Order::class, 200)->create()->each(function ($order) {
            $totalMonto = 0;

            // Add 1 to 5 random products to this order
            $products = \App\Product::inRandomOrder()->take(rand(1, 5))->get();

            foreach ($products as $product) {
                $qty = rand(1, 5);
                $precio = $product->precio;
                
                \App\Product_order::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'precio' => $precio,
                    'quantity' => $qty
                ]);

                $totalMonto += ($precio * $qty);
            }

            // Update order totals
            $order->monto_orden = $totalMonto;
            $order->save();

            // Add Payment Method for the order
            \App\Metodo_pago_orden::create([
                'id_orden' => $order->id,
                'id_metodo_pago' => rand(1, 5),
                'monto_pago_orden' => $totalMonto,
                'reference' => 'REF-' . rand(1000, 9999)
            ]);
        });
    }
}
