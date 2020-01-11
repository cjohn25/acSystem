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
                            <i class="entypo-tools"></i>ADD DEVICE
                        </p>
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
                        </div><br />
                        @endif

                        @if(session()->has('errorMessage'))
                        <div class="alert alert-danger">
                            {{ session()->get('errorMessage') }}
                        </div>
                        @endif
                        {{-- <form  action="{{URL::to('/device')}}" method="POST" class="form-horizontal
                        form-groups-bordered">
                        --}}
                        <form action="{{ route('admin.deviceRegister') }}" method="POST"
                            class="form-horizontal form-groups-bordered">
                            @csrf
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">DEVICE NAME</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="device 101">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">DESC</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="desc" name="desc">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">MAC ADDRESS</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="mac_add" name="mac_add"
                                        placeholder="123CAED">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">LOCATION</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="location" name="location"
                                        placeholder="locate">
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
</div>
<br><br><br>
{{-- second layer --}}
@endsection
