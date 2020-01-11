@extends('layouts.index')
@section('content') 
{{-- <p>@if(count($services) > 0)
    <ul>
        @foreach($services as $service)
            <li>{{$service}}</li>
        @endforeach
    </ul>
</p> --}}
    {{-- @if(count($posts1) > 0)
        @foreach ($posts1 as $item)
        <div class="well">
            <h3>{{$item->title}}</h3>  
            <small>Written on{{$item->created_at}}</small>  
        <strong>Body {{$item->bpdy}}</strong>
        </div>    
        @endforeach
        @else
            <p>No Posts Found</p>
    @endif --}}

    <div class="col-sm-3">
	
		<div class="tile-stats tile-red">
			<div class="icon"><i class="entypo-users"></i></div>
		<div class="num" data-start="0" data-end="2" data-postfix="" data-duration="1500" data-delay="0">1</div>
			<h3>Registered Users</h3>
			<p>so far in our blog, and our website.</p>
		</div>
		
	</div>
	
	<div class="col-sm-3">
	
		<div class="tile-stats tile-green">
			<div class="icon"><i class="entypo-chart-bar"></i></div>
			<div class="num" data-start="0" data-end="1" data-postfix="" data-duration="1500" data-delay="600">0</div>
			
			<h3>Daily Visitors</h3>
			<p>this is the average value.</p>
		</div>
		
	</div>
	
	<div class="col-sm-3">
	
		<div class="tile-stats tile-aqua">
			<div class="icon"><i class="entypo-mail"></i></div>
			<div class="num" data-start="0" data-end="23" data-postfix="" data-duration="1500" data-delay="1200">0</div>
			
			<h3>New Messages</h3>
			<p>messages per day.</p>
		</div>
		
    </div>
    
<script type="text/javascript">

jQuery(document).ready(function($) 
{
	// Area Chart
	var area_chart_demo = $("#area-chart-demo");
	
	area_chart_demo.parent().show();
	
	var area_chart = Morris.Area({
		element: 'area-chart-demo',
		data: [
			{ y: '2006', a: 100, b: 90 },
			{ y: '2007', a: 75,  b: 65 },
			{ y: '2008', a: 50,  b: 40 },
			{ y: '2009', a: 75,  b: 65 },
			{ y: '2010', a: 50,  b: 40 },
			{ y: '2011', a: 75,  b: 65 },
			{ y: '2012', a: 100, b: 90 }
		],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Series A', 'Series B'],
		lineColors: ['#303641', '#576277']
	});
	
	area_chart_demo.parent().attr('style', '');
    //sparkling charts
	$('.pageviews').sparkline('html', {type: 'bar', height: '30px', barColor: '#ff6264'} );
	$('.uniquevisitors').sparkline('html', {type: 'bar', height: '30px', barColor: '#00b19d'} );
});
</script>

    <div class="panel-body">
            
        <div class="row">
            <div class="col-sm-8">
        <div class="panel panel-primary" id="charts_env">
		
			<div class="panel-heading">
				<div class="panel-title">Site Stats</div>
				
                    <div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
			</div>
	
			<div class="panel-body">
			
				<div class="tab-content">
					<div class="tab-pane" id="area-chart">							
						<div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
					</div> 
					
				</div>
				
			</div>

			<table class="table table-bordered table-responsive">

				<thead>
					<tr>
						<th width="50%" class="col-padding-1">
							<div class="pull-left">
								<div class="h4 no-margin">Device</div>
							<small>{{$Device}}</small>
							</div>
							<span class="pull-right pageviews">4,3,5,4,5,6,5</span>
							
						</th>
						<th width="50%" class="col-padding-1">
							<div class="pull-left">
								<div class="h4 no-margin">Rooms</div>
							<small>{{$rooms}}</small>
							</div>
							<span class="pull-right uniquevisitors">2,3,5,4,3,4,5</span>
						</th>
					</tr>
				</thead>
				
			</table>
			
		</div></div></div>	
        <div class="tab-content">
            <div class="tab-pane" id="area-chart">							
                <div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
            </div>
        </div>
        
    </div>
@endsection