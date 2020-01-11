<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Accounts;
use App\Model\Room;
use App\Model\Logs; 
use App\Model\Device; 
use App\Model\Data_Reading; 
use App\Model\calendarEvents;
use App\Model\timeschedulesetup;
use Calendar;
use DB; 
use Validator;
use Auth;
use Illuminate\Support\Carbon;
use Log;
class MainPanelController extends Controller
{
 
    public function index()
    {
        //
    }
 
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        // 
    }
 
    public function show($id)
    {
        //
    }
 
    public function edit($id)
    {
        // 
    }
 
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'roomName'=>'required',
        //     'status'=> 'required',
        //     'routeName' => 'required',
        //     'min_power' => 'required',
        //     'max_power' => 'required',
        //   ]); 
        //  $share = Room::find($id); 
        //   $share->roomName = $request->get('roomName');
        //   $share->status = $request->get('status');
        //   $share->routeName = $request->get('routeName');   
        //   $share->min_power = $request->get('min_power');   
        //   $share->max_power = $request->get('max_power');   
        //   $share->created_at = $request->get('roomStart');
        //   $share->updated_at = $request->get('roomEnd');
        //   $share->save();
            // $data= $request->all();
            // $lastid = Data_Reading::create($data)->id;
            // if(count($request->roomName as )> 0)
            // {
            //     foreach($request)
            // }
    // return back()->with('message', 'Succesfully Updated');
    } 

    public function addDataRead(Request $request, $id)  //function for button STOP and ON
    {
        $this->validate($request,[
            'roomName'=>'required',
            'status'=> 'required',
            'routeName' => 'required',
            'power' => 'required',
            'voltage' => 'required', 
          ]); 
          $DataStatus = $request->get('status') != 1 ? false:true;
          $share = Room::where('id','=',$id)->first();  
          $share->roomName = $request->get('roomName');
          $share->status = $DataStatus;
          $share->routeName = $request->get('routeName');     
          $share->power = $request->get('power');   
          $share->voltage = $request->get('voltage');    
          $share->save(); 
          Data_Reading::create([
            'device_ID'=> $share->device_ID,
            'room_ID' => $id, 
            'power' => $request->get('power'),
            'status' => $DataStatus,
            'voltage' => $request->get('voltage'),
            'user_ID' => auth()->user()->id
          ]);
        $item= Room::where('id','=',$id)
        ->join('device','device.device_ID','=','rooms.device_ID')
        ->first();
 
        $timeSchedule = new timeschedulesetup;
        $timeSchedule->time_in =  Carbon::parse()->startOfDay()->toDateTimeString(); 
        $timeSchedule->time_out =  Carbon::parse()->endOfDay()->toDateTimeString(); 
        $timeSchedule->set_day =  '0,0,0,0,1,0,0';
        $timeSchedule->room_ID =  $id;
        $timeSchedule->device_ID =  $item->device_ID; 
        $timeSchedule->save();

        //calendar 
        // if($validator->fails())
        // {
        //     \Session::flash('warning','Please enter the valid details');
        //     return redirect()->route('rooms')->withInput()->withErrors($validator);
        // } 

        Log::info('Someone Control on Switch!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'Room id use' => $id,
            'Room status' => $DataStatus
            ]);
            
        \Session::flash('success','Event added Successfully');  
        $setupSched = timeschedulesetup::where('room_ID','=',$id)->get();   
        $even_list = [];
        foreach($setupSched as $key => $event){
            $even_list[] = Calendar::event(
                // $event->title, 
                // false,
                // new \DateTime($event->start_date),
                // new \DateTime($event->end_date)
                'Class Starts at>>'.$event->time_in,
                false,
                new \DateTime($event->start_date),
                new \DateTime($event->end_date),
                // date('y-m-d H:i:s', strtotime($event->time_in)), 
                // date('y-m-d H:i:s', strtotime($event->time_out)), 
                $event->sched_ID
            );
        }
        $calendar_details = Calendar::addEvents($even_list); 
        return view('pages.rooms.partialLaboratory.view', compact('calendar_details'))->with('item',$item); 
        //   $rooms = Room::all()->where('status','=',true);
        //   $data = DB::table('rooms')
        //   ->join('device', 'rooms.device_ID', '=', 'device.device_ID')
        //   ->select('rooms.*','device.name')
        //   ->where('isDeleted','=',0)->paginate(5);
 
        //   return redirect()->route('rooms.index')->with('message', 'Succesfully Created');
        // return view('pages.rooms.view', [ 'roomsData' => $data, 'rooms' => $rooms]);
    }
 
    public function destroy($id)
    {
        //
    }
}
