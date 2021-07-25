<?php

namespace App\Http\Controllers;
use App\Client;
use App\Product;
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
        $clients = Client::withTrashed()->latest()->paginate(5);

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

        return redirect()->route('client.customer')->with('success','Cliente Creado Exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($client)
    {
        $client = Client::withTrashed()->find($client);
        return view('clientes.showclient',compact('client'));
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
        $client->delete();
        return redirect()->back();
                        //->with('success','Product deleted successfully');
    }
    public function restore($client)
    {
        $client = Client::withTrashed()->where('id',$client)->first();
        $client->restore();
        return redirect()->back();
    }
}

