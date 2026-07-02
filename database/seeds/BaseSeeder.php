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
        // 1. Create Base Admin (if not exists)
        \App\User::firstOrCreate(
            ['email' => 'admin@gigi.com'],
            [
                'name' => 'admin',
                'password' => '12345678',
                'role' => 'super_admin'
            ]
        );

        // 2. Base Exchangerate
        \App\Exchangerate::firstOrCreate(
            ['value' => '450.00']
        );

        // 2.5 Base Payment Methods
        $metodos = [
            ['nombre_metodo' => 'Pagos con Tarjeta (Bs)', 'ref' => false, 'moneda' => 'Bs'],
            ['nombre_metodo' => 'Pago Móvil (Bs)', 'ref' => true, 'moneda' => 'Bs'],
            ['nombre_metodo' => 'Efectivo (Bs)', 'ref' => false, 'moneda' => 'Bs'],
            ['nombre_metodo' => 'Efectivo (USD)', 'ref' => false, 'moneda' => '$'],
            ['nombre_metodo' => 'Zelle (USD)', 'ref' => true, 'moneda' => '$'],
        ];
        foreach ($metodos as $metodo) {
            \App\Metodo_de_pago::firstOrCreate(
                ['nombre_metodo' => $metodo['nombre_metodo']],
                $metodo
            );
        }
    }
}
