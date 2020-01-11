@extends('layouts.index')
@section('content')

<br>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
    <div class="panel panel-primary" data-collapsed="0">
		
			<div class="panel-heading"> 
				<div class="panel-title col-md-12">
					<p
						style="font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8;padding:10px">
						Update Account<i class="entypo-user-add"></i>
				</div>
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
					<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
				</div>
			</div>
			<div class="panel-body"> 
				<form  action="{{route('accounts.update',  $item->id)}}" method="POST" class="form-horizontal form-groups-bordered">
					@csrf
					@method('PATCH')
				<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" >Name</label>
						
						<div class="col-sm-5">
						<input type="text" class="form-control" id="name" name="name" placeholder="Cruz" value="{{$item->name}}"> 
						</div>
					</div> 
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Username</label>
                            
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
									<input type="text" class="form-control" placeholder="emaiol@mail.com"  name="email" id="email" value="{{$item->email}}">
								</div>
								 
                            </div>
                        </div> 
					
					 
					<div class="form-group">
						<label class="col-sm-3 control-label">Position</label>
						
						<div class="col-sm-5">
							<select class="form-control" name="typeID" id="typeID" required>
								<option value=""></option>
								@foreach($roles as $rolesItem)
								<option value="{{$rolesItem->typeID}}">{{$rolesItem->position}}</option>
                                @endforeach 
							</select>
						</div>
					</div>
				<input type="token" value={{csrf_token()}} name="token" hidden>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-5">
                                <button type="submit" class="btn btn-blue btn-icon btn-lg">
										UPDATE
                                        <i class="glyphicon glyphicon-edit">&nbsp;</i>
                                </button>
						</div>
					</div>
				</form>
				
			</div>
		
		</div></div>
		
	</div>
</div>
@endsection