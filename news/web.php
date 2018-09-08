<?php

Route::get('postnews','AdminController@postNews');
Route::post('postnews','AdminController@saveNews');
Route::get('deletenews/{id}','AdminController@deleteNews');