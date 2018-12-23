<?php

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

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});



Route::group(['middleware' => ['auth:api','ip.check']], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('user', 'Auth\UserController@getUser');
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::get('users/dropdown', 'Auth\UserController@getAllUserDropdown');
    Route::get('users', 'Auth\UserController@getAllUsers');
    Route::post('user-create', 'Auth\UserController@createNewUser');
    Route::patch('user/{id}/update', 'Auth\UserController@updateUser');
    Route::delete('user/{id}', 'Auth\UserController@deleteUser');

    Route::get('roles', 'Role\RoleController@getALlRoles');
    Route::get('roles-dropdown', 'Role\RoleController@getRolesDropdown');
    Route::patch('role-update', 'Role\RoleController@userRoleUpdate');


    Route::post('base-salary', 'BaseSalaryController@createNewSalary');
    Route::patch('base-salary/{salary_id}/update', 'BaseSalaryController@updateBaseSalary');
    Route::delete('base-salary/{salary_id}', 'BaseSalaryController@deleteSalary');


    Route::get('holidays-by-month', 'OfficeHolidayController@getAllHolidaysByMonth');
    Route::post('holiday-create', 'OfficeHolidayController@createHoliday');
    Route::patch('holiday/{holiday_id}/update', 'OfficeHolidayController@updateHoliday');
    Route::delete('holiday/{holiday_id}', 'OfficeHolidayController@deleteHoliday');


    Route::get('position/dropdown', 'PositionController@getPositionDropdown');
    Route::get('positions', 'PositionController@getAllPositions');
    Route::post('position', 'PositionController@createNewPosition');
    Route::patch('positions/{id}/update', 'PositionController@updatePosition');
    Route::delete('positions/{id}', 'PositionController@deletePosition');


    //dashboard
    Route::get('attendance-today-for-user', 'AttendanceController@getTodayAttendanceForSpecificUser');
    Route::get('attendance-current-month-statistics-for-user', 'AttendanceController@getUserCurrentMonthStatistics');
    Route::post('attendance-create', 'AttendanceController@createAttendance');
    Route::patch('attendance/{attendance_id}/update', 'AttendanceController@updateAttendance');
    Route::delete('attendance/{attendance_id}', 'AttendanceController@deleteAttendance');

    //calendar
    Route::get('attendances-by-month/calendar', 'AttendanceController@getAllAttendancesByMonth');
    Route::get('attendances-by-date/calendar', 'AttendanceController@getAllAttendancesByDate');
    Route::get('attendance/{attendance_id}/calendar', 'AttendanceController@getAttendanceDetails');

    Route::get('attendance/user/statistics', 'AttendanceController@getUserAttendanceStatisticsForToday');
    Route::get('attendance/user/statistics/percentage', 'AttendanceController@getTodayUserAttendancePercentage');

    //unused
    Route::get('attendances/calendar/{user_id}', 'AttendanceController@getAllAttendancesByUser');
    Route::get('attendances-by-user/calendar/{user_id}', 'AttendanceController@getUserAttendanceByMonth');
    Route::get('attendances/calendar/{user_id}', 'AttendanceController@getAllAttendancesByUser');

});
