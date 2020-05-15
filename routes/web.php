<?php

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

Route::get('/', function () {
    return view('auth/login');
});

Route::resource('salida_vehiculo', 'Salida_VehiculoController');
Route::resource('ingreso_vehiculo', 'Ingreso_VehiculoController');
Route::resource('vehiculo', 'VehiculoController');
Route::resource('persona', 'PersonaController');
Route::resource('cliente', 'ClienteController');
Route::resource('usuario', 'UserController');
Route::resource('tipo_vehiculo', 'Tipo_VehiculoController');
Route::resource('tarifa', 'TarifaController');
Route::resource('usuario_role', 'UserRoleController');
Route::resource('role', 'RoleController');


Route::get('imprimirClientes','PdfController@imprimirClientes')->name('PdfController.imprimirClientes');
Route::get('imprimirPersonas','PdfController@imprimirPersonas')->name('PdfController.imprimirPersonas');
Route::get('imprimirVehiculos','PdfController@imprimirVehiculos')->name('PdfController.imprimirVehiculos');
Route::get('imprimirVehiculoEspecifico/{id_vehiculo}','PdfController@imprimirVehiculoEspecifico')->name('PdfController.imprimirVehiculoEspecifico');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
