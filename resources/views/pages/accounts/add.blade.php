@extends('layouts.index')
@section('content')

<br />
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title col-md-12">
                        <p
                            style="font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8;padding:10px">
                            <i class="entypo-user-add"></i>CREATE ACCOUNT</p>
                    </div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <br />
                        @endif
                        <form action="{{URL::to('/accounts')}}" method="POST"
                            class="form-horizontal form-groups-bordered">
                            @csrf
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Name</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Cruz">
                                </div>
                            </div>
                            {{-- <div class="form-group">
                            <label class="col-sm-3 control-label">email</label>
                            
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="entypo-mail"></i></span>
                                    <input type="text" class="form-control" placeholder="@mail.com" name="email" id="email">
								</div> 
                            </div>
                    		</div> --}}

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email</label>

                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">@</span>
                                        <input type="email" class="form-control" placeholder="email@gmail.com"
                                            name="email" id="email">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-3" class="col-sm-3 control-label">Password</label>

                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="field-3"
                                        placeholder="Placeholder (Password)" name="password" id="password">
                                   @if($errors->any()) 
                                       
                                        @foreach ($errors->all() as $error) 
                                            @if($error =='The password format is invalid.')
                                           <div class="alert alert-danger">
                                            <strong>Oh snap!</strong> Password must contain atleast minimum of 8 characters, 
                                            including 1 Uppercase and 1 number. 
                                                </div> 
                                            @endif
                                        @endforeach
                                     @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-3" class="col-sm-3 control-label">Re-type Password</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="field-3"
                                        placeholder="***********" name="re_password" id="re_password">
                                        @if(session()->has('errorMessage'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('errorMessage') }}
                                        </div>
                                        @endif
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Position</label>

                                <div class="col-sm-5">
                                    <select class="form-control" name="typeID" id="typeID" required>
                                        <option value="">Select Item</option>
                                        @foreach($positionList as $item)
                                        <option value="{{$item->typeID}}">{{$item->position}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <input type="token" value={{csrf_token()}} name="token" hidden>
                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-5">
                                    <a href="/accounts" class="btn btn-blue btn-icon btn-lg">
                                        BACK
                                        <i class="glyphicon glyphicon-arrow-left">&nbsp;</i>
                                    </a>
                                </div>
                                <div class="col-sm-offset-2 col-sm-3">
                                    <button type="submit" class="btn btn-blue btn-icon btn-lg">
                                        ADD USER
                                        <i class="entypo-user-add"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<br><br><br>
{{-- second layer --}}
@endsection
