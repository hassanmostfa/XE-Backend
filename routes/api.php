<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CountriesController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\ServiceFeaturesController;
use App\Http\Controllers\API\BookingsController;
use App\Http\Controllers\API\TransactionsController;
use App\Http\Controllers\API\AuditLogController;
use App\Http\Controllers\API\MessagesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Login user
Route::controller(UserController::class)->group(function(){
    Route::post('/user/login', 'login');
});


Route::middleware('auth:sanctum')->group(function () {

    // Countries APIS
    Route::controller(CountriesController::class)->group(function(){
        // Get all countries
        Route::get('/user/countries', 'gatAllCountries');
        // Add New Country
        Route::post('/user/add-country', 'addCountry');
        // Show CountryDetails
        Route::get('/user/show-country/{id}', 'showCountryDetails');
        // Update Country
        Route::post('/user/update-country/{id}', 'updateCountry');
        // Delete Country
        Route::delete('/user/delete-country/{id}', 'deleteCountry');
    });

    // Services APIS
    Route::controller(ServicesController::class)->group(function(){
        // get all services
        Route::get('/user/services', 'index');
        // Add New Service
        Route::post('/user/add-service', 'store');
        // Show Service Details
        Route::get('/user/show-service/{id}', 'show');
        // Update Service
        Route::post('/user/update-service/{id}', 'update');
        // Delete Service
        Route::delete('/user/delete-service/{id}', 'destroy');
    });

    // Service Features APIS
    Route::controller(ServiceFeaturesController::class)->group(function(){
        // get all service features
        Route::get('/user/service-features', 'index');
        // Get All Features of a service
        Route::get('/user/service-features/{id}', 'serviceFeatures'); 
        // Add New Service Feature
        Route::post('/user/add-service-feature', 'store');
        // Show Service Feature Details
        Route::get('/user/show-service-feature/{id}', 'show');
        // Update Service Feature
        Route::put('/user/update-service-feature/{id}', 'update');
        // Delete Service Feature
        Route::delete('/user/delete-service-feature/{id}', 'destroy');
    });

    // Bookings APIS
    Route::controller(BookingsController::class)->group(function(){
        // get all bookings
        Route::get('/user/bookings', 'index');
        // Add New Booking
        Route::post('/user/add-booking', 'store');
        // Show Booking Details
        Route::get('/user/show-booking/{id}', 'show');
        // Update Booking
        Route::put('/user/update-booking/{id}', 'update');
        // Delete Booking
        Route::delete('/user/delete-booking/{id}', 'destroy');
    });

    // Transactions APIS
    Route::controller(TransactionsController::class)->group(function(){
        // get all transactions
        Route::get('/user/transactions', 'index');
        // Add New Transaction
        Route::post('/user/add-transaction', 'store');
        // Show Transaction Details
        Route::get('/user/show-transaction/{id}', 'show');
        // Update Transaction
        Route::put('/user/update-transaction/{id}', 'update');
        // Delete Transaction
        Route::delete('/user/delete-transaction/{id}', 'destroy');
    });

    // Audit Logs APIS
    Route::controller(AuditLogController::class)->group(function(){
        // get all audit logs
        Route::get('/user/audit-logs', 'index');
        // Add New Audit Log
        Route::post('/user/add-audit-log', 'store');
        // Show Audit Log Details
        Route::get('/user/show-audit-log/{id}', 'show');
        // Update Audit Log
        Route::put('/user/update-audit-log/{id}', 'update');
        // Delete Audit Log
        Route::delete('/user/delete-audit-log/{id}', 'destroy');
    });

    // Messages APIS
    Route::controller(MessagesController::class)->group(function(){
        // get all messages
        Route::get('/user/messages', 'index');
        // Add New Message
        Route::post('/user/add-message', 'store');
        // Show Message Details
        Route::get('/user/show-message/{id}', 'show');
        // Update Message
        Route::put('/user/update-message/{id}', 'update');
        // Delete Message
        Route::delete('/user/delete-message/{id}', 'destroy');
    });

});
