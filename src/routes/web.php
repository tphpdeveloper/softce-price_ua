<?php


Route::group([
    'namespace' => 'Softce\Promua\Http\Controllers',
    'prefix' => 'admin/promua/',
    'middleware' => ['web']
    ],function(){


    Route::get('show', ['as' => 'admin.promua.show', 'uses' => 'PromuaController@show']);
    Route::post('create', ['as' => 'admin.promua.create', 'uses' => 'PromuaController@create']);

});