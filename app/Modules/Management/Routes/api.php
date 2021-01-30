<?php

Route::namespace('App\Modules\Management\Controllers')->group(function () {


    Route::group(['middleware' => ['api']], function () {
     
        Route::post('/services/create', 'ServiceController@postCreateService');


        Route::group(['middleware' => ['jwt.auth']], function () {

            // autenticado

        

        });
    });
});
