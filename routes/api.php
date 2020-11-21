<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['namespace' => 'API'], function () {
   Route::post('mobile_no_verified_and_otp_send','WMSApiController@mobile_no_verified_and_otp_send');
   Route::post('otp_verified_and_login', 'WMSApiController@otp_verified_and_login');

   Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('get_all_data_employee', 'WMSApiController@get_all_data_employee');
        Route::post('uplaod_user_photo', 'WMSApiController@upload_image');
        Route::post('uplaod_worker_supervisor_photo', 'WMSApiController@uplaod_worker_supervisor_photo');
        Route::post('employee_attendance_entry', 'WMSApiController@employee_attendance_entry');
        Route::post('employee_attendance_update', 'WMSApiController@employee_attendance_update');
        Route::post('get_all_data_employee_array', 'WMSApiController@get_all_data_employee_array');
    });


});


