<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'staff', 'namespace' => 'Admin'], function() {

    Route::group(['prefix' => 'ranks'], function() {
        Route::get('/', ['as' => 'admin.staff_alfiory.ranks', 'middleware' => 'permissions:DASHBOARD_STAFF_VIEW_RANKS|admin', 'uses' => 'RanksController@index']);
        Route::post('/add_rank', ['as' => 'admin.staff_alfiory.add_rank', 'middleware' => 'permissions:DASHBOARD_STAFF_ADD_RANK|admin', 'uses' => 'RanksController@add_rank']);
        Route::post('/delete_rank', ['as' => 'admin.staff_alfiory.delete_rank', 'middleware' => 'permissions:DASHBOARD_STAFF_DELETE_RANK|admin', 'uses' => 'RanksController@delete_rank']);
        Route::post('/edit_rank', ['as' => 'admin.staff_alfiory.edit_rank', 'middleware' => 'permissions:DASHBOARD_STAFF_EDIT_RANK|admin', 'uses' => 'RanksController@edit_rank']);
    });

    Route::group(['prefix' => 'members'], function() {
        Route::get('/', ['as' => 'admin.staff_alfiory.members', 'middleware' => 'permissions:DASHBOARD_STAFF_VIEW_MEMBERS|admin', 'uses' => 'StaffMembersController@index']);
        Route::post('/add_member', ['as' => 'admin.staff_alfiory.add_member', 'middleware' => 'permissions:DASHBOARD_STAFF_ADD_MEMBER|admin', 'uses' => 'StaffMembersController@add_member']);
        Route::post('/delete_member', ['as' => 'admin.staff_alfiory.delete_member', 'middleware' => 'permissions:DASHBOARD_STAFF_DELETE_MEMBER|admin', 'uses' => 'StaffMembersController@delete_member']);
        Route::post('/edit_member', ['as' => 'admin.staff_alfiory.edit_member', 'middleware' => 'permissions:DASHBOARD_STAFF_EDIT_MEMBER|admin', 'uses' => 'StaffMembersController@edit_member']);
    });
});