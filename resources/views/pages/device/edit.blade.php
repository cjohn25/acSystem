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
                            <i class="glyphicon glyphicon-th-list"></i>EDIT DEVICE
                        </p>
                    </div>

                <div class="panel-options">
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                </div>
            </div>
            <div class="panel-body"> 

            @if(session()->has('errorMessage'))
            <div class="alert alert-danger">
                {{ session()->get('errorMessage') }}
            </div>
            @endif
            <form action="{{route('device.update',  $item->device_ID)}}" method="POST"
                class="form-horizontal form-groups-bordered">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label">
                        <strong>DEVICE NAME:</strong>
                    </label>

                    <div class="col-sm-4">
                            <input type="text" class="form-control" id="device" name="device" placeholder="device101"
                                value="{{$item->name}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><strong>DESC:</strong></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="desc" name="desc" placeholder="device 101"
                            value="{{$item->desc}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><strong>MAC ADDRESS</strong></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="mac_add" name="mac_add" value="{{$item->mac_add}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><strong>LOCATION</strong></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="location" name="location" placeholder="locate"
                            value="{{$item->location}}">
                    </div>
                </div>
                <input type="token" value={{csrf_token()}} name="token" hidden>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-5">
                        <a href="/device" class="btn btn-blue btn-icon btn-lg">
                            BACK
                            <i class="glyphicon glyphicon-arrow-left">&nbsp;</i>
                        </a>
                    </div>
                    <div class="col-sm-offset-2 col-sm-3">
                        <button type="submit" class="btn btn-blue btn-icon btn-lg">
                            UPDATE
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
