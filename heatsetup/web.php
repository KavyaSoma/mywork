<?php

Route::get('/heatsetup/{eventid}/{subeventid}','VenueController@heatSetup');
Route::post('/heatsetup/{eventid}/{subeventid}','VenueController@saveheatSetup');
Route::get('/editheat/{event_id}/{subevent_id}/{heat_id}','VenueController@editheat');
Route::post('/editheat/{event_id}/{subevent_id}/{heat_id}','VenueController@saveeditheat');
Route::get('/deleteheat/{event_id}/{heat_id}','VenueController@deleteHeat');
Route::get('/oldscheduleheat/{event_id}/{subevent_id}','VenueController@oldHeatSchedule');
Route::get('/manageparticipants/{event_id}/{subevent_id}/{heat_id}','VenueController@manageParticpants');
Route::post('/manageparticipants/{event_id}/{subevent_id}/{heat_id}','VenueController@saveParticipants');

Route::get('/resultentry/{event_id}/{subevent_id}/{heat_id}/{level_id}','UserController@resultEntry');
Route::post('/resultentry/{event_id}/{subevent_id}/{heat_id}/{level_id}','UserController@saveresultEntry');

Route::get('/semiheatsetup/{event_id}/{subevent_id}','VenueController@heatsemifinal');
Route::post('/semiheatsetup/{event_id}/{subevent_id}','VenueController@savesemifinal');
Route::get('/oldsemifinal/{event_id}/{subevent_id}','VenueController@oldSemiSchedule');
Route::get('/finalheatsetup/{event_id}/{subevent_id}','VenueController@heatfinal');
Route::post('/finalheatsetup/{event_id}/{subevent_id}','VenueController@savefinal');
Route::get('/oldfinalheat/{event_id}/{subevent_id}','VenueController@oldFinalSchedule');

Route::get('manageparticipants/{event_id}/{subevent_id}/{heat_id}/{level_id}','VenueController@semifinalParticipants');
Route::post('manageparticipants/{event_id}/{subevent_id}/{heat_id}/{level_id}','VenueController@savesemifinalParticipants');
Route::get('/heatresults/{event_id}/{subevent_id}/{heat_id}/{level_id}','UserController@heatresult');