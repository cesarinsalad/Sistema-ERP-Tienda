<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\OrderRequest;
use App\Product;
use App\Order;
use App\Metodo_de_pago;
use App\Metodo_pago_orden;
use App\Product_order;
use App\Exchangerate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array();
        $data['tasaDolar'] = Exchangerate::latest('created_at')->first()->value;
        $data['valorDolar'] = number_format((float)(1 / $data['tasaDolar']), 2, '.', '');
        $data['paymentMethods'] = Metodo_de_pago::get();
        return view('home', $data);
    }

    public function searchClient(Request $request)
    {
        $data = array();
        $request->validate([
            'cedula' => 'required|max:20'
        ]);
        $data['client'] = Client::withTrashed()->where('cedula', '=', $request['cedula'])->first();
        return response()->json($data);
    }

    public function searchProduct(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string'
        ]);
        $articulos = Product::where('nombre', 'LIKE', '%' . $request->codigo . '%')
            ->orWhere('codigo', 'LIKE', '%' . $request['codigo'] . '%')
            ->get();
        return response()->json($articulos);
    }

    public function guardarorden(OrderRequest $request)
    {
        $exchangerate = Exchangerate::latest('created_at')->first();
        //Identificar cliente
        if (!$request['client_id_name']) {
            $client = Client::create([
                'cedula' => $request['cedula_name'],
                'nombres' => $request['client_nom'],
                'apellidos' => $request['client_ape'],
                'telefono' => $request['client_tel'],
                'direccion' => $request['client_dir'],
            ]);
            $client_id = $client->id;
        } else {
            $client_id = $request['client_id_name'];
        }

        //Calculo de total general, y total por producto
        $total = 0;
        $productTotals = array();
        foreach ($request['plist'] as $value) {
            $articulo = Product::find($value['id']);
            $productTotals[$value['id']] = $articulo['precio'] * $value['cantidad'];
            $total = $total + ($productTotals[$value['id']]);
            $articulo->cantidad = $articulo['cantidad'] - $value['cantidad'];
            $articulo->save();
        }

        //Registrar orden
        $orden = Order::create([
            'cliente_id' => (int)$client_id,
            'tasa_cambio' => $exchangerate->id,
            'monto_orden' => $total,
        ]);
        //Registrar metodos de pago de una orden
        $metodosDePago = array();
        foreach ($request['mlist'] as $value) {
            $metodosDePago[] = array(
                'id_orden' => $orden->id,
                'id_metodo_pago' => $value['id'],
                'monto_pago_orden' => $value['monto'],
                'reference' => (isset($value['ref']))?$value['ref']:'',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            );
        }
        Metodo_pago_orden::insert($metodosDePago);

        //Registrar productos de una orden
        $productos = array();
        foreach ($request['plist'] as $value) {
            $productos[] = array(
                'order_id' => $orden->id,
                'product_id' => $value['id'],
                'precio' => $productTotals[$value['id']],
                'quantity' => $value['cantidad'],
            );
        }
        Product_order::insert($productos);


        return redirect()->route('home')->with('success', 'Order Generada');
    }


}
