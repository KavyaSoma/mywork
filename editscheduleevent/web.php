<?php

Route::get('/edit-scheduleevent/{event_id}','EventController@editSchedule');
Route::post('/edit-scheduleevent/{event_id}','EventController@saveEditSchedule');
Route::get('/getoldevents/{type}/{id}','EventController@oldSchedule');