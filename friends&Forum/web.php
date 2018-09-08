<?php

Route::get('/socialnetwork', 'SocialController@index');
Route::post('/socialnetwork','SocialController@addFriend');
Route::get('/addfriend/{id}','SocialController@newFriend');
Route::get('/friendlist','SocialController@friendList');
Route::post('/friendlist','SocialController@searchfriend');
Route::get('/myfriendlist','SocialController@myFriend');
//forum
Route::get('/forumanswers/{id}','SocialController@answers');
Route::post('forumanswers/{id}','SocialController@forumAnswer');
Route::get('/questions','SocialController@forumquestions');
Route::post('/questions','SocialController@questions');