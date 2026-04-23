<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::where('is_active', true)->withCount('products');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        return view('brand.index', ['brands' => $query->latest()->paginate(10)->appends($request->query())]);
    }

    public function inactivos(Request $request)
    {
        $query = Brand::where('is_active', false)->withCount('products');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        return view('brand.inactivos', ['brands' => $query->latest()->paginate(10)->appends($request->query())]);
    }

    public function create()
    {
        return view('brand.create');
    }

    public function store(BrandRequest $request)
    {
        Brand::create($request->all([
            'name',

        ]));
        return redirect()->route('brands.index');
    }

    public function show(Brand $brand)
    {
        return view('brand.show',[
            'brand' => $brand,
        ]);
    }

    public function edit(Brand $brand)
    {
        return view('brand.edit',[
            'brand' => $brand,
        ]);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->all([

            'name',
            'description',
        ]));

        return redirect()->route('brands.index');
    }


    public function destroy(Brand $brand)
    {
        $brand->is_active = !$brand->is_active;
        $brand->save();
        return redirect()->back()->with('success', 'Estado de la marca actualizado.');
    }

    public function restore($brand)
    {
        $brand = Brand::where('id',$brand)->first();
        $brand->is_active = true;
        $brand->save();
        return redirect()->back()->with('success', 'Marca reactivada.');
    }
}
