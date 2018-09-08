<?php

Route::get('/inbox','UserController@mailbox');
Route::get('/sendmessage','UserController@sendMsg');
Route::post('/sendmessage','UserController@sendMail');
Route::get('/sentmessage','UserController@sentMessage');
Route::get('/archivemessage','UserController@archiveMessage');
Route::get('/replymessage/{id}','UserController@viewmessage');
Route::post('/replymessage/{id}','UserController@sendReply');
Route::get('/archive/{id}','UserController@archive');
Route::get('deletemessage/{id}','UserController@deleteMessage');
Route::get('sendmessage/{id}','UserController@emailSuggestions');
