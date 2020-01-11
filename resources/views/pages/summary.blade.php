@extends('layouts.index')

@section('content')

@if(session()->has('errorMessage'))
<div class="alert alert-danger">
    {{ session()->get('errorMessage') }}
</div>
@endif
<p style="text-align:left;font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8">
    <i class="entypo-gauge"></i> SUMMARY
</p>
{{-- <form action="{{route('showDashboard')}}" method="POST"> --}}

<form id="setupScheduleForm" name="setupScheduleForm" role="form" class="form-horizontal form-groups-bordered">
    {{-- @csrf --}}
    <div class="col-md-12" style="height: 100px">
        <div class="form-group">
            <div class="col-sm-3 input-group">

                <p>Date From:
                    <i class="entypo-calendar"></i>
                    <input type="text" id="datepicker" name="datepicker" class="form-control"></p>
                <select name="selectRoom" id="selectRoom" class="form-control">

                    <option value="">Select Room</option> 
                    {{-- @foreach ($getRoomData as $item)
                <option value="">{{$item}}</option>
                    @endforeach --}}
                </select>
            </div>

            <div class="col-sm-3 input-group">
                <p>Date To:
                    <i class="entypo-calendar"></i>
                    <input type="text" id="datepicker2" name="datepicker2" class="form-control"></p>

                <input type="submit" class="btn btn-primary" value="APPLY">
            </div>

            {{-- <p>Date: <input type="text" id="datepicker"></p> --}}

            <div class="col-sm-6">

                <div class="outer1" style="height: 130px !important; ">
                    <div id="gauge_div" style="float:left;height:100%;"></div>
                    {{-- <div id="gauge_div2" style="float:left;height:100%"></div> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="panel-body">
        <div class="col-md-12">
            <div class="chart-container" style="position: relative; height:80vh; width:75vw">

                <canvas id="myChart"></canvas>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane" id="area-chart">
                <div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
            </div>
        </div>

    </div>
</form>


<link rel="stylesheet" href="{{asset('assets/css/charts/Chart.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/charts/Chart.min.css')}}">
<script src="{{asset('assets/css/charts/Chart.bundle.js')}}"></script>
<script src="{{asset('assets/css/charts/Chart.bundle.min.js')}}"></script>
<script src="{{asset('assets/css/charts/Chart.js')}}"></script>
<script src="{{asset('assets/css/charts/Chart.min.js')}}"></script>
<script src="{{asset('assets/js/guage/loader.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        //     // Area Chart
        //     var sampleTags = [];
        //     var dateDate = [];
        //     var count = 0;
        //     @foreach($dataReading as $dataR)
        //     sampleTags.push('{{ $dataR->id }}');
        //     dateDate.push('{{ $dataR->created_at}}');
        //     count++;
        //     @endforeach

        //     function data(offset) {
        //         var ret = [];
        //         if (count < 8) {
        //             for (var x = 1; x < count; x++) {
        //                 // var v = (offset + x) % 360;
        //                 ret.push({
        //                     y: dateDate[x],
        //                     a: sampleTags[x],
        //                     b: x
        //                 });
        //             }
        //         } else {
        //             for (var x = 1; x < 8; x++) {
        //                 // var v = (offset + x) % 360;
        //                 ret.push({
        //                     y: dateDate[x],
        //                     a: sampleTags[x],
        //                     b: x
        //                 });
        //             }
        //         }
        //         return ret;
        //     }

        //     var area_chart_demo = $("#area-chart-demo");
        //     area_chart_demo.parent().show();
        //     var area_chart = Morris.Area({
        //         element: 'area-chart-demo',
        //         data: data(0),
        //         // [ 
        //         // {
        //         //     y: '2006',
        //         //     a: {{count($dataReading)}},
        //         //    
        //         // },
        //         // {
        //         //     y: '2007',
        //         //     a: 5,
        //         //     b: 2
        //         // },
        //         // {
        //         //     y: '2008',
        //         //     a: 15,
        //         //     b: 5
        //         // },
        //         // {
        //         //     y: '2009',
        //         //     a: 2,
        //         //     b: 5
        //         // },
        //         // {
        //         //     y: '2010',
        //         //     a: 6,
        //         //     b: 22
        //         // },
        //         // {
        //         //     y: '2011',
        //         //     a: 9,
        //         //     b: 1
        //         // },
        //         // {
        //         //     y: '2012',
        //         //     a: 10,
        //         //     b: 5
        //         // }
        //         // ],
        //         xkey: 'y',
        //         ykeys: ['a', 'b'],
        //         labels: ['Series A', 'Series B'],
        //         lineColors: ['#303641', '#576277']
        //     });

        //     area_chart_demo.parent().attr('style', '');
        //     //sparkling charts
        //     $('.pageviews').sparkline('html', {
        //         type: 'bar',
        //         height: '30px',
        //         barColor: '#ff6264'
        //     });
        //     $('.uniquevisitors').sparkline('html', {
        //         type: 'bar',
        //         height: '30px',
        //         barColor: '#00b19d'
        //     });
        // });


        $(function () {
            $("#datepicker").datepicker();
            $("#datepicker2").datepicker();

        });
        //Per hour Average
        var getDataforChart = [];
        var ctx = document.getElementById('myChart');

        function myChartDisplay(data1) {
            console.log(data1);
            // getData.push(data.parseTotalVoltage);  
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    // labels: ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'],
                    labels: data1.collectionDate,
                    datasets: [{
                        label: 'Watts',
                        data: data1.parseTotalVoltage != '' ? data1.parseTotalVoltage : 0,
                        // data:getDataforChart,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        // [
                        //     'rgba(255, 99, 132, 0.2)',
                        //     'rgba(54, 162, 235, 0.2)',
                        //     'rgba(255, 206, 86, 0.2)',
                        //     'rgba(75, 192, 192, 0.2)',
                        //     'rgba(153, 102, 255, 0.2)',
                        //     'rgba(255, 159, 64, 0.2)'
                        // ],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        // [
                        //     'rgba(255, 99, 132, 1)',
                        //     'rgba(54, 162, 235, 1)',
                        //     'rgba(255, 206, 86, 1)',
                        //     'rgba(75, 192, 192, 1)',
                        //     'rgba(153, 102, 255, 1)',
                        //     'rgba(255, 159, 64, 1)'
                        // ],
                        borderWidth: 4
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
        //Weekly Average

        function showChart() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // var rID = $('#roomid').val();
            $.ajax({
                url: '/summary/data/',
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }


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

        // function drawGauge2(response1) {
        //     var num = 0;
        //     num = parseInt(response1) != NaN ? parseInt(response1) : 0;
        //     var data = google.visualization.arrayToDataTable([
        //         ['Label', 'Value'],
        //         ['Voltage', num]
        //     ]);

        //     var gaugeOptions2 = {
        //         min: 0,
        //         max: 240,
        //         yellowFrom: 200,
        //         yellowTo: 230,
        //         redFrom: 230,
        //         redTo: 280,
        //         minorTicks: 5
        //     };
        //     var chart = new google.visualization.Gauge(document.getElementById('gauge_div2'));
        //     chart.draw(data, gaugeOptions2);
        // }
        var getTotalVoltage = 0;

        var getTotalTotalWatts = 0;
        setInterval(function () {
            callback(getTotalTotalWatts, getTotalVoltage);
        }, 5000);


        function callback(response, response1) {
            drawGauge(response);
            // drawGauge2(response1);
        }
        getChart();

        function getChart() {
            
        var selOpts="";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var getDataRoom = [];
            var getDataRoomSet = "";
            $.ajax({
                url: '/summary/data',
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    myChartDisplay(data);
                    getTotalVoltage = data.TotalVoltage;
                    getTotalTotalWatts = data.TotalWatts;

                    for (var i = 0; i < data.getRoomData.length; i++) {
                        // getDataRoom.push(data.getRoomData[i]);
                        
                    selOpts += "<option value='" + data.getRoomData[i]['id'] + "'>" + data.getRoomData[i]['roomName'] + "</option>";
                    } 
                    // console.log(selOpts);  
                    $('#selectRoom').append(selOpts);
                    // callback(data.TotalVoltage, data.TotalWatts);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }


        $('#setupScheduleForm').on('submit', function (e) {

            e.preventDefault();

            var form_data = $(this).serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: form_data,
                url: '/summary/dataPost',
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    myChartDisplay(data);
        // $getWatts->parseTotalVoltage = $collection1;
        //             for(var x= 0 ; x< data.){

        //             }
                    getTotalVoltage = data.TotalVoltage;
                    getTotalTotalWatts = data.TotalWatts;
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });

</script>
@endsection
