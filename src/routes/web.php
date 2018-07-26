<?php


Route::group([
    'namespace' => 'Softce\Promua\Http\Controllers',
    'prefix' => 'admin/',
    'middleware' => ['web']
    ],function(){

    Route::resource( '/promua', 'PromuaController', [ 'as' => 'admin', 'only' => ['index', 'store'] ] );

});