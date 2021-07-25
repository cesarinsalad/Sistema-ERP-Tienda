<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\Product_order;

class MetricasController extends Controller
{
    public function index(){
        $data = array();
        $data['fromDate'] = \Carbon\Carbon::now()->subDays(7)->format('Y-m-d');
        $data['toDate'] = \Carbon\Carbon::now()->addDays(1)->format('Y-m-d');

        $data = array_merge($data, $this->getOrderQuantityMetrics(array(
            'fromDate'  => $data['fromDate'],
            'toDate'    => $data['toDate'],
        )));
        $data = array_merge($data, $this->getProductQuantityMetrics(array(
            'fromDate'  => $data['fromDate'],
            'toDate'    => $data['toDate'],
        )));
        $data = array_merge($data, $this->getProductGainMetrics(array(
            'fromDate'  => $data['fromDate'],
            'toDate'    => $data['toDate'],
        )));
        return view ('metricas', $data);
    }

    public function getOrderQuantityMetrics($data){
        $response = array();
        $response['statisticsOrders'] = Order::selectRaw('COUNT(*) as total, CONCAT(EXTRACT(DAY FROM created_at),"-",EXTRACT(MONTH FROM created_at)) AS date')
            ->whereBetween('created_at', [
                $data['fromDate'],
                $data['toDate'],
            ])
            ->groupByRaw('date')
            ->get();
        $listaFechasOrders = array();
        $cantidadPorDiaOrders = array();
        foreach($response['statisticsOrders'] as $order){
            array_push($listaFechasOrders, $order->date);
            array_push($cantidadPorDiaOrders, $order->total);
        }
        $response['listaFechasOrders']    = json_encode($listaFechasOrders);
        $response['cantidadPorDiaOrders'] = json_encode($cantidadPorDiaOrders);
        return $response;
    }

    public function getProductQuantityMetrics($data){
        $response = array();
        $response['statisticsProducts'] = Product_order::
        join('orders', 'orders.id', '=', 'product_orders.order_id')
            ->selectRaw('sum(quantity) as total, CONCAT(EXTRACT(DAY FROM orders.created_at),"-",EXTRACT(MONTH FROM orders.created_at)) AS date')
            ->whereBetween('created_at', [
                $data['fromDate'],
                $data['toDate'],
            ])
            ->groupByRaw('date')
            ->get();
        $listaFechasProducts = array();
        $cantidadPorDiaProducts = array();
        foreach($response['statisticsProducts'] as $order){
            array_push($listaFechasProducts, $order->date);
            array_push($cantidadPorDiaProducts, $order->total);
        }
        $response['listaFechasProducts']    = json_encode($listaFechasProducts);
        $response['cantidadPorDiaProducts'] = json_encode($cantidadPorDiaProducts);
        return $response;
    }

    public function getProductGainMetrics($data){
        $response = array();
        $response['statisticsWins'] = Order::selectRaw('SUM(monto_orden) as total, CONCAT(EXTRACT(DAY FROM created_at),"-",EXTRACT(MONTH FROM created_at)) AS date')
            ->whereBetween('orders.created_at', [
                $data['fromDate'],
                $data['toDate'],
            ])
            ->groupByRaw('date')
            ->get();
        $listaFechasWins = [];
        $cantidadPorDiaWins = [];
        $response['totalGain'] = 0;
        foreach($response['statisticsWins'] as $order){
            array_push($listaFechasWins, $order->date);
            array_push($cantidadPorDiaWins, $order->total);
            $response['totalGain'] +=  $order->total;
        }
        $response['listaFechasWins']    = json_encode($listaFechasWins);
        $response['cantidadPorDiaWins'] = json_encode($cantidadPorDiaWins);
        return $response;
    }
}
