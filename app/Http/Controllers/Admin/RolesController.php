<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB; 
use App\Model\Role;
use Auth;  
use Log;
use App\Model\Room;
use Illuminate\Support\Facades\Storage;
class RolesController extends Controller
{
    //
    // public function __construct()
    // {
    //     $collection = collect(Role::get());
    //     $roles = $collection->pluck('position', 'typeID','created_at');
    //     view()->share('roles', $roles->all());
    // }

    public function index(){
        // $roles = Role::paginate(20);  
        // $roles = Role::orderBy('position','asc')->get(); 
        $roles = DB::table('roles')->where('typeID','>',1)->paginate(5);
        return view('pages.roles.view')->with('dataRoles', $roles);
    }
public function showRolePage()
{ 
    $roles = DB::table('roles')->where('typeID','>',1)->paginate(5); 
    return view('pages.roles.view' , ['dataRoles' => $roles]);   
     
}
    public function create()
    {  
        
        $rooms = Room::all()->where('status','=',true);
        return view('pages.roles.add')->with('rooms', $rooms);
    }

    public function store(Request $request){
        // $request->validate([
        //     'position' => 'required|unique:roles,position' 
        //     ]);
        //     Role::create($request->all());
        //     return redirect()->route('roles.index')->with('message', 'Succesfully Created');
        // return view('pages.roles.view');
    }   
  
    //add function for roles
public function addRoles(Request $request)
{   
    $this->validate($request,[
        'position' => 'required|unique:roles,position',
        ]);   
        
        Log::info('Someone add on roles!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'new role name' => $request->input('position')
            ]);

        $request = Role::create([ 
            'position'  => $request->input('position')
         ]);  
}
//delete function for roles
    public function destroy($id){
        $item = Role::find($id);
        $item->delete();
        
        Log::info('Someone deleted on roles!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'role id deleted' => $id
            ]);
        return redirect('/roles')->with('message', 'Successfully DELETED');
    }

    public function edit($id){
        $item = Role::findOrFail($id);
        $rooms= Room::all()->where('status','=',true);
        return view('pages.roles.edit', compact('item'))->with('rooms',$rooms);
    } 
    //update function for roles
    public function update(Request $request, $id)
    {
        $request->validate([
            'position'=>'required'
          ]); 
          $share = Role::find($id); 
          $share->position = $request->get('position'); 
          $share->save();
          Log::info('Someone updated on roles!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'role id updated' => $id
            ]);
            
          return redirect('/roles')->with('message', 'Succesfully Updated');
    }
    
    public function show($id)
    {  
        
        $rooms = Room::findorFail($id);
        return $rooms;
    }
 

}
