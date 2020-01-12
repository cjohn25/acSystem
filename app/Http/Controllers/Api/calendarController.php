<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\calendarEvents;
use App\Model\timeschedulesetup;
use App\Model\Device;
use Calendar;
use Illuminate\Support\Carbon;
use App\Model\Room; 
use DB;
use Validator;
use Auth; 
use Log;  
use Redirect,Response; 
use DataTables;
class calendarController extends Controller
{ 
    // public function index()
    // {
    //     $events = calendarEvents::where('id','>',0)->get();
    //     $event1 = [];
    //     foreach($events as $row){
    //         $enddate = $row->end_date." 24:00:00";
    //         $event1[] = \Calendar::event(
    //             $row->title,
    //             true,
    //             new \DateTime($row->start_date),
    //             new \DateTime($row->end_date),
    //             $row->id,
    //             [
    //                 'color' => $row->color,
    //             ]
    //             );
    //     }
    //     $calendar = \Calendar::addEvents($events);
    //     return view('pages.rooms.partialLaboratory.calendar',compact('events','calendar')); 
    // }
    public function index()
    {
        $events = timeschedulesetup::get();
        $even_list = [];
        foreach($events as $key => $event){
            $even_list[] = Calendar::event(
                'Class Starts at>>'.$event->sched_ID,
                false,
                date('y-m-d H:i:s', strtotime($event->time_in)), 
                date('y-m-d H:i:s', strtotime($event->time_out)), 
                $event->sched_ID
            );
        }
        // dd($events);
        // dd($even_list);

        $calendar_details = Calendar::addEvents($even_list); 
        return view('pages.rooms.partialLaboratory.calendar1', compact('calendar_details'));
    }
    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required', 
            'color' => 'required'
            ]);  
        if($validator->fails())
        {
            \Session::flash('warning','Please enter the valid details');
            return redirect()->route('rooms')->withInput()->withErrors($validator);
        }
        $events = new calendarEvents;
        $events->title = $request['title'];
        $events->start_date = $request['roomStart'];
        $events->color = $request['color'];
        $events->end_date = $request['roomEnd'];
        $events->save();
        Log::info('Someone added on calendar!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'start time' => $request['roomStart'], 
            'end time' =>  $request['roomEnd']
            ]);
            
        \Session::flash('success','Event added Successfully');
        return redirect()->route('pages.rooms.partialLaboratory.view');
    }

    public function viewSetupSchedule()
    {
        return view('pages.rooms.partialSetupTime.setupSchedule');
    }
  
    public function getSetupSchedule(Request $request){
        $arrayDay = [];
        $extratingDay = [];
        $getDay =  timeschedulesetup::where('sched_ID','>', 0)->get();
          
        $getLength = [];
        $collection = collect([1, 2, 3, 4, 5, 6, 7]);

        $chunks = $collection->crossJoin(['a', 'b']);
        $chunks->all();  
        foreach($getDay as $item)
        {     
                $extratingDay[] = $this->Scheday($item->set_day); 
                  
            } 
        

        if ($request->ajax()) { 
            $data = timeschedulesetup::where('sched_ID','>', 0)
            ->join('device','timeschedulesetup.device_ID','=','device.device_ID')
            ->join('rooms','timeschedulesetup.room_ID','=','rooms.id')  
            ->select('timeschedulesetup.*','rooms.roomName','device.name')
            ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        //    $btn = '<a href="/rooms/ShowEditSchedule/'.$row->sched_ID.'" data-toggle="tooltip"  data-id="'.$row->sched_ID.'" data-original-title="Edit" id="editSet" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                        // $btn = '';<button id="changeChart" ng-click="getTriggerChange();
                        $btn = '<input type="button" value="&nbsp;&nbsp;Edit&nbsp;&nbsp;" class="edit btn btn-primary btn-sm editProduct" id="edit" data-toggle="modal" data-target="#roleModal" name="edit" onclick="editFunction('.$row->room_ID.','.$row->sched_ID.')"/>';
                        $btn = $btn.' <a href="/rooms/ShowDeleteSchedule/'.$row->sched_ID.'" data-toggle="tooltip" id="delete"  
                        data-id="'.$row->sched_ID.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>
                        <script>$("#delete").on("click", function(){return confirm("Are you sure?");});
                        function editFunction(name, id)
                        {
                            $("#schedID").val(id);
                            $("#roomName").val(name);
                        }</script>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
       
        $schedulesetup = timeschedulesetup::where('sched_ID','>', 0)
        ->join('device','timeschedulesetup.device_ID','=','device.device_ID')
        ->join('rooms','timeschedulesetup.room_ID','=','rooms.id')
        ->select('timeschedulesetup.time_in','timeschedulesetup.time_out','timeschedulesetup.set_day','timeschedulesetup.sched_ID','rooms.roomName','device.name')
        ->get(); 
        // dd($extratingDay);
        return view('pages.rooms.partialSetupTime.setupSchedule')->with('schedulesetup',$schedulesetup);
    }
    //room instance for time schedule select name
    public function getRoomInstance()
    {
        $rooms = Room::where('id','>', 0)
        ->join('device', 'rooms.device_ID', '=', 'device.device_ID')
        ->select('rooms.*','device.name','device.desc', 'device.mac_add')
        ->orderBy('rooms.id','asc')
        ->get();  
        return response()->json($rooms); 
    }
    //save instance for time schedule
    public function saveSchedule(Request $request)
    {
        ///Diri ta ma compare
        $request->validate([
            'days' => 'required',  
            'hidden_rooms' => 'required',
            'timeIn' => 'required',
            'timeOut' => 'required'
        ]);  
        $myArray = []; 
        $getDivice = [];
        $getDevice_ID = [];
        $getDays = [];
        $getRoom = []; 
        $response = [];
        $initialShedule = new timeschedulesetup;
        $arrayRooms = explode(',', $request->get('hidden_rooms')); 
        $arrayDays = explode(',', $request->get('days')); 
        $getScheduleForUpdate = [];
        foreach($arrayRooms as $roomsData){ 
            $myArray[] = $roomsData;
            $initialShedule->room_ID = $myArray;
            $getRoom[] = Room::where('id','=',$roomsData)->first(); 
        } 
        foreach($getRoom as $dd)
        { 
            $getDivice[] = Device::select('device_ID')->where('device_ID','=',$dd->device_ID)->first(); 
        }   
        foreach($getDivice as $dd)
        { 
            $getDevice_ID[] = $dd->device_ID;
            $initialShedule->device_ID = $getDevice_ID;
        } 
        foreach($arrayDays as $dd)
        {
            $getDays[] = $dd;
            
            $initialShedule->days = $getDays;
        } 

        $getTimeIn = "";
        $getTimeOut = "";
        $getStringDays = "";
        $getTimeOut = $request->get('timeOut');
        $getTimeIn= $request->get('timeIn');
        $getStringDays = $request->get('days');

        //comparing roomID and Update Entity
        if(timeschedulesetup::where('room_ID','=',$roomsData)->where('time_in','=',$getTimeIn)->where('time_out','=',$getTimeOut)->first() != null){
            //  $dataTime = []; 
            foreach($myArray as $dateItem){
                 $dataTime = timeschedulesetup::where('room_ID','=',$dateItem)->where('time_in','=',$getTimeIn)->where('time_out','=',$getTimeOut)->first();  
                 $dataTime->time_in = $getTimeIn;
                 $dataTime->time_out = $getTimeOut;
                 $dataTime->set_day = $getStringDays;  
                 $dataTime->save(); 
             }  
        }
        else
        
        for($i=0; $i<count($getDivice); $i++){
               $object = new timeschedulesetup();
               $object->room_ID = $initialShedule->room_ID[$i];
               $object->device_ID  =$initialShedule->device_ID[$i];
               $object->set_day =$getStringDays;
               $object->time_out =$getTimeOut;
               $object->time_in = $getTimeIn;
               $object->save();
        }
        //end of declaration of comparing roomID
 
        
        Log::info('Someone added on calendar!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'start time' => $getTimeIn, 
            'end time' =>  $getTimeOut
            ]); 
            return response()->json($initialShedule);
    }
 
public function showRoomSchedule($id)
{
    $schedulesetup = timeschedulesetup::where('sched_ID','=', $id)
    ->join('device','timeschedulesetup.device_ID','=','device.device_ID')
    ->join('rooms','timeschedulesetup.room_ID','=','rooms.id')
    ->select('timeschedulesetup.time_in','timeschedulesetup.time_out','timeschedulesetup.set_day','timeschedulesetup.sched_ID','rooms.roomName','device.name')
    ->get();   
    
}

public function deleteRoomSchedule($id)
{
    
    $item = timeschedulesetup::where('sched_ID','=',$id)->first();
    $item->delete(); 
    return redirect('/setTime/calendar')->with('message', 'Successfully Deleted');
}

    private function Scheday($data)
    {  
        if($data == "1,1,0,0,0,0,1"){
          return "MON,TUE,SUN";
        }
        else if($data == "0,1,1,1,0,0,1")
        {
            return "TUE,WED,THU,SUN";
        }
        else if($data == "0,1,0,0,0,0,1"){
            return "TUE,SUN";
        } 
        else if($data == "0,1,1,0,0,1,1"){
            return "TUE,WED,SUN";
        }
        else if($data == "1,1,1,0,0,1,1"){
            return "MON,TUE,WED,SAT,SUN";
        }
        
        else if($data == "1,0,1,0,0,1,1"){
            return "MON,WED,SAT,SUN";
        }
        
        else if($data == "1,1,1,1,1,1,1"){
            return "MON,TUE,WED,THU,FRI,SAT,SUN";
        }
        
        else if($data == "1,1,1,1,1,0,0"){
            return "MON,TUE,WED,THU,FRI";
        }
        
        else if($data == "1,1,1,1,0,0,0"){
            return "MON,TUE,WED,THU";
        }
        
        else if($data == "1,1,1,0,0,0,0"){
            return "MON,TUE,WED";
        }
        
        else if($data == "1,1,0,0,0,0,0"){
            return "MON,TUE";
        }
        
        else if($data == "0,1,0,0,0,0,0"){
            return "TUE";
        }
        else if($data == "0,0,1,0,0,0,0"){
            return "WED";
        }
        else if($data == "0,0,0,1,0,0,0"){
            return "THU";
        } 
        else if($data == "0,0,0,0,1,0,0"){
            return "FRI";
        }
        else if($data == "0,0,0,0,0,1,0"){
            return "SAT";
        } 
        else if($data == "0,0,0,0,0,0,1"){
            return "SUN";
        }
        else if($data == "0,1,1,0,0,0,0"){
            return "TUE,WED";
        }
        else if($data == "0,0,1,1,0,0,0"){
            return "WED,THU";
        }
        else if($data == "0,0,0,1,1,0,0"){
            return "THU,FRI";
        } 
        else if($data == "0,0,0,0,1,1,0"){
            return "FRI,SAT";
        }
        else if($data == "1,0,0,0,0,0,1"){
            return "MON,SUN";
        }
        else if($data == "0,1,0,0,0,1,0"){
            return "TUE,SAT";
        }
        else if($data == "0,0,1,0,1,0,0"){
            return "WED,THU";
        }
        else if($data == "0,0,1,0,0,1,0"){
            return "WED,SAT";
        }
        else if($data == "1,0,0,1,0,0,0"){
            return "MON,THU";
        }
        else if($data == "0,1,0,0,1,0,0"){
            return "TUE,FRI";
        }
        else if($data == "0,0,0,1,0,0,1"){
            return "THU,SUN";
        }
        else if($data == "1,0,0,0,1,0,0"){
            return "MON,FRI";
        }
        else if($data == "0,1,0,0,0,1,0"){
            return "TUE,SAT";
        }
        else if($data == "0,0,1,0,0,0,1"){
            return "WED,SUN";
        }
        else if($data == "1,0,0,0,0,1,0"){
            return "MON,SAT";
        }
        else if($data == "0,1,0,0,0,0,1"){
            return "TUE,SUN";
        } 
        else if($data == "1,1,0,0,0,1,0"){
            return "MON,TUE,SAT";
        }
        else if($data == "1,0,1,0,0,1,0"){
            return "MON,WED,SAT";
        }
        else if($data == "1,0,1,0,1,1,0"){
            return "MON,WED,FRI,SAT";
        }
        else if($data == "1,0,1,1,0,1,0"){
            return "MON,WED,THU,SAT";
        }
        else if($data == "0,0,1,1,0,1,0"){
            return "WED,THU,SAT";
        }
        else if($data == "0,0,0,1,0,1,0"){
            return "THU,SAT";
        }
        else if($data == "1,0,1,0,1,0,0"){
            return "MON,WED,THU";
        }
        else if($data == "0,1,1,0,1,0,0"){
            return "MON,WED,THU";
        }
        else if($data == "0,1,0,1,0,0,0"){
            return "TUE,THU";
        }
        else if($data == "0,1,1,1,0,0,0"){
            return "TUE,WED,THU";
        }
        else if($data == "0,1,1,1,0,0,0"){
            return "TUE,WED,THU";
        }
        else if($data == "1,0,1,1,0,0,0"){
            return "MON,WED,THU";
        }
        else if($data == "0,1,1,1,1,0,0"){
            return "TUE,WED,THU,FRI";
        }
        else if($data == "0,1,0,1,1,0,0"){
            return "TUE,THU,FRI";
        } 
        else if($data == "1,0,1,0,0,0,0"){
            return "MON,WED";
        }
        else if($data == "1,0,0,0,0,0,0"){
            return "MON";
        }
        else if($data == "0,0,1,1,1,0,0"){
            return "WED,THU,FRI";
        }
        else if($data == "1,1,1,0,1,0,0"){
            return "MON,TUE,WED,FRI";
        }
        else if($data == "0,1,1,0,1,1,0"){
            return "TUE,WED,FRI,SAT";
        }
        else{
            return $data;
        }
        
    }
}
