<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\pollingController;
use App\Http\Controllers\pollingItemController;
use App\Http\Livewire\AddProfileItems;
use Illuminate\Support\Facades\Route;

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


// Web

// Polling Uni Page
Route::get('/polling/{id}', [pollingController::class, 'show_unit']);
// View Unit Bar
Route::get('/pollingUnitBar/{id}', [pollingController::class, 'show_bar']);


// Guest User

Route::middleware('guest:web')->group(function () {
    // Home Page
    Route::get('/', [pollingController::class, 'index']);

    // Google Login
    Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('google.callback');

    // Facebook Login
    Route::get('auth/facebook', [LoginController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('auth/facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('facebook.callback');

    // Polling Uni Page
    Route::get('/polling/{id}', [pollingController::class, 'show_unit']);
    // View Unit Bar
    Route::get('/pollingUnitBar/{id}', [pollingController::class, 'show_bar']);
    // View Profile
    Route::get('/showProfile/{id}', [pollingController::class, 'show_profile']);
});


// Route User

// Middleware Auth User
Route::middleware(['auth:web',])->group(function () {
    // Home Page
    Route::get('/home', [pollingController::class, 'index'])->name('home');
    // PollSurvey Page
    Route::post('/pollSurvey', [pollingController::class, 'set_polling_survey']);
    // Polling Uni Page
    Route::get('/polling/{id}', [pollingController::class, 'show_unit']);
    // View Unit Bar
    Route::get('/pollingUnitBar/{id}', [pollingController::class, 'show_bar']);
    // Action Logout
    Route::get('/auth/google/logout', [LoginController::class, 'logout'])->name('logout');
    // View Profile
    Route::get('/profile/{id}', [pollingController::class, 'show_profile_item']);
});


// Route Admin

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function () {
        // Admin Login Page
        Route::get('/login', function () {
            return view('adminLogin', ["title" => "Login"]);
        })->name('login');
        Route::post('/check', [adminController::class, 'check'])->name('check');
    });
    // Middleware Auth Admin
    Route::middleware(['auth:admin', 'is_admin', 'PreventBackHistory'])->group(function () {

        // Admin Page
        Route::get('/', [adminController::class, 'index'])->name('home');

        // Route Page

        // Add Polling Page
        Route::get('/addPolling', [pollingController::class, 'create']);

        // Edit Polling Page
        Route::get('/editPolling/{id}', [pollingController::class, 'edit']);
        Route::post('/editPolling/{id}', [pollingController::class, 'update']);

        // Close Polling Page
        Route::post('/closePolling', [pollingController::class, 'close_polling'])->name('close');

        // Delete Polling Page
        Route::post('/deletePolling', [pollingController::class, 'delete'])->name('delete');

        // Add Unit Page
        Route::get('/addPollItems', function () {
            return view('addPollItems', ["title" => "Add Poll Items"]);
        });
        Route::post('/addUnit', [pollingController::class, 'create_unit'])->name('add-unit');

        // View Unit Bar
        Route::get('/pollingUnitBar/{id}', [pollingController::class, 'show_bar']);


        // polling item area
        Route::get('/add-polling-item/{vote_unit}', [pollingItemController::class, 'create']);
        Route::post('/add-item', [pollingItemController::class, 'createItem'])->name('add-item');

        Route::get('/edit-polling-item/{voteItem}', [pollingItemController::class, 'edit']);
        Route::post('/edit-polling-item/{id}', [pollingItemController::class, 'update']);

        Route::post('/delete-polling-item', [pollingItemController::class, 'delete'])->name('delete-poll-item');

        //voters
        Route::get('/voters/{voteUnit}', [pollingController::class, 'voters']);
        Route::get('/export-voters/{voteUnit}', [ExportController::class, 'exportVoters']);

        // Result Polling Page
        Route::get('/result/{vote_unit}', [pollingController::class, 'result']);

        // More Profile Page
        Route::get('/moreProfile/{slug}', AddProfileItems::class);

        // Show Profile Page
        Route::get('/showProfile/{id}', [pollingController::class, 'show_profile']);

        // edit & delete more Profile
        Route::post('/update-more-profile', [pollingController::class, 'updateMoreProfileItem']);
        Route::get('/delete-more-profile', [pollingController::class, 'deleteMoreProfileItem']);

        //generate slug
        Route::get('/polling/createSlug', [pollingController::class, 'createSlug']);
        Route::get('/polling-item/createSlug', [pollingItemController::class, 'createSlug']);

        // Logout Page
        Route::get('/logout', [adminController::class, 'logout'])->name('logout');
    });
});

Route::get('/pollingUnitBar', function () {
    return view('pollingUnitBar', [
        "title" => "Polling Unit Bar"
    ]);
});

// Route::get('/getPollingUnit',[pollingController::class,'get_polling_json']);
Route::get('/viewPollUnit/{id}', [pollingController::class, 'show_unit']);

Route::get('/profile', function () {
    return view('profile', [
        "title" => "Profile"
    ]);
});

Route::get('/pollSurvey/{id}', [pollingController::class, 'polling_survey']);

Route::get('/viewProfileItems', function () {
    return view('viewProfileItems', [
        "title" => "View Profile Items"
    ]);
});
