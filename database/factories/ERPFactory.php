<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Client;
use App\Category;
use App\Brand;
use App\Vendor;
use App\Product;
use App\Empleados;
use App\Pagoempleados;
use App\Order;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'cedula' => $faker->unique()->randomNumber(8),
        'nombres' => $faker->firstName,
        'apellidos' => $faker->lastName,
        'telefono' => $faker->phoneNumber,
        'direccion' => $faker->address,
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->sentence,
    ];
});

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => substr($faker->unique()->company, 0, 20),
    ];
});

$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'name' => substr($faker->company, 0, 40),
        'type_document' => $faker->randomElement(['CI', 'RIF']),
        'document' => $faker->unique()->randomNumber(8),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'description' => $faker->sentence,
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'codigo' => strtoupper($faker->unique()->bothify('PRD-####')),
        'nombre' => $faker->words(3, true),
        'cantidad' => $faker->numberBetween(50, 200),
        'precio' => $faker->randomFloat(2, 5, 500),
        'descripcion' => $faker->sentence,
        'brand_id' => App\Brand::inRandomOrder()->first()->id ?? 1,
        'vendor_id' => App\Vendor::inRandomOrder()->first()->id ?? 1,
        'is_active' => '1',
    ];
});

$factory->define(Empleados::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'document' => $faker->unique()->randomNumber(8),
        'phone' => $faker->phoneNumber,
        'position' => $faker->jobTitle,
        'salary' => $faker->randomFloat(2, 200, 1000),
        'is_active' => true,
    ];
});

$factory->define(Pagoempleados::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-6 months', 'now');
    return [
        'empleado_id' => App\Empleados::inRandomOrder()->first()->id ?? 1,
        'amount' => $faker->randomFloat(2, 100, 500),
        'reference' => $faker->bothify('REF-########'),
        'payment_method' => $faker->randomElement(['Transferencia', 'Efectivo', 'Pago Móvil', 'Zelle']),
        'payment_date' => $createdAt->format('Y-m-d'),
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});

$factory->define(Order::class, function (Faker $faker) {
    $createdAt = $faker->dateTimeBetween('-6 months', 'now');
    return [
        'monto_orden' => 0, 
        'cliente_id' => App\Client::inRandomOrder()->first()->id ?? 1,
        'tasa_cambio' => 1,
        'user_id' => 1, 
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
});
