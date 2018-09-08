<?php

Route::get('/resultentry/{event_id}','AdminController@resultEntry');
Route::get('/resultentry/{event_id}/{heat_id}','AdminController@heatResult');
Route::post('/resultentry/{event_id}/{heat_id}','AdminController@saveResult');
