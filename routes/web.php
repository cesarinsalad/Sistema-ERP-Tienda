<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::view('/','welcome');
Auth::routes();

// ==========================================
// EMPLOYEE & ADMIN SHARED ROUTES (Authenticated)
// ==========================================
// ==========================================
// ADMIN ONLY ROUTES 
// ==========================================
Route::middleware(['auth', 'can:admin'])->group(function () {
    // Productos e Inactivos (Definidos antes de los wildcards)
    Route::get('/articulo/inactivos', 'ProductController@inactivos')->name('articulo.inactivos');
    Route::get('/clients/inactivos', 'ClientController@inactivos')->name('client.inactivos');
    Route::get('/vendors/inactivos', 'VendorController@inactivos')->name('vendors.inactivos');
    Route::get('/categories/inactivos', 'CategoryController@inactivos')->name('categories.inactivos');
    Route::get('/brands/inactivos', 'BrandController@inactivos')->name('brands.inactivos');
    Route::get('/empleados_inactivos', 'EmpleadosController@inactivos')->name('empleados.inactivos');

    // Resto de rutas Admin
    Route::get('admin/index', 'ProductController@index');
    Route::resource('/articulo','ProductController')->except(['show']);
    Route::put('/products/{product}/restore','ProductController@restore')->name('products.restore');

    Route::resource('/vendors','VendorController');
    Route::put('/vendors/{vendor}/restore','VendorController@restore')->name('vendors.restore');

    Route::resource('/categories','CategoryController');
    Route::put('/categories/{category}/restore','CategoryController@restore')->name('categories.restore');

    Route::resource('/brands','BrandController');
    Route::put('/brands/{brand}/restore','BrandController@restore')->name('brands.restore');

    Route::resource('/client','ClientController')->except(['show', 'store']);
    Route::get('admin/customer', 'ClientController@customer')->name('client.customer');
    Route::put('/clients/{client}/restore','ClientController@restore')->name('client.restore');

    Route::get('admin/metricas','MetricasController@index');
    Route::post('admin/metricas','MetricasController@query')->name('metrics.query');

    Route::get('admin/pagoempleados/pdf-data', 'PagoempleadosController@pdfData')->name('pagoempleados.pdfData');
    Route::resource('empleados', 'EmpleadosController');
    Route::resource('/pagoempleados','PagoempleadosController');
    Route::get('admin/pagoempleados', 'PagoempleadosController@pagoempleados');
    Route::get('admin/empleados', 'EmpleadosController@empleados');

    Route::get('/backups','DB\Restore@index')->name('backups.index');
    Route::post('/backups','DB\Backup@store')->name('backups.store');
    Route::get('/backups/download/{backup}','DB\Restore@download')->name('backups.download');
    Route::delete('/backups/{id}','DB\Restore@destroy')->name('backups.destroy');
});

// ==========================================
// SHARED ROUTES (Wildcards at the bottom)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('admin/home/searchclient', 'HomeController@searchClient')->name('client.search');
    Route::post('admin/home/searchproduct', 'HomeController@searchProduct')->name('product.search');
    Route::post('admin/guardarorden', 'HomeController@guardarorden')->name('home.guardarorden');
    
    Route::get('admin/listorden/pdf-data', 'OrderController@pdfData')->name('listorden.pdfData');
    Route::resource('/listorden', 'OrderController');

    Route::get('admin/listadotasa', 'ExchangerateController@index')->name('listadotasa.index');
    Route::resource('/listadotasa', 'ExchangerateController');

    Route::get('/client/{client}', 'ClientController@show')->name('client.show');
    Route::post('/client', 'ClientController@store')->name('client.store');
    Route::get('/articulo/{articulo}', 'ProductController@show')->name('articulo.show');
});
