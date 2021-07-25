<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::view('/','welcome');


Route::get('admin/pagoempleados', 'PagoempleadosController@pagoempleados');
Route::get('admin/empleados', 'EmpleadosController@empleados');
Route::get('admin/listadotasa', 'ExchangerateController@index')->name('listadotasa.index');
Route::get('admin/index','Listordene@index');

Route::get('admin/metricas','MetricasController@index');
Route::post('admin/metricas','MetricasController@query')->name('metrics.query');

Route::get('admin/index', 'ProductController@index');
Route::get('admin/customer', 'ClientController@customer')->name('client.customer');

Route::post('admin/home/searchclient', 'HomeController@searchClient')->name('client.search');
Route::post('admin/home/searchproduct', 'HomeController@searchProduct')->name('product.search');
Route::post('admin/guardarorden', 'HomeController@guardarorden')->name('home.guardarorden');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('/articulo','ProductController');

Route::resource('/client','ClientController');

Route::resource('/empleados','EmpleadosController');

Route::resource('/pagoempleados','PagoempleadosController');

Route::resource('/brands','BrandController');
Route::resource('/categories','CategoryController');
Route::resource('/vendors','VendorController');

Route::put('/brands/{brand}/restore','BrandController@restore')->name('brands.restore');
Route::put('/categories/{category}/restore','CategoryController@restore')->name('categories.restore');
Route::put('/vendors/{vendor}/restore','VendorController@restore')->name('vendors.restore');
Route::put('/products/{product}/restore','ProductController@restore')->name('products.restore');
Route::put('/clients/{client}/restore','ClientController@restore')->name('client.restore');

Route::resource('/listorden', 'OrderController');

Route::resource('/listadotasa', 'ExchangerateController');

