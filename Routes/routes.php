<?php

use Illuminate\Support\Facades\Route;


Route::get('staff', ['as' => 'staff_alfiory.home', 'uses' => 'StaffController@index']);