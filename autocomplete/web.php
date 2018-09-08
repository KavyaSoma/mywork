Route::get('/contactvenue/{type}/{contact}','VenueController@autocomplete');
Route::get('/eventclub/{club}','EventController@clubevent');
Route::get('/eventcontact/{contact}','EventController@autocontact');
Route::get('/eventvenues/{venue}','EventController@venuesevent');
Route::get('/addressinstructor/{address}','InstructorController@autocompleteaddress');
Route::get('/clubaddress/{type}/{key}','ClubController@autocompleteclub');
Route::get('/contactkin/{key}','UserController@autocompletecontact');
Route::get('sendmessage/{id}','UserController@emailSuggestions');

Route::get('/addkin','UserController@ViewKinForm');
Route::post('/addkin','UserController@SaveKindetail');
Route::get('/kincontact/{id}','UserController@KinContact');
Route::post('/kincontact/{id}','UserController@SaveKinContact');

Route::get('/editkin/{id}','UserController@EditKinDetails');
Route::post('/editkin/{id}','UserController@UpdateKinDetails');
Route::get('/editkincontact/{id}','UserController@EditKinContact');
Route::post('/editkincontact/{id}','UserController@saveEditKitContact');