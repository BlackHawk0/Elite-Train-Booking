<?php

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

Route::get('/', 'HomeController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/search/schedules', 'BookTrainController@findSchedule')->name('search.schedules');
Route::get('/search/results', 'BookTrainController@searchResults')->name('search.results');
Route::post('/book-train', 'BookTrainController@bookTrain')->name('book.train');

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', 'HomeController@adminDashboard')->name('admin.dashboard');
    Route::resource('trains', 'TrainController');
    Route::resource('stations', 'StationController');
    Route::get('/train/{id}/schedules', 'ScheduleController@trainSchedule')->name('train.schedule');
    Route::resource('schedules', 'ScheduleController');
    Route::get('/bookings', 'BookTrainController@bookings')->name('admin.bookings');
});

// mpesa rent payment routes
Route::post('/booking/payment/initiate', 'MpesaBookingPaymentController@initiatePayment')->name('initiate.payment');
Route::get('/booking/payment/status/{status}', 'MpesaBookingPaymentController@paymentStatus')->name('mpesa.payment.status');
Route::get('/booking/payment/stk/query', 'MpesaBookingPaymentController@stkPushStatus')->name('mpesa.stk.status');
Route::get('/booking/payment/order/complete', 'MpesaBookingPaymentController@orderComplete')->name('mpesa.order.complete');
Route::get('/booking/payment/order/fail', 'MpesaBookingPaymentController@orderFail')->name('mpesa.order.fail');
