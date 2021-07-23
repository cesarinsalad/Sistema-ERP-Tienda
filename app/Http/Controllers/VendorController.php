<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\VendorRequest;
use App\Product;
use App\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{

    public function index()
    {
        return view('vendor.index',[
            'vendors' => Vendor::paginate()
        ]);
    }


    public function create()
    {
        return view('vendor.create');
    }


    public function store(VendorRequest $request)
    {
        Vendor::create($request->all([

            'name',
            'type_document',
            'document',
            'description',

        ]));

        return redirect()->route('vendors.index');
    }


    public function show(Vendor $vendor)
    {
       return view('vendor.show',[
           'vendor' => $vendor,
       ]);
    }


    public function edit(Vendor $vendor)
    {

        return view('vendor.edit',[

            'vendor' => $vendor,
        ]);
    }

    public function update(VendorRequest $request, Vendor $vendor)
    {
        $vendor->update($request->all([

            'name',
            'type_document',
            'document',
            'description',

        ]));

        return redirect()->route('vendors.index');
        //->with('success','se ha descontado del inventario');
    }


    public function destroy(Vendor $vendor)
    {
        $vendor->products()->delete();
        $vendor->delete();
        return redirect()->route('vendors.index');
    }

    public function restore($vendor)
    {
        $vendor = Vendor::withTrashed()->where('id',$vendor)->first();
        $vendor->restore();
        return redirect()->back();
    }
}
