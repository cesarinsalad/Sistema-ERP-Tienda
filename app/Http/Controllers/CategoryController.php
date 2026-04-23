<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Product;
use App\Vendor;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::where('is_active', true)->withCount('products');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        return view('category.index', ['categories' => $query->latest()->paginate(10)->appends($request->query())]);
    }

    public function inactivos(Request $request)
    {
        $query = Category::where('is_active', false)->withCount('products');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        return view('category.inactivos', ['categories' => $query->latest()->paginate(10)->appends($request->query())]);
    }

    public function create()
    {
        return view('category.create');
    }


    public function store(CategoryRequest $request)
    {
        Category::create($request->all([

            'name',
            'description',

        ]));

        return redirect()->route('categories.index');
    }


    public function show(Category $category)
    {
        return view('category.show',[
            'category' => $category,
        ]);
    }


    public function edit(Category $category)
    {
        return view('category.edit',[
            'category' => $category
        ]);
    }


    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all([

            'name',
            'description',
        ]));

        return redirect()->route('categories.index');
        //->with('success','se ha descontado del inventario');

    }


    public function destroy(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();
        return redirect()->back()->with('success', 'Estado de la categoría actualizado.');
    }

    public function restore($category)
    {
        $category = Category::where('id',$category)->first();
        $category->is_active = true;
        $category->save();
        return redirect()->back()->with('success', 'Categoría reactivada.');
    }
}
