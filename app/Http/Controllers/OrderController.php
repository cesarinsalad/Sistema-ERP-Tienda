<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orden;
use App\Home;

class ListordeneController extends Controller
{
    public function index(){
        $orders = Orden::with(['client','tasa'])->paginate(6);
         return view('listorden',compact('orders'));
 
    }
    public function show(Orden $listorden)
    {
        $listorden->load([
            'client',
            'products',
            'paymentMethods',
            'tasa'
        ]);
        return view('showorden',['order'=>$listorden]);
    }

  /*  public function regresar()
   {

    Route::get('home', function () {
        return redirect('listorden/home');
    });
   
   
    } */
}
