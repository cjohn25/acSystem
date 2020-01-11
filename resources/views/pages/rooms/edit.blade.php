@extends('layouts.index')
@section('content') 
    <div class="panel panel-primary" data-collapsed="0">
		
			<div class="panel-heading">
					<div class="panel-title col-md-12">
						
					<p style="font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8;padding:10px">
						<i class="glyphicon glyphicon-th-list"></i>ROOMS UPDATE</p> 
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
				<form  action="{{ route('rooms.update', $item->id)}}" method="POST" class="form-horizontal form-groups-bordered">
						@csrf
						
						@method('PATCH')
					<div class="form-group">
							<label for="field-1" class="col-sm-3 control-label">Room Name</label>
							
							<div class="col-sm-5">
								<input type="text" class="form-control" id="name" name="name" placeholder="Room 1" value={{ $item->roomName }}> 
							</div>
						</div>  
						<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label">Route</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="rootname" name="rootname" placeholder="room/Add"  value={{ $item->routeName }}> 
								</div>
							</div>   
					
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label">Device</label>
								<div class="col-sm-5"> 
									<select class="form-control" id="device_ID" name="device_ID" required> 
									<option value={{$item->device_ID}} >{{$item->name}}</option>
										@foreach ($allDevice as $data) 
											<option value={{$data->device_ID}}>{{$data->name}}</option>
										@endforeach
									</select>
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
									UPDATE
                                        <i class="glyphicon glyphicon-edit">&nbsp;</i>
                                </button>
					</div>
				</div> 
				</form>
				
			</div>
		</div>
		</div>
@endsection