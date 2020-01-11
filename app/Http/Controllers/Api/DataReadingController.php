<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Device; 
use App\Model\Data_Reading; 
use App\Model\Room; 
use Validator;
use Auth; 
use Redirect,Response;
class DataReadingController extends Controller
{
    //
    // public function loginCheck()
    // {
    //     $userID = auth()->user()->id;
    //     if($userID > 0)
    //     {
    //         return redirect()->route('/');
    //     }

    // }

    public function viewListOfDataReading()
    {
        if($this->checkForEmptyID() == true)
        { 
	        return Redirect::back()->with('errorMessage','No Readings Found!'); 
        }
        $getDataReading = DB::table('data_reading')
        ->join('device', 'data_reading.device_ID', '=', 'device.device_ID')
        ->join('rooms', 'data_reading.room_ID', '=', 'rooms.id')
        ->join('users', 'data_reading.user_ID', '=', 'users.id')
        ->select('data_reading.*','device.name','rooms.roomName','users.Name')
        ->orderBy('data_reading.created_at','desc')
        ->paginate(20);
        echo $getDataReading;
        $rooms =Room::all()->where('status','=',true);
        return view('pages.dataReading.list', ['device' => $getDataReading,'rooms'=>$rooms  ]);
    }

    public function checkForEmptyID(){
 
        if(!Data_Reading::all()->where('id','>',0)->count())
        {
            return true;
        }
        else{
            return false;
        }

    }
 
}
