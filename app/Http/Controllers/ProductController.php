<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Brand;
use App\Category;
use App\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Order;
use App\Product_order;
use App\Exchangerate;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $data = array();
        $data['articulos']  = Product::with(['brand'])->orderBy('id','desc')->paginate(5);
        $data['tasaDolar']  = Exchangerate::latest('created_at')->first()->value;
        return view('product.index',$data)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('product.create',[
            'brands' => Brand::get(),
            'categories' => Category::get(),
            'vendors' => Vendor::get(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->all([
            'codigo',
            'nombre',
            'descripcion',
            'vendor_id',
            'brand_id',
            'category_id',
            'cantidad',
            'precio',
        ]));

        return redirect()->route('articulo.index');

                       // ->with('success','Product created successfully.');
    }

    public function show(Product $articulo)
    {
        $data = array();
        $data['articulo'] = $articulo;

        $ordenes = Product_order::
        join('orders', 'orders.id', '=', 'product_orders.order_id')
            ->selectRaw('sum(quantity) as total, count(*) as quantity')
            ->where('created_at','>', Carbon::now()->subDays(15))
            ->first();

        $promedioCompra = 0;
        if ($ordenes->total){
            //Promedio de compra
            $promedioCompra =  floor($ordenes->total/$ordenes->quantity);
        }

        //Asignar fechas a la predicción
        $begin = Carbon::now();
        //Realizar Predicción
        $listaFechas = array();
        $cantidadPorDia = array();
        $cantidadRestante = $articulo->cantidad;
        for($i = 1; $i <= 15; $i++){
            if(($cantidadRestante -  $promedioCompra) > 0){
                $cantidadRestante -=  $promedioCompra;
                if($cantidadRestante<0){$cantidadRestante = 0;}
                $listaFechas[] = $begin->format("m-d");
                $cantidadPorDia[] = $cantidadRestante;
            }else{
                $listaFechas[] = $begin->format("m-d");
                $cantidadPorDia[] = 0;
            }
            $begin->addDay();
        }
        $data['comprasPorDia']['listaFechas']    = json_encode($listaFechas);
        $data['comprasPorDia']['cantidadPorDia'] = json_encode($cantidadPorDia);
        return view('product.show',$data);
    }

    public function edit(Product $articulo)
    {
        return view('product.edit',[
            'articulo' => $articulo,
            'brands' => Brand::get(),
            'categories' => Category::get(),
            'vendors' => Vendor::get(),
        ]);
    }

    public function update(ProductRequest $request, Product $articulo)
    {
        $articulo->update($request->all([
            'codigo',
            'nombre',
            'descripcion',
            'vendor_id',
            'brand_id',
            'category_id',
            'cantidad',
            'precio',
        ]));

        return redirect()->route('articulo.index');
         //->with('success','se ha descontado del inventario');
    }


    public function destroy(Product $product)
    {

        $product->delete();
        return redirect()->route('products.index');
    }

    public function restore($product)
    {
        $product = Product::withTrashed()->where('id',$product)->first();
        $product->restore();
        return redirect()->back();
    }
}
