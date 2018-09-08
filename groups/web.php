<?php

Route::get('/group','SocialController@groups');
Route::post('/group','SocialController@postGroup');
Route::get('/joingroup/{group_id}/{user_id}/{admin}','SocialController@joinGroup');