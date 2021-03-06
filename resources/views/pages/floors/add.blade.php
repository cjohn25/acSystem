@extends('layouts.index')
@section('content')

<br />
<div class="row">
	<div class="col-md-12">
		
		<div class="panel panel-primary" data-collapsed="0">
		
			<div class="panel-heading">
				<div class="panel-title">
					<h3><i class="entypo-publish"></i>Add Floor</h3> Add Floor
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
				<form  action="{{URL::to('/floors')}}" method="POST" class="form-horizontal form-groups-bordered">
					@csrf
				<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">
								<strong> 
							Name:
								</strong> 
						</label>
						
						<div class="col-sm-5">
							<input type="text" class="form-control" id="floorName" name="floorName" placeholder="floor1"> 
						</div>
					</div>   
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><strong>SELECT ROOM:</strong></label>
						<div class="col-sm-5"> 
							<select class="form-control" name="selectRoom" id="selectRoom" required>
								@foreach($rooms as $item) 
								<option value="{{$item->room_ID}}">{{$item->roomName}}</option>
								@endforeach
							</select>
						</div>
								{{-- <div class="col-sm-1"> 
										<br><br>   
										@foreach($rooms as $item)  
										<div class="input-group"> 
										<input type="checkbox" class="checked form-control" name="services" value="{{ $item->room_ID }}" id="{{ $item->room_ID }}" name="{{$item->room_ID}}" /> 
										
												<span class="input-group-btn"> 
														<label><strong><h4>{{$item->roomName}}</h4></strong></label> 
													</span>
											</div>
										<label class="cb-wrapper"> 
											</label> 
										@endforeach 
								</div> --}}
						
					</div>   
				<input type="token" value={{csrf_token()}} name="token" hidden>
					<div class="form-group">
							<div class="col-sm-offset-1 col-sm-5">
									<a href="/floor" class="btn btn-blue btn-icon btn-lg">
											BACK
											<i class="glyphicon glyphicon-arrow-left">&nbsp;</i> 
									</a>
							</div>
						<div class="col-sm-offset-2 col-sm-3">
                                <button type="submit" class="btn btn-blue btn-icon btn-lg">
                                        CREATE
										<i class="glyphicon glyphicon-plus">&nbsp;</i> 
                                </button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<br><br><br>
{{-- second layer --}}
@endsection