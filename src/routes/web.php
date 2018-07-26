<?php


Route::group([
    'namespace' => 'Softce\Slider\Http\Controllers',
    'prefix' => 'admin/',
    'middleware' => ['web']
    ],function(){

    Route::resource( '/slider', 'SliderController', [ 'as' => 'admin', 'only' => ['index', 'store', 'update', 'destroy'] ] );

});