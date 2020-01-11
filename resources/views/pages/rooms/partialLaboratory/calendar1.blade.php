@extends('layouts.index')
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div><br />
@endif

<div class="panel-title">
    <p style="font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8;padding:10px">
        <i class="glyphicon glyphicon-th-list"></i>
        CALENDAR: &nbsp;
    </p>
</div>
<div class="col-md-12 panel panel-primary" data-collapsed="0">
    <div class="jumbotron">
            @if(session()->has('errorMessage'))
            <div class="alert alert-danger">
                {{ session()->get('errorMessage') }}
            </div>
            @endif
        <div class="">
            <div class="panel-heading" class="background:#2e6da4;color:white;">
            </div>
            <div class="panel-body">
                <form action="{{ route('events.add')}}" method="POST" files=true>
                        @csrf
                {{-- {!! Form::open(array('route' => 'events.add', 'method'=>'POST','files'=>'true')) !!} --}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @if (Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                        @elseif (Session::has('warning'))
                    <div class="alert alert-danger">{{Session::get('warning')}}</div>
                        @endif
                    </div>

                    {{-- <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            Event Name:
                            <div class="">
                                <input type="text" class="form-control" name="title" id="title">
                                @if(session()->has('warning'))
                                <p class="alert alert-danger">
                                        {{ session()->get('warning') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group"> 
                            Start Date:
                            <div class="">
                                <input type="date" class="form-control" id="start_date" name="start_date"> 
                                @if(session()->has('warning'))
                                <p class="alert alert-danger">
                                        {{ session()->get('warning') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                End Date
                                <div class="">
                                    <input type="date" id="end_date" name="end_date" class="form-control">
                                    @if(session()->has('warning'))
                                    <p class="alert alert-danger">
                                            {{ session()->get('warning') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-1 col-sm-1 col-md-1 text-center">&nbsp;
                            <br/> 
                            <button type="submit" class="btn btn-primary" id="submit" name="submit">ADD EVENT</button>
                        </div> --}}
                </div>
                {{-- {!! Form::close() !!} --}}
            </form>
            </div>
        </div>
        {{-- bottom --}}
        <div class="panel panel-primary">
            <div class="panel-heading">My Event Details</div>
            <div class="panel-body">
                    {!! $calendar_details->calendar() !!}
                    {!! $calendar_details->script() !!}
            </div>
        </div>

    </div>
</div>

<br><br>
<div align="center">
    <a href="/rooms" class="btn btn-blue btn-icon btn-lg">
        BACK
        <i class="glyphicon glyphicon-arrow-left">&nbsp;</i>
    </a>
</div>
<br>

<script>
</script>
@endsection
