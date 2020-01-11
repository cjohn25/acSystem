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
						<i class="glyphicon glyphicon-th-list"></i>Create Role</p>
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
				<form  action="{{URL::to('/roles')}}" method="POST" class="form-horizontal form-groups-bordered">
					@csrf
				<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">ROLE TYPE</label>
						
						<div class="col-sm-5">
							<input type="text" class="form-control" id="position" name="position" placeholder="example = user"> 
						</div>
					</div>    
				<input type="token" value={{csrf_token()}} name="token" hidden>
					<div class="form-group">
							<div class="col-sm-offset-1 col-sm-5">
									<a href="/roles" class="btn btn-blue btn-icon btn-lg">
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
<br><br><br>
{{-- second layer --}}
@endsection