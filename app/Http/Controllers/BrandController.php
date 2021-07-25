<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('brand.index',[
            'brands' => Brand::withTrashed('products')->paginate(5)
        ]);
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
        $brand->products()->delete();
        $brand->delete();
        return redirect()->route('brands.index');
    }

    public function restore($brand)
    {
        $brand = Brand::withTrashed()->where('id',$brand)->first();
        $brand->restore();
        return redirect()->back();
    }
}
