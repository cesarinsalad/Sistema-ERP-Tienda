<?php

namespace App\Http\Controllers;

use App\Exchangerate;
use Illuminate\Http\Request;

class ExchangerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $exchangerates = Exchangerate::latest()->paginate(5);
  
        return view('listadotasa',compact('exchangerates'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('creartasa');
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
            'value' => ['required', 'numeric'],
        ]);
        if(!$request['value']){
            return \Redirect::back()->withErrors(['Atención! el valor ingresado no puede ser 0']);
        }
        Exchangerate::create([
            'value' => $request->value,
        ]);
        return redirect()->route('listadotasa.index')->with('success','Nueva tasa creada exitosamente');
    }

   

   
}
