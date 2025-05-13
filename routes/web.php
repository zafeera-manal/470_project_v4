<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendshipController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/logout', [Auth\LoginController::class, 'logout'])->name('logout');


Route::get('travelling/about/{id}', [App\Http\Controllers\Travelling\TravellingController::class, 'about'])->name('travelling.about');



// View friends, pending requests, and users to add as friends
Route::get('/friends', [FriendshipController::class, 'viewFriends'])->name('friends.index');

// Route for sending friend requests
Route::post('/friends/{friend_id}/send-request', [FriendshipController::class, 'sendRequest'])->name('friends.sendRequest');

// Route for viewing pending friend requests
Route::get('/friends/pending', [FriendshipController::class, 'viewPendingRequests'])->name('friends.pending');

// Route for accepting a friend request
Route::post('/friends/{friendship_id}/accept', [FriendshipController::class, 'acceptRequest'])->name('friends.accept');

// Route for rejecting a friend request
Route::post('/friends/{friendship_id}/reject', [FriendshipController::class, 'rejectRequest'])->name('friends.reject');

// Route for undoing a friend request
Route::post('/friends/{friend_id}/undo', [FriendshipController::class, 'undoRequest'])->name('friends.undo');
// Route for searching friends
Route::get('/friends/search', [FriendshipController::class, 'searchFriends'])->name('friends.search');


use App\Http\Controllers\MessageController;

Route::post('/messages/{receiver_id}', [MessageController::class, 'sendMessage'])->name('messages.send');
Route::get('/messages/{receiver_id}', [MessageController::class, 'fetchMessages'])->name('messages.fetch');


use App\Http\Controllers\ItineraryController;

Route::middleware('auth')->group(function () {
    Route::get('/itineraries', [ItineraryController::class, 'index'])->name('itineraries.index');
    Route::get('/itineraries/create', [ItineraryController::class, 'create'])->name('itineraries.create');
    Route::post('/itineraries', [ItineraryController::class, 'store'])->name('itineraries.store');
    Route::get('/itineraries/{id}/edit', [ItineraryController::class, 'edit'])->name('itineraries.edit');
    Route::put('/itineraries/{id}', [ItineraryController::class, 'update'])->name('itineraries.update');
    Route::delete('/itineraries/{id}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');
    Route::get('/itineraries/{id}', [ItineraryController::class, 'show'])->name('itineraries.show');
});



// Route to share itinerary via email
Route::post('/itineraries/{itinerary_id}/share-email/{friend_id}', [ItineraryController::class, 'shareWithEmail'])->name('itineraries.shareEmail');

Route::get('/test-email', [ItineraryController::class, 'testEmail']);


Route::post('/itineraries/{itinerary_id}/share', [ItineraryController::class, 'shareWithFriend'])->name('itineraries.share');
use App\Http\Controllers\GroupTripController;

Route::prefix('group-trips')->group(function () {
    Route::get('index', [GroupTripController::class, 'index'])->name('group_trips.index'); // Define the route for the index
    Route::get('create', [GroupTripController::class, 'create'])->name('group_trips.create');
    Route::post('store', [GroupTripController::class, 'store'])->name('group_trips.store');
    Route::get('{id}', [GroupTripController::class, 'show'])->name('group_trips.show');  // Add this route
    Route::get('{id}/send-invitations', [GroupTripController::class, 'sendInvitations'])->name('group_trips.sendInvitations');
    Route::get('invitations', [GroupTripController::class, 'viewInvitations'])->name('group_trips.viewInvitations');
    Route::post('invitations/{id}/accept', [GroupTripController::class, 'acceptInvitation'])->name('group_trips.acceptInvitation');
    Route::post('invitations/{id}/reject', [GroupTripController::class, 'rejectInvitation'])->name('group_trips.rejectInvitation');
});

use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;

//admin routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Send and view notification route
    Route::get('/send-notification', [NotificationController::class, 'viewNotifications'])->name('admin.notifications.index');
    Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('admin.sendNotification');
    
    // Other admin routes
    Route::get('/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/itineraries', [AdminController::class, 'viewItineraries'])->name('admin.itineraries.index');
    
    //itinerary details (admin view)
    Route::get('/itineraries/{id}', [AdminController::class, 'showItinerary'])->name('admin.itineraries.show');
});


// Route for Admin to view all group trips
Route::middleware('auth')->get('/admin/group-trips', [AdminController::class, 'viewGroupTrips'])->name('admin.group_trips.index');

//Route to view notifications on admin side
Route::middleware('auth')->get('/admin/notifications', [AdminController::class, 'viewNotifications'])->name('admin.notifications.index');

//Route to view notifications on user side
Route::middleware('auth')->get('/notifications', [NotificationController::class, 'userNotifications'])->name('user.notifications');



