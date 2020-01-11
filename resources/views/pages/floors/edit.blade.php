@extends('layouts.index')
@section('content') 
    <div class="panel panel-primary" data-collapsed="0">
		
			<div class="panel-heading">
					<div class="panel-title">
							<h3><i class="entypo-publish"></i>FLOOR</h3> UPDATING
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
				<form  action="{{ route('floor.update', $item->room_ID)}}" method="POST" class="form-horizontal form-groups-bordered">
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
									<label for="field-1" class="col-sm-3 control-label">availability</label>
									<div class="col-sm-5">
											<select class="form-control" name="typeID" id="typeID" required>
													<option value={{$item->status}}>
															@if ($item->status==1)
															<label style="color:green">AVAILABLE</label>
															@else
															<label style="color:green">NOT AVAILABLE</label>
															@endif
													</option>
													<option value="1">AVAILABLE</option>
													<option value="2">NOT AVAILABLE</option>
													
												<option value="{{$item->typeID}}">{{$item->position}}</option>
												</select>
										{{-- <input type="text" class="form-control" id="availability" name="availability" placeholder="room/Add"  value={{ $item->availability }}>  --}}
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
                                        <i class="glyphicon-edit"></i>
                                </button>
					</div>
				</div> 
				</form>
				
			</div>
		
		</div>
@endsection