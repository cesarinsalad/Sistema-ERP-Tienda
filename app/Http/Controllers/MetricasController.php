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

        //Top 10 sold products
        $top10Products = Order::
        join('product_orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'product_orders.product_id')
            ->selectRaw('products.id, products.nombre, sum(quantity) as total, SUM(product_orders.quantity * product_orders.precio) as gain')
            ->whereBetween('orders.created_at', [
                $data['fromDate'],
                $data['toDate'],
            ])
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->groupByRaw('products.id')
            ->get();
        $response['top10Products'] = array();
        foreach ($top10Products as $product ) {
            $response['top10Products'][] = array(
                'id'        => $product->id,
                'name'      => $product->nombre,
                'total'     => $product->total,
                'gain'      => $product->gain,
            );
        }

        //Top 10 categories
        $top10Categories = Order::
        join('product_orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'product_orders.product_id')
            ->join('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'product_categories.category_id')
            ->selectRaw('categories.id, categories.name, sum(quantity) as total, SUM(product_orders.quantity * product_orders.precio) as gain')
            ->whereBetween('orders.created_at', [
                $data['fromDate'],
                $data['toDate'],
            ])
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->groupByRaw('categories.id')
            ->get();
        $response['top10Categories'] = array();
        foreach ($top10Categories as $category ) {
            $response['top10Categories'][] = array(
                'id'        => $category->id,
                'name'      => $category->name,
                'total'     => $product->total,
                'gain'      => $product->gain,
            );
        }
        //Top 10 categories
        $top10Clients = Order::
        join('product_orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('clients', 'clients.id', '=', 'orders.cliente_id')
            ->selectRaw('clients.id, CONCAT(clients.nombres , " " , clients.apellidos) as name, sum(quantity) as total, SUM(product_orders.quantity * product_orders.precio) as gain')
            ->whereBetween('orders.created_at', [
                $data['fromDate'],
                $data['toDate'],
            ])
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->groupByRaw('clients.id')
            ->get();
        $response['top10Clients'] = array();
        foreach ($top10Clients as $client ) {
            $response['top10Clients'][] = array(
                'id'        => $client->id,
                'name'      => $client->name,
                'total'     => $client->total,
                'gain'      => $client->gain,
            );
        }
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
    public function query(Request $request){
        $data = array();
        $data['fromDate'] = $request->fromDate;
        $data['toDate'] = $request->toDate;

        if(new \DateTime($data['fromDate']) >= new \DateTime($data['toDate'])){
            return redirect()->back()->withErrors('Fechas Inválidas Ingresadas, Por Favor, Verifique e Intente Nuevamente');
        }

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
}
