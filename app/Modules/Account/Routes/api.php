<?php

Route::namespace('App\Modules\Account\Controllers')->group(function () {




    Route::group(['middleware' => 'guest:api'], function () {

        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@register');

        Route::post('forgot-password', 'ForgotPasswordController@postForgotPassword');
        Route::post('reset/password', 'ResetPasswordController@callResetPassword');

        Route::post('email/verify', 'VerificationController@verify');
        Route::post('email/resend', 'VerificationController@resend');

    });



    Route::group(['middleware' => ['api']], function () {

        Route::post('/logout', 'AuthController@logout');
        Route::post('/refresh', 'AuthController@refresh');
        Route::post('/recover', 'ForgotPasswordController@postForgotPassword');

        Route::group(['middleware' => ['jwt.auth', 'verified']], function () {

            // autenticado

            Route::get('/user-profile', 'AuthController@userProfile');

        });
    });
});
