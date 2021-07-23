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
    public function index()
    {
        return view('category.index',[
            'categories' => Category::withTrashed()->withCount('products')->paginate(5)
        ]);
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
        $category->products()->delete();
        $category->delete();
        return redirect()->route('categories.index');
    }

    public function restore($category)
    {
        $category = Category::withTrashed()->where('id',$category)->first();
        $category->restore();
        return redirect()->back();
    }
}
