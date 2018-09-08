
Route::get('/multiple-event/{id}','EventController@multipleevent');
Route::post('/multiple-event/{id}','EventController@savemultipleevent');
Route::get('/recurring-event/{id}','EventController@recurringevent');
Route::post('/week-event/{id}','EventController@saveweekevent');
Route::post('/month-event/{id}','EventController@savemonthevent');
Route::post('/year-event/{id}','EventController@saveyearevent');

Route::get('/checkshortname/event/{shortname}','EventController@checkshortname');


Route::get('/edit-multipleevent/{event_id}','EventController@editmulitpleevents');
Route::post('/edit-multipleevent/{event_id}','EventController@saveEditMultiple');
Route::get('/edit-recuringevent/{event_id}','EventController@editrecuringevent');
Route::post('/edit-weekevent/{event_id}','EventController@saveeditweekevent');
Route::post('/edit-monthevent/{event_id}','EventController@saveeditmonthevent');
Route::post('/edit-yearevent/{event_id}','EventController@saveedityearevent');

Route::get('/delete-subevent/{event_id}/{subevent_id}','EventController@deletesubevent');
Route::get('/delete-eventclub/{event_id}/{id}','EventController@deleteeventclub');
Route::get('/delete-eventcontact/{event_id}/{id}','EventController@deleteeventcontact');
Route::get('/delete-eventvenue/{event_id}/{id}','EventController@deleteeventvenue');
Route::get('/delete-schedule/{event_id}/{id}','EventController@deleteschedule');