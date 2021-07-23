<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with(['client','tasa'])->paginate(6);
         return view('listorden',compact('orders'));

    }
    public function show(Order $listorden)
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
