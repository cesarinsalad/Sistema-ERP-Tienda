<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Client;
use App\User;
use App\Empleados;
use App\Product;
use App\Metodo_de_pago;
use App\Exchangerate;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get basic required data to relate to
        $clients = Client::all();
        $users = User::all();
        $empleados = Empleados::all();
        $products = Product::all();
        $paymentMethods = Metodo_de_pago::all();
        $tasa = Exchangerate::latest()->first();

        if ($clients->isEmpty() || $users->isEmpty() || $products->isEmpty() || $paymentMethods->isEmpty() || !$tasa) {
            $this->command->error('Faltan datos básicos (Clientes, Usuarios, Productos, Métodos de pago o Tasa). Asegúrate de tener al menos uno de cada uno.');
            return;
        }

        $this->command->info('Generando 50 ventas aleatorias en los últimos dos meses...');

        for ($i = 0; $i < 50; $i++) {
            // Generate a random date within the last 60 days
            $randomDate = Carbon::now()->subDays(rand(0, 60))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            // Random relations
            $cliente = $clients->random();
            $cajero = $users->random();
            $vendedor = rand(0, 1) ? $empleados->random() : null; // 50% chance of having a seller

            // Calculate total order amount and select products
            $orderProducts = $products->random(rand(1, 4));
            $totalAmount = 0;
            $pivotData = [];

            foreach ($orderProducts as $product) {
                $qty = rand(1, 3);
                $price = $product->precio; // Assumes USD price
                $totalAmount += ($price * $qty);
                $pivotData[$product->id] = ['precio' => $price, 'quantity' => $qty];
            }

            // Create the Order
            $order = Order::create([
                'cliente_id' => $cliente->id,
                'user_id' => $cajero->id,
                'tasa_cambio' => $tasa->id,
                'monto_orden' => $totalAmount,
                'vendedor_id' => $vendedor ? $vendedor->id : null,
                'commission_paid' => false,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            // Attach products
            $order->products()->attach($pivotData);

            // Attach a random payment method
            // For simplicity, we just use one payment method covering the full amount in USD
            $method = $paymentMethods->random();
            $pagoAmount = $method->moneda == '$' ? $totalAmount : ($totalAmount * $tasa->value);

            // Evitar overflow en base de datos si la tasa es alta y la moneda es Bs
            if ($pagoAmount > 999999) {
                $method = $paymentMethods->where('moneda', '$')->first() ?? $method;
                $pagoAmount = $totalAmount;
            }

            $reference = Str::contains(strtoupper($method->nombre_metodo), 'EFECTIVO') ? null : $faker->numerify('REF########');

            $order->paymentMethods()->attach([
                $method->id => [
                    'monto_pago_orden' => $pagoAmount,
                    'reference' => $reference,
                ]
            ]);
        }

        $this->command->info('Seeder ejecutado con éxito. ¡Ventas generadas!');
    }
}
