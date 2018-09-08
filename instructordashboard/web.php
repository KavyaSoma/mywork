Route::get('/participant/{participant}/{venue_id}','InstructorController@acceptParticipant');
Route::get('/deleteparticipant/{participant}/{venue_id}','InstructorController@deleteParticipant');