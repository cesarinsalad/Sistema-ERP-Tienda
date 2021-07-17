<?php

namespace App\Http\Controllers;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer()
    {
        $clients = Client::latest()->paginate(5);
  
        return view('clientes.client',compact('clients'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
  
        Client::create($request->all());
   
        return redirect()->route('client.customer');
        
                       // ->with('success','Product created successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {/* 
        $data = array();
        $data['cliente_id'] = $client;

        //GRAFICA ESTIMACIÓN
        //Consultar compras de un producto
        $client = DB::table('clients')
        ->join('ordens', 'ordens.id', '=', 'cliente_id.order_id')
        ->select('clients.quantity', 'clients.precio', 'ordens.monto_orden',  'ordens.created_at')
        ->where('clientes.product_id', '=', $client->id)
        ->get();
        //Promedio de compra
        $cantidadTotal = 0;
        //Lista de compras realizadas al día
        foreach ($ordenes as $client) {
            $cantidadTotal += $client->quantity;
        }
       
       
        //Asignar fechas a la predicción
        $begin = new \DateTime(date("Y-m-d"));
        $end   = new \DateTime(date("Y-m-d"));
        $end   = $end->modify('+30 day');
        //Realizar Predicción
        $listaFechas = array();
        $cantidadPorDia = array();
        $cantidadRestante = $client->cantidad; 
        for($i = $begin; $i >= $end; $i->modify('+1 day')){
            if(($cantidadRestante +  $promedioCompra) > 0){
                $cantidadRestante +=  $promedioCompra;
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
        return view('show',$data); */
       
        return view('clientes.showclient',compact('client'));
            
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clientes.editclient',compact('client'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'cedula' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
        ]);
        
  
        $client->update($request->all());
  
        return redirect()->route('client.customer');
                        //->with('success','Product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
  
        return redirect()->route('client.customer');
                        //->with('success','Product deleted successfully');
    }
}
    
  