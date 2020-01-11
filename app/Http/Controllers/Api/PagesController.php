<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Calendar;
use DB;  
use App\Model\Room;
use App\Model\Role;
use App\Model\Accounts;
use App\Model\Device;
use App\Model\Data_Reading;
use App\CustomModel\wattsAndPower;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;use Illuminate\Support\Arr;
class PagesController extends Controller
{
    //
    public function layouts(){
        // $title = 'Welcome to our homepage!';
        return view('layouts.index');
        // return view('pages.index', compact('title'));
        // return view('layouts.index')->with('title', $title);
    }

    public function dashboard(){
        // $data = array(
        //     'title' => 'dashboard',
        //     'service' => ['Web design', 'Programming', 'SEO']
        // ); 
        // return view('pages.dashboard')->with($data);
        return view('pages.dashboard');
    }
    
    public function summary(){ 
        $data = Room::all();
        $role = Role::all();
        $roomAvailability  = Room::where('status','=',true)->get(); 
        $users = Accounts::all();
        $Device = Device::all();
        $data_reading = Data_Reading::all();

        $setDateFrom = '2019-09-1 08:07:22';
        $setDateTo = Carbon::parse()->startOfDay()->toDateTimeString(); 

        return view('pages.summary')->with([
            'rooms'=> $data,
            'role'=> $role,
            'users'=> $users,
            'roomAvailability' => $roomAvailability,
            'Device'=> $Device,
            'dataReading'=> $data_reading 
            ]);
       
    } 

    public function testforProfile(){
        $data =Room::all()->where('status','=',true);
        $getID = Auth::user()->id;
        $item = DB::table('users')->where('id','=',$getID)->where('isDeleted','=',0);
        return view('pages.accounts.profile', compact('item'))->with('rooms',$data);
    }

    public function index(){
        
        $rooms  = Room::take()->get();
        return view();
    }

    public function showDashboard(Request $request)
    {
        $getDate1 =  $request->get('datepicker') != null ||  $request->get('datepicker') != '' ? $request->get('datepicker'): '2019-09-1 08:07:22';
        $getDate2 =  $request->get('datepicker2') != null ||  $request->get('datepicker2') != '' ? $request->get('datepicker2'): '2019-09-1 08:07:22';

        $from = Carbon::parse($getDate1)
        ->startOfDay()        // 2018-09-29 00:00:00.000000
        ->toDateTimeString(); // 2018-09-29 00:00:00

        $to = Carbon::parse($getDate2)
        ->endOfDay()          // 2018-09-29 23:59:59.000000
        ->toDateTimeString(); // 2018-09-29 23:59:59

        $data  = Room::whereBetween('created_at', [$from, $to])->get();
        $roomAvailability  = Room::whereBetween('created_at', [$from, $to])->where('status','=',true)->get(); // status = 1 equivalent to true or available
        $role = Role::whereBetween('created_at', [$from, $to])->get();
        $users = Accounts::whereBetween('created_at', [$from, $to])->get();
        $Device = Device::whereBetween('created_at', [$from, $to])->get();
        $data_reading = Data_Reading::whereBetween('created_at', [$from, $to])->get();  
        // $this->getDataForDashboard($request);
        // $this->getGuageForDashboard($request);
        return view('pages.summary')->with([
            'rooms'=> $data,
            'roomAvailability' => $roomAvailability,
            'role'=> $role,
            'users'=> $users,
            'Device'=> $Device,
            'dataReading'=> $data_reading 
            ]);
    }

    public function getDataForDashboard_Post(Request $request)
    {
         
        $getData = []; 
        $days  = []; 
        $DateFrom = $this->DateFrom(
            $request->get('datepicker') != null ||  $request->get('datepicker') != '' ? $request->get('datepicker'): '2019-09-1 08:07:22'
        );
        $DateTo = $this->DateFrom(
            $request->get('datepicker2') != null ||  $request->get('datepicker2') != '' ? $request->get('datepicker2'): now()
        );
        $data =  $this->getSelectRoom(
            $request->get('selectRoom')
        ); 
        // $data = Room::where('id','>',0)
        // ->orderBy('rooms.created_at','desc')->get();   
              foreach($data as $da)
            { 
                $getData[] =Data_reading::where('room_ID','=',$da->id)->orderBy('data_reading.created_at','desc')->get();   
            }  
              
        $collection = new Collection(); 
        $collection12 = new Collection();
        foreach($getData as $dd)
        {
            $getCountLength = count($dd);
            foreach($dd as $item1)
            { 
                $collection[] = $dd->sum('power'); 
            }
        }   
                    if($request->get('selectRoom')>0)
                    {
                        $days = DB::table('data_reading')->where('room_ID', '=', $request->get('selectRoom'))
                        ->selectRaw('data_reading.*,created_at') 
                        ->whereBetween('created_at', [$DateFrom, $DateTo])->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('d/h');//d is for day// i change to h is define to hour
                        });  
                    }else
                        $days = DB::table('data_reading')  
                        ->selectRaw('data_reading.*,created_at') 
                        ->whereBetween('created_at', [$DateFrom, $DateTo])->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('d/h');//d is for day// i change to h is define to hour
                        });
        $collection1 = new Collection();  
        $collection2 = new Collection(); 
        $getCountLength=[];
        $getDateCollection = [];  
        foreach($days as $item)
        {
            $collection1[] = $item->sum('power')/count($item);
            $collection2[] = $item; 
            $getCountLength=count($item);
        }   
        $totalWatts = [];
        foreach($collection as $item){
            
            $totalWatts = $item;
        }
        $getWatts = new wattsAndPower();
        // $getTotalVoltage = ($collection->sum('voltage'));
        // $getTotalWatts =($collection->sum('power') * 8);
        $getWatts->TotalWatts =$totalWatts;
        $getWatts->TotalVoltage =($collection->sum('voltage'));


        $getWatts->parseTotalVoltage = $collection1;
        $getWatts->getData = $collection2;    
        $getWatts->collectionDate = Arr::pluck($collection2,  '0.created_at');
        
        $getWatts->getRoomData = $data;
        return response()->json($getWatts);

    }
    public function getDataForDashboard()
    { 
        $data = Room::where('id','>',0)->get(); 
        $getData = [];
        foreach($data as $da)
        {
            $getData[] =Data_reading::where('room_ID','=',$da->id)->orderBy('data_reading.created_at','desc')->get(); // qng anu ang latest "desc" 
        } 

        // $getRoomData = [];
        // foreach($getData as $sat){
        //     $getRoomData[] =Room::where('id','=',$sat->room_ID)->first();
        // }
        $getCountLength = '';
        $getTotal = '';
        $collection = new Collection(); 
        foreach($getData as $dd)
        {
            $collection[] = $dd;  
            $getCountLength = count($dd); 
            foreach($dd as $coll)
            { 
                $getTotal =$coll->sum('power'); 
                // $getWatts->TotalVoltage = ($coll->sum('voltage'));
            }
       
        }  
        $days = DB::table('data_reading')  
        ->selectRaw('data_reading.*,created_at') 
        ->whereRaw('created_at between DATE_SUB("2019-1-1 08:07:22", INTERVAL 15 MINUTE) and NOW()')->get()
         ->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('d/h');//d is for day// i change to h is define to hour
        }); 

        $collection1 = new Collection();  
        $collection2 = new Collection(); 
        $getCountLength=[];
        $getDateCollection = [];  
        foreach($days as $item)
        {
            $collection1[] = $item->sum('power')/count($item);
            $collection2[] = $item; 
            $getCountLength = count($item);
        }   

        $getWatts = new wattsAndPower(); 
        $getWatts->TotalWatts =$getTotal; 
        $getWatts->TotalVoltage = ($collection->sum('voltage'));

        $getWatts->parseTotalVoltage = $collection1;
        $getWatts->getData = $collection2;
        $getWatts->collection1 = $collection;
        $getWatts->collectionDate =Arr::pluck($collection2, '0.created_at');
        $getWatts->getRoomData = $data;
        return response()->json($getWatts); 
    }

    // public function getGuageForDashboard(Request $request)
    // {  
    //      $data = Room::where('id','>',0)
    //     ->orderBy('rooms.created_at','desc')->get(); 
    //     $getData = [];
    //     foreach($data as $da)
    //     {
    //         $getData[] =Data_reading::where('room_ID','=',$da->id)
    //         ->whereBetween('created_at', ['2019-01-1 08:07:22', now()->addDays(7)])
    //         ->orderBy('data_reading.created_at','desc')->first(); // qng anu ang latest "desc" 
    //     }
    //     $collection = new Collection(); 
    //     foreach($getData as $dd)
    //     {
    //         $collection[] = $dd; 
    //     } 
    //     $getWatts = new wattsAndPower();
    //     $getTotalVoltage = $collection->sum('voltage');
    //     $getTotalWatts =$collection->sum('power');
    //     $getWatts->TotalWatts = $getTotalWatts;
    //     $getWatts->TotalVoltage = $getTotalVoltage; 
 
    //     $days = Data_reading::whereBetween('created_at', ['2019-01-1 08:07:22', now()->addDays(7)])
    //     ->orderBy('created_at')
    //     ->get()
    //     ->groupBy(function ($val) {
    //         return Carbon::parse($val->created_at)->format('d');//d is for day// i change to h is define to hour
    //     });
        
    //     $collection1 = new Collection();  
    //     $collection2 = new Collection(); 
    //     foreach($days as $item)
    //     {
    //         $collection1[] = $item->sum('power');
    //     }
    //     foreach($collection1 as $itemData)
    //     {
    //         $collection2[] = $itemData;
    //     }
    //     $getWatts->parseTotalVoltage = $collection1;
    //     return response()->json($getWatts);  
    // }
//    public function getGuageForDashboard_Post(Request $request)
//     {    
//     }
    private function DateFrom($dataFrom){
        return Carbon::parse($dataFrom)
        ->startOfDay()        // 2018-09-29 00:00:00.000000
        ->toDateTimeString(); // 2018-09-29 00:00:00
    }
    private function DateTo($dataTo){
        return Carbon::parse($dataTo)
        ->endOfDay()          // 2018-09-29 23:59:59.000000
        ->toDateTimeString(); // 2018-09-29 23:59:59
    }

    private function getSelectRoom($getData)
    {
         $id = $getData != null || $getData != ''? $getData: 0;
        if($id > 0)
        {  
        return Room::where('id','=',$id)
        ->orderBy('rooms.created_at','desc')
        ->get();
        }
        else
        return Room::where('id','>',0)   
        ->orderBy('rooms.created_at','desc')
        ->get();
    }
    
 
}
