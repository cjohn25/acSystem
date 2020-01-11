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
                            <i class="glyphicon glyphicon-th-list"></i>Create Room
                        </p>
                    </div>

                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                    </div>
                </div>
                <div class="panel-body">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                    @endif

                    @if(session()->has('errorMessage'))
                    <div class="alert alert-danger">
                        {{ session()->get('errorMessage') }}
                    </div>
                    @endif
                    <form action="{{URL::to('/rooms')}}" method="POST" class="form-horizontal form-groups-bordered">
                        @csrf
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><strong>Title of Menu Item:</strong></label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="roomName" name="roomName"
                                    placeholder="Room 1">
                            </div>
                        </div>
                                <input type="text" hidden id="status" name="status" value=1>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><strong>Device :</strong></label>
                            <div class="col-sm-5">
                                @if(count($device)> 0)
                                <select class="form-control" name="device_ID" id="device_ID" required>
                                    @foreach($device as $item)
                                    <option value="{{$item->device_ID}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @else
                                <a href="/device/create" class="btn btn-blue btn-icon btn-md">
                                    ADD DEVICE FIRST
                                    <i class="glyphicon glyphicon-plus">&nbsp;</i> </a>
                                @endif
                            </div>
                        </div>
                        <input type="token" value={{csrf_token()}} name="token" hidden>
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-5">
                                <a href="/rooms" class="btn btn-blue btn-icon btn-lg">
                                    BACK
                                    <i class="glyphicon glyphicon-arrow-left">&nbsp;</i>
                                </a>
                            </div>
                            <div class="col-sm-offset-2 col-sm-3">
                                <button type="submit" class="btn btn-blue btn-icon btn-lg">
                                    CREATE
                                    <i class="glyphicon glyphicon-th-list">&nbsp;</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
{{-- second layer --}}
@endsection
