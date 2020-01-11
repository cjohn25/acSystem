<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Room;
use App\Model\Device;

use App\Model\Data_Reading;
use Validator;

use Redirect,Response;
use Auth;
use DB; 
use App\Model\calendarEvents;
use Calendar;
use Lava;
use Log;
use App\Model\timeschedulesetup;
class RoomController extends Controller
{
    //
    // public function __construct()
    // {
    //     $rooms = collect(Room::get())->pluck('roomName','routeName', 'id');
    //     // $lead = new Lead();
    //     // $states = $lead->getStates();
    //     // $vici = new VicidialCredential();
    //     // $servers = collect($vici->getServers());
 
    //     view()->share(compact('rooms'));
    // }
 
    public function index()
    { 
        $rooms =Room::all()->where('status','=',true);
        $data = DB::table('rooms')
        ->join('device', 'rooms.device_ID', '=', 'device.device_ID') 
        ->select('rooms.*','device.name')
        ->where('isDeleted','=',0)->paginate(5);
        return view('pages.rooms.view', ['roomsData' => $data, 'rooms' => $rooms]); 
        // echo url()->current();
        // echo url()->full();
        // echo url()->previous();
    } 

    public function create()
    {
        //
        $data = Room::all()->where('status','=',true);
        $device = Device::all()->where('Installed','=',true); 
        return view('pages.rooms.add')->with([
            'rooms' => $data,
            'device' => $device
            ]);
    }
 
    public function store(Request $request)
    {   
        // is_integer($num1=1); 
          
        $request->validate([
            'roomName' => 'required|max:100|unique:rooms,roomName',  
            'device_ID' => 'required',
            'status' => 'required'
            ]);  
            Room::create([
                'roomName' => $request->get('roomName'),
                'routeName' => '/'.$request->get('roomName'),
                'device_ID' => $request->get('device_ID'),
                'status' => $request->get('status')
            ]);
            
          $DataStatus = $request->get('status') != 1 ? true:false;
            DB::table('device')->where('device_ID','=',$request->get('device_ID'))->update(['Installed'=>false]);


            // $getRoomID = Room::where('id','>',0)
            // ->orderBy('id', 'desc')->first();    
            // Data_Reading::create([
            //     'device_ID' => $request->get('device_ID'),
            //     'room_ID' => $getRoomID->id,
            //     'user_ID' => Auth::user()->id,
            //     'power' => 0,
            //     'status' => $DataStatus,
            //     'voltage' =>0
            // ]);


            Log::info('Someone added on room!', [
                'login id' => Auth::user()->id,
                'login name' => Auth::user()->name, 
                'Newly added Room name' => $request->get('roomName')
                ]);

                return redirect()->route('rooms.index')->with('message', 'Succesfully Created');
    }
    
    public function show($id)
    {
        $item= Room::findOrFail($id);
        $rooms =Room::all()->where('status','=',true);
        return view('pages.rooms.partialLaboratory.view', compact('item'))->with('rooms',$rooms);
    }


    public function showRoomData($id)
    { 
        //   $data = Data_Reading::where('user_ID','=', $id)
        //   ->join('device','data_reading.device_ID', '=', 'device.device_ID')
        //   ->orderBy('data_reading.updated_at', 'desc')->first();    
  
        // return view('pages.rooms.partialLaboratory.view')->with('item',$data);

        $item= Room::findOrFail($id);
        $rooms =Room::all()->where('status','=',true);
        return view('pages.rooms.partialLaboratory.view', compact('item'))->with('rooms',$rooms);
   
        
    }


    //rooms//edit
    public function edit($id)
    { 
        // $item = Room::find($id);
        $rooms =Room::where('id','=',$id)
        ->join('device','rooms.device_ID','=','device.device_ID') 
        ->select('rooms.*','device.name')->first();
         
        $device =Device::all()->where('Installed','=',true);  
        return view('pages.rooms.edit')->with([
            'item' => $rooms,
            'allDevice' =>$device
            ]);
    } 
//room list update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'rootname'=> 'required' 
          ]); 

          $getRoomData = Room::where('id','=',$id)->first();
          $getDevice = Device::where('device_ID','=', $getRoomData->device_ID)->where('Installed','=', false)->first();
            if($getDevice->device_ID){
                Device::where('device_ID','=', $getDevice->device_ID)->update(['Installed'=>true]); 
                Device::where('device_ID','=', $request->device_ID)->update(['Installed'=>false]); 
                return  $this->updateRelease($request, $id);
            }
            else
            Device::where('device_ID','=', $getRoomData->device_ID)->update(['Installed'=>false]); 
           return $this->updateRelease($request, $id);
        //   $share = Room::find($id);
        //   $share->roomName = $request->get('name');
        //   $share->routeName = $request->get('rootname'); 
        //   $share->device_ID = $request->get('device_ID');
        //   $share->save();
             
    }
    public function updateRelease($request, $id)
    {
        Room::where('id','=',$id)->update([
            'roomName' =>  $request->get('name'),
            'routeName' => $request->get('rootname'),
            'device_ID' => $request->get('device_ID')
        ]);
         DB::table('rooms')
          ->join('device', 'rooms.device_ID', '=', 'device.device_ID')
          ->select('rooms.*','device.name')
          ->where('isDeleted','=',0)->paginate(5); 

          Log::info('Someone updated on room!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'Room id' => $id,
            'Room name' =>  $request->get('rootname')
            ]);

        return redirect()->route('rooms.index')->with('message', 'Updated Succesfully');
    }
    //room list update end
 
    public function destroy($id)
    {
        
        $getDeviceID = Room::where('id','=',$id)->first();
        DB::table('device')->where('device_ID','=',$getDeviceID->device_ID)->update(['Installed'=>true]); 
        $item = Room::where('id','=',$id);
        $item->delete();
        Log::info('Someone deleted on room!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'Room id deleted' => $id
            ]);
        return redirect('/rooms')->with('message', 'Successfully Deleted');
    }

    public function Search(){
        $searchData = App\Model\Room::search('room3')->get();
        echo $searchData;
    }
    public function searchRoom(Request $request)
    {
        try
        {
            $search = $request->input('search');
            $data = Room::all()->where('status','=',true);
            $results =  Room::where('roomName', 'like', '%' . $search . '%')
                            ->where('routeName', 'like', '%' . $search . '%')
                            ->join('device', 'rooms.device_ID', '=', 'device.device_ID')
                            // $role = Role::findorFail();
                            ->select('rooms.*','device.name')
                            ->where('isDeleted', '=', 0)->paginate(5);
            return view('pages.rooms.view')->with([
                'rooms' => $data,
                'roomsData' => $results
            ]);               }
        catch(Exception $e){ 
        } 
    }
 
    public function showRoom($id)
    {    
        $roomData = [];
        $getDataforReading = Data_Reading::where('room_ID','=', $id)
          ->join('device','data_reading.device_ID', '=', 'device.device_ID')
          ->join('users','data_reading.user_ID','=','users.id') 
          ->join('rooms','data_reading.room_ID','=','rooms.id') 
          ->orderBy('data_reading.created_at', 'desc')->first(); 
                

                if($getDataforReading){
                    $roomData = Data_Reading::where('room_ID','=', $id)
                    ->join('device','data_reading.device_ID', '=', 'device.device_ID')
                    ->join('users','data_reading.user_ID','=','users.id') 
                    ->join('rooms','data_reading.room_ID','=','rooms.id') 
                    ->orderBy('data_reading.created_at', 'desc')->first(); 
                }
                else
                $roomData = Room::where('id','=',$id)
                ->join('device','rooms.device_ID','=','device.device_ID')
                ->first();  
     
        $setupSched = timeschedulesetup::where('room_ID','=',$id)->get();   
        $even_list = []; 

        foreach($setupSched as $key => $event){ 
            $even_list[] = Calendar::event(
                // $event->title,
                'Class Starts at>>'.$event->time_in,
                false,
                new \DateTime($event->time_in),
                // date('y-m-d H:i:s', strtotime($event->time_in)), 
                new \DateTime($event->time_out. ' +1 day'),
                // date('y-m-d H:i:s', strtotime($event->time_out)), 
                $event->sched_ID
                // new \DateTime($event->time_in),
                // new \DateTime($event->time_out. ' +1 day')
            );
        }

        $calendar_details = Calendar::addEvents($even_list);
         
        return view('pages.rooms.partialLaboratory.view', compact('calendar_details'))->with('item',$roomData);
    }
    public function showUI($id)
    {
       
        // return redirect()->route('pages.rooms.partialLaboratory.view');
        $data = Data_Reading::where('room_ID','=', $id)
        ->orderBy('data_reading.created_at','desc')->first();
        return response()->json($data);
        // return view('pages.rooms.partialLaboratory.view')->with('item',$data);
    }
 
}
