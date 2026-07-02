<?php

use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create Base Admin
        \App\User::create([
            'name' => 'admin',
            'email' => 'admin@gigi.com',
            'password' => '12345678',
            'role' => 'super_admin'
        ]);

        // 2. Base Exchangerate
        \App\Exchangerate::create([
            'value' => '450.00' 
        ]);

        // 2.5 Base Payment Methods
        $metodos = [
            ['nombre_metodo' => 'Pagos con Tarjeta (Bs)', 'ref' => false, 'moneda' => 'Bs'],
            ['nombre_metodo' => 'Pago Móvil (Bs)', 'ref' => true, 'moneda' => 'Bs'],
            ['nombre_metodo' => 'Efectivo (Bs)', 'ref' => false, 'moneda' => 'Bs'],
            ['nombre_metodo' => 'Efectivo (USD)', 'ref' => false, 'moneda' => '$'],
            ['nombre_metodo' => 'Zelle (USD)', 'ref' => true, 'moneda' => '$'],
        ];
        foreach ($metodos as $metodo) {
            \App\Metodo_de_pago::create($metodo);
        }
    }
}
