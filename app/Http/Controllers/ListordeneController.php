<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orden;

class ListordeneController extends Controller
{
    public function index(){
        $orders = Orden::with('client')->paginate(10);
         return view('listorden',compact('orders'));
 
    }
    public function show(Orden $listorden)
    {
        $listorden->load('client');
        $listorden->load('products');
        $listorden->load('paymentMethods');
        return view('showorden',['order'=>$listorden]);
    }
}
