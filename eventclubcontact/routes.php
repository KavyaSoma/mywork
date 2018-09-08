Route::get('/edit-eventclub/{id}','EventController@editClubEvent');
Route::post('/edit-eventclub/{id}','EventController@saveEditClubEvent');
Route::get('/edit-contactevent/{id}','EventController@editEventContact');
Route::post('/edit-contactevent/{id}','EventController@SaveEditEventContact');