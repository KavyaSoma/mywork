
Route::get('/deletepool/{venue_id}/{pool_id}','VenueController@deletepool');
Route::get('/delete-venuecontact/{venue_id}/{contact_id}','VenueController@deleteContact');
Route::get('/checkshortname/venue/{shortname}','VenueController@venueshortname');
