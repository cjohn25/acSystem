@extends('layouts.index')
@section('content')

<link rel="stylesheet" href="{{asset('assets/css/highcartsStyle.css')}}" id="style-resource-6">


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
        LABORATORY NAME: &nbsp;
        <label for="" style="color:red;"> {{$item->roomName}}</label>
    </p>
</div>
<div class="col-md-12 panel panel-primary" data-collapsed="0">

    <div class="panel-heading">
        <label for="field-1" class="col-sm-3 control-label">
        </label>
    </div>

    {{-- left column --}}
    <div class="col-md-12 panel-body">

        <form method="POST" action="{{ route('add.DataReading', $item->id)}}">
            <div class="col-md-6 list-group-item" style="border-color:#303641;border-style:double">
                {{-- diri ko na remove --}}

                {{-- Calendar --}}
                @if(session()->has('errorMessage'))
                <div class="alert alert-danger">
                    {{ session()->get('errorMessage') }}
                </div>
                @endif
                <div class="">
                    <div class="panel-heading">
                        {{-- CALENDAR --}}


                    </div>

                    {{-- bottom --}}
                    <div class="panel panel-primary">

                        <div class="panel-body">
                            {!! $calendar_details->calendar() !!}
                            {!! $calendar_details->script() !!}
                        </div>
                    </div>
                </div>
                {{-- Calendar --}}
            </div>
            {{-- right column --}}
            <input type="hidden" value="{{$item->roomName}}" name="roomName" id="roomName">
            <input type="hidden" value="{{$item->routeName}}" name="routeName" id="routeName">
            <input type="hidden" value="{{$item->id}}" name="roomid" id="roomid">
            <input type="hidden" class="form-control" maxlength=3 name="power" id="power" value={{$item->power}}>
            <input type="hidden" class="form-control" name="voltage" id="voltage" maxlength="6"
                value={{$item->voltage}}>
            @csrf
            <div class="col-md-6">
                <br>
                <label for="field-1" class="col-sm-2 control-label">
                    <h4><strong> STATUS:</strong></h4>
                </label>
                <div>
                    <div class="form-group">
                        @if ($item->status==0)
                        <label class="col-sm-3 control-label">
                            <h4 style="color:green" class="col-sm-3 control-label">
                                <strong>ON</strong>
                            </h4>
                        </label>
                        <input type="hidden" value=1 id="status" name="status">
                        <input type="hidden" class="form-control" id="roomStart" name="roomStart"
                            value="{{$item->created_at}}">
                        <input type="hidden" class="form-control" id="roomEnd" name="roomEnd"
                            value="{{$item->updated_at}}">
                        <button type="submit" class="btn btn-danger btn-icon btn-lg">STOP
                            <i class="entypo-stop">&nbsp;</i>
                        </button>
                        </button>
                        <a class="btn btn-success btn-icon btn-lg" disabled>
                            ON
                        </a>
                        <div align="center" class="col-md-12">
                            <br>
                        </div>
                        @else
                        <label class="col-sm-3 control-label">
                            <h4 style="color:red;" class="col-sm-3 control-label">
                                <strong>OFF</strong>
                            </h4>
                        </label>

                        <input type="hidden" value=0 id="status" name="status">
                        <input type="hidden" class="form-control" id="roomEnd" name="roomEnd"
                            value="{{$item->updated_at}}">
                        <input type="hidden" class="form-control" id="roomStart" name="roomStart"
                            value="{{$item->created_at}}">
                        <a type="button" class="btn btn-danger btn-icon btn-lg" disabled>
                            STOP
                        </a>
                        <button type="submit" class="btn btn-success btn-icon btn-lg">ON
                            <i class="entypo-play">&nbsp;</i>
                        </button>
                        <div align="center" class="col-md-12">
                            <br>
                        </div>
                        @endif
                    </div>
                </div>
                <br>
                <div class="outer">
                    <div id="gauge_div" style="float:left"></div>
                    <div id="gauge_div2" style="float:left"></div>
                </div>
                <div align="center">
                    <h3>Energy Consumption</h3>

                    <br> <br>
                </div>
            </div>


            <div class="panel-heading">
                <div class="col-md-12">
                    <div class="form-group">
                    </div>
                </div>
            </div>
        </form>
        
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
<script src="{{asset('assets/js/guage/loader.js')}}"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['gauge']
    });
    google.charts.setOnLoadCallback();


    function drawGauge(response) {
        var num = 0;
        num = parseInt(response) != NaN ? parseInt(response) : 0;
        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Watts', num]
        ]);
        var options = {
            min: 0,
            max: 9000,
            yellowFrom: 7000,
            yellowTo: 7999,
            redFrom: 8000,
            redTo: 9000,
            minorTicks: 5
        };
        var chart = new google.visualization.Gauge(document.getElementById('gauge_div'));
        chart.draw(data, options);
    }

    function drawGauge2(response1) {
        var num = 0;
        num = parseInt(response1) != NaN ? parseInt(response1) : 0;
        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Voltage', num]
        ]);

        var gaugeOptions2 = {
            min: 0,
            max: 240,
            yellowFrom: 200,
            yellowTo: 230,
            redFrom: 230,
            redTo: 280,
            minorTicks: 5
        };
        var chart = new google.visualization.Gauge(document.getElementById('gauge_div2'));
        chart.draw(data, gaugeOptions2);
    }

    function callback(response, response1) {
        drawGauge(response);
        drawGauge2(response1);
    }

    setInterval(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getPowerInput = $('#power').val();
        var getVoltageInput = $('#voltage').val();
        var powerValue;
        var voltageValue;
        var rID = $('#roomid').val();
        $.ajax({
            url: '/rooms/ShowUI/' + rID, //change manually
            type: "GET",
            dataType: 'json',
            success: function (data) { 
                if(data.power != null || data.voltage != null){
                    powerValue = data.power != null ? data.power: 0;
                    voltageValue = data.voltage != null ? data.voltage: 0;
                }else{
                    powerValue = getPowerInput;
                    voltageValue = getVoltageInput;
                }
                // console.log(data);
                callback(powerValue, voltageValue);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    }, 1000);

</script>


@endsection
