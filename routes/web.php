<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloControler;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/','welcome');


Route::get('admin/pagoempleados', 'PagoempleadosController@pagoempleados');
Route::get('admin/empleados', 'EmpleadosController@empleados');

Route::get('admin/index','Listordene@index');

Route::get('admin/index', 'ArticuloControler@index');
Route::get('admin/customer', 'ClientController@customer')->name('client.customer');
Route::post('admin/home/searchclient', 'HomeController@searchClient')->name('client.search');
Route::post('admin/home/searchproduct', 'HomeController@searchProduct')->name('product.search');
Route::post('admin/guardarorden', 'HomeController@guardarorden')->name('home.guardarorden');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('/articulo','ArticuloControler');

Route::resource('/client','ClientController');

Route::resource('/empleados','EmpleadosController');

Route::resource('/pagoempleados','PagoempleadosController');

Route::resource('/listorden', 'ListordeneController');