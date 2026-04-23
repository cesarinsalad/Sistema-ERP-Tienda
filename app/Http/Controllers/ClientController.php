<?php

namespace App\Http\Controllers;
use App\Client;
use App\Order;
use App\Product;
use App\Product_order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer(Request $request)
    {
        $query = Client::where('is_active', true);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cedula', 'like', "%{$search}%")
                  ->orWhere('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%");
            });
        }

        $clients = $query->latest()->paginate(10)->appends($request->query());
        return view('clientes.client',compact('clients'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function inactivos(Request $request)
    {
        $query = Client::where('is_active', false);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cedula', 'like', "%{$search}%")
                  ->orWhere('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%");
            });
        }

        $clients = $query->latest()->paginate(10)->appends($request->query());
        return view('clientes.inactivos',compact('clients'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.createclient');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cedula' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
        ]);

        try {
            $client = Client::create($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cliente Creado Exitosamente',
                    'client' => $client
                ]);
            }

            return redirect()->route('client.customer')->with('success','Cliente Creado Exitosamente');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for duplicate entry error (1062)
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = 'La cédula ' . $request->cedula . ' ya se encuentra registrada en el sistema.';
                if ($request->ajax()) {
                    return response()->json(['error' => $errorMessage], 422);
                }
                return back()->withInput()->with('error', $errorMessage);
            }
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($client)
    {
        $data = array();
        $data['client'] = Client::withTrashed()->find($client);

        $preferedProducts = Order::
        join('product_orders', 'product_orders.order_id', '=', 'orders.id')
            ->join('clients', 'clients.id', '=', 'orders.cliente_id')
            ->join('products', 'products.id', '=', 'product_orders.product_id')
            ->selectRaw('products.id, products.nombre, sum(quantity) as total')
            ->where('clients.id', '=', $data['client']->id)
            ->orderBy('total', 'DESC')
            ->limit(3)
            ->groupByRaw('products.id')
            ->get();

        $data['preferedProducts'] = array();
        foreach($preferedProducts as $product){
            $data['preferedProducts'][] = array(
                'id'            =>  $product->id,
                'name'          =>  $product->nombre,
                'total'         =>  $product->total,
            );
        }

        return view('clientes.showclient',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($client)
    {
        $client = Client::withTrashed()->find($client);
        return view('clientes.editclient',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $client)
    {
        $request->validate([
            'cedula' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
        ]);

        $client = Client::withTrashed()->find($client);
        $client->update($request->all());

        return redirect()->route('client.customer')->with('success','Cliente Editado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->is_active = !$client->is_active;
        $client->save();
        return redirect()->back()->with('success', 'Estado del cliente actualizado.');
    }
    public function restore($client)
    {
        $client = Client::where('id',$client)->first();
        $client->is_active = true;
        $client->save();
        return redirect()->back()->with('success', 'Cliente reactivado.');
    }
}

