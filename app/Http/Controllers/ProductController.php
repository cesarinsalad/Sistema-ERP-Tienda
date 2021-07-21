<?php

namespace App\Http\Controllers;
use App\Articulo;
use App\Brand;
use App\Category;
use App\Vendor;
use Illuminate\Http\Request;
use App\Orden;
use App\Product_order;
use App\Exchangerate;
use Illuminate\Support\Facades\DB;

class ArticuloControler extends Controller
{
    public function index()
    {
        $data = array();
        $data['articulos']  = Articulo::latest()->paginate(5);
        $data['tasaDolar']  = Exchangerate::latest('created_at')->first()->value;
        return view('articulo',$data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('create',[
            'brands' => Brand::get(),
            'categories' => Category::get(),
            'vendors' => Vendor::get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'descripcion' => 'required',
            'cantidad' => 'required',
            'precio' => 'required',
        ]);

        Articulo::create($request->all());

        return redirect()->route('articulo.index');

                       // ->with('success','Product created successfully.');
    }

    /**
     * @param Articulo $articulo
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show(Articulo $articulo)
    {
        $data = array();
        $data['articulo'] = $articulo;

        //GRAFICA ESTIMACIÓN
        //Consultar compras de un producto
        $ordenes = DB::table('product_orders')
        ->join('ordens', 'ordens.id', '=', 'product_orders.order_id')
        ->select('product_orders.quantity', 'product_orders.precio', 'ordens.monto_orden',  'ordens.created_at')
        ->where('product_orders.product_id', '=', $articulo->id)
        ->get();
        //Promedio de compra
        $cantidadTotal = 0;
        //Lista de compras realizadas al día
        foreach ($ordenes as $orden) {
            $cantidadTotal += $orden->quantity;
        }
        if(count($ordenes)){
            $promedioCompra =  floor($cantidadTotal/count($ordenes));
        }else{
            $promedioCompra = 0;
        }

        //Asignar fechas a la predicción
        $begin = new \DateTime(date("Y-m-d"));
        $end   = new \DateTime(date("Y-m-d"));
        $end   = $end->modify('+14 day');
        //Realizar Predicción
        $listaFechas = array();
        $cantidadPorDia = array();
        $cantidadRestante = $articulo->cantidad;
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            if(($cantidadRestante -  $promedioCompra) > 0){
                $cantidadRestante -=  $promedioCompra;
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
        return view('show',$data);
    }

    public function edit(Articulo $articulo)
    {
        return view('edit',compact('articulo'));
    }

    public function update(Request $request, Articulo $articulo)
    {
        $request->validate([
            'codigo' => 'required',
            'descripcion' => 'required',
            'cantidad' => 'required',
            'precio' => 'required',
        ]);


        $articulo->update($request->all());

        return redirect()->route('articulo.index');


                        //->with('success','se ha descontado del inventario');
    }

    public function destroy(Articulo $articulo)
    {
        $articulo->delete();

        return redirect()->route('articulo.index');
                        //->with('success','Product deleted successfully');
    }
}
