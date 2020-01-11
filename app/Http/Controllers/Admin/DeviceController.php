<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB; 
use App\Model\Room; 
use App\Model\Device; 
use Auth;
use Validator;
use Log;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $rooms = Room::all()->where('status','=',true);
         $device = DB::table('device')->paginate(5);
        // $device = Device::orderBy('device','asc')->get();
        return view('pages.device.view')->with(
            'device' , $device 
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $device = DB::table('device')
            ->groupBy('device_ID')
            ->groupBy('name')
            ->groupBy('desc')
            ->groupBy('Installed')
            ->groupBy('mac_add')
            ->groupBy('location')
            ->groupBy('created_at')
            ->groupBy('updated_at')
            ->get(); 
        return view('pages.device.add')->with([
            'positionList' => $device 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
        $request->validate([
            'name' => 'required|unique:device,name', 
            'desc' => 'required',
            'mac_add' => 'required|unique:device,mac_add',
            'location' => 'required'
            ]);

                Device::create([
                    'name' => $request->input('name'),
                    'desc' => $request->input('desc'),
                    'mac_add' => $request->input('mac_add'),
                    'Installed' => true,
                    'location' => $request->input('location')
                ]);
                
        Log::info('Someone add on Device!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'New device name' => $request->input('name')
            ]);
                return redirect()->route('device.index')->with('message', 'Succesfully Created');
    }
public function addDevice(Request $request)
{
    $this->validate($request,[
        'name' => 'required|unique:device,name', 
        'desc' => 'required',
        'mac_add' => 'required|unique:device,mac_add',
        'location' => 'required'
        ]);

            Device::create([
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'mac_add' => $request->input('mac_add'), 
                'location' => $request->input('location'),
                'Installed' => true,
            ]);
            Log::info('Someone add on Device!', [
                'login id' => Auth::user()->id,
                'login name' => Auth::user()->name,
                'New device name' => $request->input('name')
                ]);
            return redirect()->route('device.index')->with('message', 'Succesfully Created');

}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    
    public function edit($id)
    { 
        $item = Device::findOrFail($id);
        $rooms=Room::all()->where('Installed','=',true);
        return view('pages.device.edit')->with('item',$item);
    }
 
    public function update(Request $request, $id)
    {
        // 
        $request->validate([
            'device' => 'required', 
            'desc' => 'required',
            'mac_add' => 'required',
            'location' => 'required'
          ]); 
          $share = Device::find($id);
          $share->name = $request->get('device'); 
          $share->desc = $request->get('desc');
          $share->mac_add = $request->get('mac_add'); 
          $share->location = $request->get('location');   
          $share->Installed = true;
          
          $share->save();
          Log::info('Someone updated on Device!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'Id device' => $id,
            'New Device Name' => $request->get('device')
            ]);
          return redirect('/device')->with('message', 'Succesfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataDevice = Device::findOrFail($id);
        $dataDevice->delete();
        
        Log::info('Someone deleted on Device!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'Id device deleted' => $id 
            ]);
        return redirect('/device')->with('message', 'Successfully Deleted!');
    }
}
