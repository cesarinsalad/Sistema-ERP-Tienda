<?php
$m1 = \App\Metodo_de_pago::find(1); 
if($m1){ $m1->nombre_metodo = 'Efectivo (Bs)'; $m1->moneda = 'Bs'; $m1->save(); }

$m2 = \App\Metodo_de_pago::find(2); 
if($m2){ $m2->nombre_metodo = 'Pago Móvil (Bs)'; $m2->moneda = 'Bs'; $m2->save(); }

$m3 = \App\Metodo_de_pago::find(3); 
if($m3){ $m3->nombre_metodo = 'Zelle (USD)'; $m3->moneda = '$'; $m3->save(); }

if(!\App\Metodo_de_pago::where('nombre_metodo', 'Pagos con Tarjeta (Bs)')->exists()) {
    $m4 = new \App\Metodo_de_pago(); $m4->nombre_metodo = 'Pagos con Tarjeta (Bs)'; $m4->ref = 1; $m4->moneda = 'Bs'; $m4->save();
}

if(!\App\Metodo_de_pago::where('nombre_metodo', 'Efectivo (USD)')->exists()) {
    $m5 = new \App\Metodo_de_pago(); $m5->nombre_metodo = 'Efectivo (USD)'; $m5->ref = 0; $m5->moneda = '$'; $m5->save();
}
echo "Done!\n";
