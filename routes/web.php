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
  if(Auth::check()){
    return redirect('/home');
  }else{ 
    return redirect('login');
  }
});

Auth::routes();
 
Route::get('/home','Api\PagesController@summary')->middleware('auth');
 
Route::get('/accountsProfile','Api\PagesController@testforProfile')->middleware('auth');


Route::group(['middleware' => ['auth', 'admin']], function()
{
  //device
      Route::resource('device','Admin\DeviceController')->middleware('auth');
  //roles or types
      Route::resource('roles','Admin\RolesController')->middleware('auth');
      Route::get('showRoles','Admin\RolesController@showRolePage' )->middleware('auth');
      Route::post('role/Addroles','Admin\RolesController@addRoles')->middleware('auth');
      Route::resource('mainpanel', 'Api\MainPanelController')->middleware('auth');
      Route::post('/addDevice','Admin\DeviceController@addDevice')->name('admin.deviceRegister')->middleware('auth');;
  //Accounts
      Route::resource('accounts','Admin\userController')->middleware('auth'); 
      Route::post('/accounts','Admin\userController@store')->middleware('auth'); 
  //Floor
      Route::resource('floors', 'Admin\floorController')->middleware('auth');
});

  //Rooms 
  Route::post('mainpanel/Add/{id}', 'Api\MainPanelController@addDataRead')->middleware('auth')->name('add.DataReading');
  Route::get('rooms/Show/{id}', 'Api\RoomController@showRoom')->middleware('auth')->name('add.roomShow');
//Data Reading
  Route::get('/dataReading','Api\DataReadingController@viewListOfDataReading')->middleware('auth');
  Route::get('rooms','Api\RoomController@index')->middleware('auth');
//search  
  Route::resource('rooms','Api\RoomController')->middleware('auth');
  Route::post('search', 'Api\RoomController@searchRoom');
//Summary
  Route::post('showSummary', 'Api\PagesController@showDashboard')->name('showDashboard')->middleware('auth');
//summary
  Route::get('/summary','Api\PagesController@summary')->middleware('auth');

  Route::post('summary/dataPost','Api\PagesController@getDataForDashboard_Post')->middleware('auth');
  Route::get('summary/data','Api\PagesController@getDataForDashboard')->middleware('auth');

  // Route::get('summary/dataguage','Api\PagesController@getGuageForDashboard')->middleware('auth');
  // Route::post('summary/dataguagePost','Api\PagesController@getGuageForDashboard_Post')->middleware('auth');

  Route::get('rooms/ShowUI/{id}','Api\RoomController@showUI')->middleware('auth')->name('UIShow');
  Route::get('rooms/ShowEditSchedule/{id}','calendarController@showRoomSchedule')->middleware('auth');
  Route::get('rooms/ShowDeleteSchedule/{id}','calendarController@deleteRoomSchedule')->middleware('auth');
  //summary   
  //calendar
  Route::get('/events', 'calendarController@index')->name('events.index')->middleware('auth');
  Route::post('/events/add', 'calendarController@add')->name('events.add')->middleware('auth'); 

  //setCalendar
  // Route::get('setTime/calendar','calendarController@viewSetupSchedule')->middleware('auth');

  //setup Time Calendar
  Route::get('setTime/calendar','calendarController@getSetupSchedule')->middleware('auth')->name('rooms.getSetupSchedule');
  Route::get('roomInstance','calendarController@getRoomInstance')->middleware('auth')->name('rooms.getInstance');
  Route::post('setTime/calendar','calendarController@saveSchedule')->middleware('auth')->name('schedule.saveInstance');

  //11/23/2019 
  //remove time calendar
  Route::resource('setTime','calendarController')->middleware('auth');