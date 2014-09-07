<?php

App::bind('Acme\StudentsRepository', 'Acme\Adapter\EloquentStudentsRepository');
Route::get("", "StudentsController@index");
Route::get("/store", "StudentsController@store");
Route::get("/show/{id}", "StudentsController@show");
Route::get("/update/{id}", "StudentsController@update");
