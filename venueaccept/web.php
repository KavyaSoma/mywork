Route::get('/venueevents/{venue_id}','VenueController@venueevents');
Route::post('/venueevents/{venue_id}','VenueController@acceptevent');