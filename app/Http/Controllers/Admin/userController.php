<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB; 
use App\Model\Room; 
use App\Model\Accounts;
use App\Model\Role;
use Validator;
use Auth;  
use Log;
use Redirect,Response;
class userController extends Controller
{ 
    public function index()
    {  
        $rooms = Room::all()->where('status','=',true);
        $data = DB::table('users')
        ->join('roles', 'users.typeID', '=', 'roles.typeID') 
        ->select('users.*','roles.position')
        ->paginate(10);
        return view('pages.accounts.view')->with([
            'Allaccounts' => $data,
            'rooms' => $rooms
            ]);
    }
 
    public function create()
    {
        $typeList = DB::table('roles')
        ->groupBy('typeID')
        ->groupBy('position')
        ->groupBy('created_at')
        ->groupBy('updated_at')
        ->get();
        $rooms = Room::all()->where('status','=',true);
        return view('pages.accounts.add')->with([
            'positionList' => $typeList,
            'rooms' => $rooms
        ]);
    }
    //saving function for accounts
    public function store(Request $request)
    { 
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|string|email|max:180|unique:users',
            'password' => 'required|max:150|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/', 
            'typeID' => 'required|integer',
            're_password' => 'required'
            ]);
               if($request->get('re_password') != $request->get('password'))
            {
	            return Redirect::back()->with('errorMessage', 'Password and retype password do not match!'); 
            } 
         
            else
            
            Log::info('Someone saved on the system!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'account name' => $request->input('name'),
            'account email' => $request->input('email')
            ]);
            
            $request = Accounts::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'typeID' =>$request->input('typeID') 
            ]);
            return redirect()->route('accounts.index')->with('message', 'new Account created succesfully');
        //saving data 
    }
 
    public function show($id)
    { 
        $account= Accounts::findOrFail($id); 
    } 

    //view update accounts from accounts.edit
    public function edit($id)
    {
        $item = Accounts::find($id);
        $getRoles = Role::all();
        $rooms = Room::all()->where('status','=',true);
        return view('pages.accounts.edit', compact('item'))->with([
            'rooms'=> $rooms,
            'roles' => $getRoles
            ]);
 
    }
    //update function for accounts.edit
    public function update(Request $request, $id)
    { 
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'typeID'=>'required'
          ]);  
          $share = Accounts::find($id);
          $share->typeID = $request->get('typeID'); 
          $share->name = $request->get('name');
          $share->email = $request->get('email'); 
          $share->remember_token = $request->get('token');
          
          Log::info('Someone updated on the system!', [
              'login id' => $id,
              'login name' => Auth::user()->name,
              'account id updated' => $request->get('typeID'),
              'account name updated' => $request->get('name')
              ]);
               
          $share->save();
          return redirect('/accounts')->with('message', 'Succesfully Updated');
    }

    //delete function for account
    public function destroy($id)
    {
        Log::info('Someone delete on the system!', [
            'login id' => Auth::user()->id,
            'login name' => Auth::user()->name,
            'account id deleted' => $id 
            ]);
            
        $dataUser = DB::table('users')->where('id', '=', $id);
        $dataUser->delete();
        return redirect('accounts')->with('message', 'Deleted Succesfully');
    } 
}
