<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/error', function () {
    return view('error');
});

//
// ROUTES FOR LOGIN/SIGNUP //
//

Route::get('/signup', function () {
    return view('signup');
});

Route::get('login', function () {
    return view('/pages/login');
})->name('login');

Route::get('register', function () {
    return view('/pages/register');
})->name('register');
Auth::routes();

Route::get('auth/{driver}', ['as' => 'socialAuth', 'uses' => 'Auth\SocialController@redirectToProvider']);
Route::get('auth/{driver}/callback', ['as' => 'socialAuthCallback', 'uses' => 'Auth\SocialController@handleProviderCallback']);

Route::get('/feed', function () {
    return view('feed');
})->name('feed');

//
// ROUTES FOR USER/PROFILE //
//
Route::get('insert', 'UserController@update');
Route::post('profile/update', 'UserController@update');
Route::post('createAlbum', 'AlbumController@createAlbum');
Route::post('deleteAlbum', 'AlbumController@deleteAlbum');
Route::post('updateAlbum', 'AlbumController@updateAlbum');

Route::get('/editprofile', function () {
    return view('editprofile');
})->name('editprofile');

// Update avatar picture
Route::post('editprofile', 'UserController@update_Avatar');
Route::post('deleteavatar', 'UserController@delete_Avatar');

Route::get('/profile/{userId}', [
        'uses'  => 'UserController@viewProfile'
]);

Route::get('/profile', [
        'uses'  => 'UserController@currentProfile'
])->name('profile');

Route::get('/deleteuser', [
        'uses'  => 'UserController@deleteUser'
]);

Route::get('/password', function () {
    return view('/password');
})->name('password');

Route::get('/album/{album_Id}', [
        'uses'  => 'AlbumController@viewAlbum'
]);

//
// IMAGE UPLOAD //
//
Route::post('uploadImage', 'UploadController@uploadImage');

//
// ROUTES FOR EVENT //
//
Route::post('joinEvent', 'EventController@joinEvent');
Route::post('leaveEvent', 'EventController@leaveEvent');
Route::post('updateEvent', 'EventController@updateEvent');
Route::post('updateHead', 'EventController@update_Header');
Route::post('deletePhoto', 'EventController@deletePhoto');
Route::post('deleteEvent', 'EventController@deleteEvent');
Route::post('/inviteregistration/join', 'EventController@inviteToEvent');
Route::post('inviteByEmail', 'EventController@inviteByEmail');
Route::post('setRole', 'EventController@setRole');

Route::get('editevent', function() {
    return view('editevent');
})->name('editevent');


Route::get('/events/edit/{eventId}',[
    'uses'  => 'EventController@editEvent'
])->name('events/edit');


Route::get('/myevents', function() {
    return view('myevents');
})->name('myevents');


Route::get('/events/{eventId}', [
        'uses'  => 'EventController@viewEvents'
]);

Route::post('/invite/save',  'EventController@saveInvitation');

Route::get('/events/{eventId}/invitation/edit', [
        'uses'  => 'EventController@EditInvitation'
]);
Route::get('/events/{eventId}/invitation', [
        'uses'  => 'EventController@viewInvitation'
]);
Route::post('/events/invitation/delete', 'EventController@deleteInvitation');

Route::get('insert','EventController@insertform');
Route::post('create', 'EventController@createEvent');

Route::get('/events', function () {
    return view('eventlist');
})->name('events');

// Routes for search bars
Route::post('/toSearchableArray', 'SearchController@toSearchableArray');
Route::get('/search', 'SearchController@search');


//
// ROUTES FOR COMMENT
//
Route::post('/newComment', 'CommentController@newComment');


// REACT
Route::post('plusOne', 'ReactController@plusOne');

//Route::get('user/{user}', ['as' => 'users.edit', 'uses' => 'UserController@edit']);
//Route::patch('users/{user}/update', ['as' => 'users.update', 'uses' => 'UserController@update']);

//
// ROUTES FOR COMMENTS //
//
Route::post('newComment', 'CommentController@newComment');
Route::post('deleteComment', 'CommentController@deleteComment');
//
// ROUTES FOR INVITE //
//

Route::get('invite', 'InviteController@invite')->name('invite');
Route::post('invite', 'InviteController@process')->name('process');
// {token} is a required parameter that will be exposed to us in the controller method
Route::get('accept/{token}', 'InviteController@accept')->name('accept');

Route::get('/inviteregistration/{token}', function () {
    return view('/inviteregistration');
})->name('inviteregistration');



// PUSHER

Route::get('test', function () {
    event(new App\Events\StatusLiked('Daniel'));
    return "Event has been sent!";
});

Route::post('/notification/delete', 'NotificationController@deleteNotification');

