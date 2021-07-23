<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\Product_order;

class MetricasController extends Controller
{
    public function index(){

        $statisticsOrders = Order::selectRaw('COUNT(*) as total, CONCAT(EXTRACT(DAY FROM created_at),"-",EXTRACT(MONTH FROM created_at)) AS date')
            ->where('created_at','>', \Carbon\Carbon::now()->subWeek())
            ->groupByRaw('date')
            ->get();

        $statisticsProducts = Product_order::
            join('ordens', 'ordens.id', '=', 'product_orders.order_id')
            ->selectRaw('sum(quantity) as total, CONCAT(EXTRACT(DAY FROM ordens.created_at),"-",EXTRACT(MONTH FROM ordens.created_at)) AS date')
            ->where('created_at','>', \Carbon\Carbon::now()->subWeek())
            ->groupByRaw('date')
            ->get();

        $statisticsWins = Product_order::
             join('ordens', 'ordens.id', '=', 'product_orders.order_id')
            ->join('articulos', 'articulos.id', '=', 'product_orders.product_id')
            ->selectRaw('sum(product_orders.quantity * articulos.precio) as total, CONCAT(EXTRACT(DAY FROM ordens.created_at),"-",EXTRACT(MONTH FROM ordens.created_at)) AS date')
            ->where('ordens.created_at','>', \Carbon\Carbon::now()->subWeek())
            ->groupByRaw('date')
            ->get();

        $listaFechasOrders = [];
        $cantidadPorDiaOrders = [];
        foreach($statisticsOrders as $order){
            array_push($listaFechasOrders, $order->date);
            array_push($cantidadPorDiaOrders, $order->total);
        }
        $listaFechasOrders    = json_encode($listaFechasOrders);
        $cantidadPorDiaOrders = json_encode($cantidadPorDiaOrders);

        $listaFechasProducts = [];
        $cantidadPorDiaProducts = [];
        foreach($statisticsProducts as $order){
            array_push($listaFechasProducts, $order->date);
            array_push($cantidadPorDiaProducts, $order->total);
        }
        $listaFechasProducts    = json_encode($listaFechasProducts);
        $cantidadPorDiaProducts = json_encode($cantidadPorDiaProducts);

        $listaFechasWins = [];
        $cantidadPorDiaWins = [];
        foreach($statisticsWins as $order){
            array_push($listaFechasWins, $order->date);
            array_push($cantidadPorDiaWins, $order->total);
        }
        $listaFechasWins    = json_encode($listaFechasWins);
        $cantidadPorDiaWins = json_encode($cantidadPorDiaWins);

        return view ('metricas', compact([
            'statisticsOrders',
            'listaFechasOrders',
            'cantidadPorDiaOrders',
            'listaFechasProducts',
            'cantidadPorDiaProducts',
            'listaFechasWins',
            'cantidadPorDiaWins',
        ]));
    }


   public function show(Articulo $articulo){


    $data = array();
    $data['articulo'] = $articulo;

    //GRAFICA ESTIMACIÓN
    //Consultar compras de un producto
    $ordenes = DB::table('product_orders')
    ->join('ordens', 'ordens.id', '=', 'product_orders.order_id')
    ->select('product_orders.quantity', 'product_orders.precio', 'ordens.monto_orden',  'ordens.created_at')
    ->where('product_orders.product_id', '=', $articulo->id)
    ->get();
    //Promedio de compra
    $cantidadTotal = 0;
    //Lista de compras realizadas al día
    foreach ($ordenes as $orden) {
        $cantidadTotal += $orden->quantity;
    }
    if(count($ordenes)){
        $promedioCompra =  floor($ordenes/count($ordenes));
    }else{
        $promedioCompra = 0;
    }

    //Asignar fechas a la predicción
    $begin = new \DateTime(date("Y-m-d"));
    $end   = new \DateTime(date("Y-m-d"));
    $end   = $end->modify('+14 day');
    //Realizar Predicción
    $listaFechas = array();
    $cantidadPorDia = array();
    $cantidadRestante = $articulo->cantidad;
    for($i = $begin; $i <= $end; $i->modify('+1 day')){
        if(($cantidadRestante -  $promedioCompra) > 0){
            $cantidadRestante -=  $promedioCompra;
            if($cantidadRestante<0){$cantidadRestante = 0;}
            $listaFechas[] = $i->format("m-d");
            $cantidadPorDia[] = $cantidadRestante;
        }else{
            $listaFechas[] = $i->format("m-d");
            $cantidadPorDia[] = 0;
        }
    }
    $data['comprasPorDia']['listaFechas']    = json_encode($listaFechas);
    $data['comprasPorDia']['cantidadPorDia'] = json_encode($cantidadPorDia);
    dd($data);
    return view('show',$data);



   }








}
