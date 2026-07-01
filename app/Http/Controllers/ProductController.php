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
use App\Product_category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with(['brand']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('category_id')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->where('cantidad', '>', 0)->where('cantidad', '<=', 5);
            } elseif ($request->stock === 'out') {
                $query->where('cantidad', '<=', 0);
            }
        }

        $articulos = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());
        $tasaDolar = Exchangerate::updateTodayRate()->value;
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $vendors = Vendor::where('is_active', true)->orderBy('name')->get();

        return view('product.index', compact('articulos', 'tasaDolar', 'brands', 'categories', 'vendors'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function inactivos(Request $request)
    {
        $query = Product::where('is_active', false)->with(['brand']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('category_id')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->where('cantidad', '>', 0)->where('cantidad', '<=', 5);
            } elseif ($request->stock === 'out') {
                $query->where('cantidad', '<=', 0);
            }
        }

        $articulos = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());
        $tasaDolar = Exchangerate::updateTodayRate()->value;
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $vendors = Vendor::where('is_active', true)->orderBy('name')->get();

        return view('product.inactivos', compact('articulos', 'tasaDolar', 'brands', 'categories', 'vendors'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        return view('product.create',[
            'brands' => Brand::where('is_active', true)->get(),
            'categories' => Category::where('is_active', true)->get(),
            'vendors' => Vendor::where('is_active', true)->get(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all([
            'codigo',
            'nombre',
            'descripcion',
            'vendor_id',
            'brand_id',
            'cantidad',
            'precio',
        ]));
        //Save Categories
        $categories = array();
        foreach ($request['category_id'] as $value) {
            $categories[] = array(
                'product_id' => $product->id,
                'category_id' => $value,
            );
        }
        Product_category::insert($categories);
        return redirect()->route('articulo.index')->with('success','Producto Creado Exitosamente.');
    }

    public function show(Product $articulo)
    {
        $data = array();
        $data['articulo'] = $articulo->load([
            'category',
            'brand',
            'stockPurchases.vendor',
        ]);

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
        $articulo->load([
            'category',
        ]);
        $selectedCategories = array();
        foreach ($articulo->category as $category) {
            $selectedCategories[] = $category->id;
        }
        return view('product.edit',[
            'articulo' => $articulo,
            'brands' => Brand::where('is_active', true)->get(),
            'categories' => Category::where('is_active', true)->get(),
            'selectedCategories' => json_encode($selectedCategories),
            'vendors' => Vendor::where('is_active', true)->get(),
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
            'cantidad',
            'precio',
        ]));
        $categories = array();
        foreach ($request['category_id'] as $value) {
            $categories[] = array(
                'product_id' => $articulo->id,
                'category_id' => $value,
            );
        }
        Product_category::where('product_id', $articulo->id)->delete();
        Product_category::insert($categories);

        return redirect()->route('articulo.index')->with('success','Se Ha Actualizado El Inventario');
    }


    public function destroy(Product $articulo)
    {
        $articulo->is_active = !$articulo->is_active;
        $articulo->save();
        return redirect()->back()->with('success', 'Estado del producto actualizado.');
    }

    public function restore($product)
    {
        $product = Product::where('id',$product)->first();
        $product->is_active = true;
        $product->save();
        return redirect()->back()->with('success', 'Producto reactivado.');
    }

    public function addStock(Request $request, Product $articulo)
    {
        $request->validate([
            'cantidad_adicional' => 'required|integer|min:1',
            'vendor_id'          => 'required|exists:vendors,id',
            'costo_unitario'     => 'required|numeric|min:0',
            'fecha_compra'       => 'required|date',
            'lote_factura'       => 'nullable|string|max:100',
        ]);

        \App\StockPurchase::create([
            'product_id'     => $articulo->id,
            'vendor_id'      => $request->vendor_id,
            'cantidad'       => $request->cantidad_adicional,
            'costo_unitario' => $request->costo_unitario,
            'fecha_compra'   => $request->fecha_compra,
            'lote_factura'   => $request->lote_factura,
        ]);

        $articulo->cantidad += $request->cantidad_adicional;
        $articulo->save();

        return redirect()->back()->with('success', 'Se ha agregado stock y registrado la compra exitosamente para ' . $articulo->nombre);
    }
}
