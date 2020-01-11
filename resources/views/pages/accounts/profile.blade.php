@extends('layouts.index')
@section('content')

<div class="row">
<div class="col-md-12">
    
    <div class="panel panel-primary" data-collapsed="0">
    
        <div class="panel-heading">
            
                <div class="panel-title col-md-12">
                        <p
                            style="font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8;padding:10px">
                            VIEW PROFILE<i class="entypo-user"></i>
                    </div> 
            
            <div class="panel-options">
                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
            </div>
        </div>
        <div class="panel-body  col-md-12"> 
                {{-- @csrf --}}
                <div class="col-md-12"><br><br></div>
            <div class="form-group col-md-5">
                    <label for="field-1" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Cruz" disabled> 
                    </div>
            </div> 
            <div class="form-group  col-md-5">
                <label  for="field-2" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                        <span class="input-group-addon">@</span>
                        <input type="text" class="form-control" placeholder="Username"  name="username" id="username" disabled>
                   </div>
                </div>
            </div> 
                <div class="form-group col-md-5">
                    <label for="field-2" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="role" id="role" disabled> 
                    </div>
                </div>
                <div class="form-group  col-md-5">
                        <label  for="field-2" class="col-sm-2 control-label">Date Created</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="11/2/2018"  name="created_at" id="created_at" disabled>
                        </div>
                    </div> 
            <input type="token" value={{csrf_token()}} name="token" hidden> 
                <div class="form-group col-md-12">
                    <div class="col-sm-offset-5 col-sm-5">
                            <br><br>
                            <a href="/accounts" class="btn btn-blue btn-lg">
                                <i class="entypo-left-bold"></i>
                            </a>
                    </div> 
                </div>
        </div>
    </div>
</div>
</div>
@endsection