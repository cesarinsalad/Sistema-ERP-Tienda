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

    public function index(Request $request)
    {
        $query = Vendor::where('is_active', true)->withCount('products');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('document', 'like', "%{$search}%");
            });
        }

        return view('vendor.index', ['vendors' => $query->latest()->paginate(10)->appends($request->query())]);
    }

    public function inactivos(Request $request)
    {
        $query = Vendor::where('is_active', false)->withCount('products');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('document', 'like', "%{$search}%");
            });
        }

        return view('vendor.inactivos', ['vendors' => $query->latest()->paginate(10)->appends($request->query())]);
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
            'email',
            'phone',
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
            'email',
            'phone',
            'description',

        ]));

        return redirect()->route('vendors.index');
        //->with('success','se ha descontado del inventario');
    }


    public function destroy(Vendor $vendor)
    {
        $vendor->is_active = !$vendor->is_active;
        $vendor->save();
        return redirect()->back()->with('success', 'Estado del proveedor actualizado.');
    }

    public function restore($vendor)
    {
        $vendor = Vendor::where('id',$vendor)->first();
        $vendor->is_active = true;
        $vendor->save();
        return redirect()->back()->with('success', 'Proveedor reactivado.');
    }
}
