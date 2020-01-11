@extends('layouts.index')
@section('content')
   

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if(session()->has('errorMessage'))
<div class="alert alert-danger">
    {{ session()->get('errorMessage') }}
</div>
@endif
<div class="panel-title col-md-12">
            <p style="font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8;padding:10px">
                <i class="entypo-publish"></i>FLOOR</p>  
        </div> 
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr> 
			<th>
                <h4>Name</h4>
            </th>
            <th>
                 <h4>STATUS</h4>
             </th>
             <th>
                <h4>ROOM NAME</h4>
            </th>  
             <th>
                  <h4>Date Created</h4>
             </th> 
			<th><h4>Action</h4></th>
		</tr>
	</thead>
	<tbody> <tr>
            @if(count($rooms) > 0)
            @foreach ($rooms as $item)
            <td> 
                <h5>{{$item->roomName}}</h5>
            </td>
            <td>
                <h5>
                    @if ($item->status==1)
                    <label style="color:green">AVAILABLE</label>
                    @else
                    <label style="color:red">NOT AVAILABLE</label>
                    @endif
                     
            </h5>
            </td>
            <td>
                <h5>{{$item->routeName}}</h5>
            </td>
            <td>
                <h5>{{$item->name}}</h5>
            </td>
            <td>
                <h5>{{$item->min_power}}</h5>
            </td>
            <td>
                <h5>{{$item->max_power}}</h5>
            </td>
            <td>
                <h5>{{$item->created_at}}</h5>
            </td>
            
            <td>
                
                <form action="{{ route('rooms.destroy', $item->room_ID)}}" method="POST" class="delete">
                <a href="rooms/{{$item->room_ID}}/edit" class="btn btn-default btn-sm btn-icon icon-left" >
                        <i class="entypo-pencil"></i>
                        Edit</a>
                        @csrf
                        @method('DELETE')
                      <button type="submit"  class="btn btn-danger btn-sm btn-icon icon-left">
                         <i class="entypo-cancel"></i>Delete</button> 

                      <a href="rooms/{{$item->room_ID}}" class="btn btn-success btn-sm btn-icon icon-left" >
                                <i class="entypo-shareable"></i> 
                             Show
                         </a>
                 </form>
            </td>
            </tr>
            @endforeach
            @else 
                <td><h4>No Data Found</h4></td>
                <td><h4>No Data Found</h4></td> 
                <td><h4>No Data Found</h4></td> 
                <td><h4>No Data Found</h4></td> 
                <td><h4>No Data Found</h4></td> 
            @endif 
     
	</tbody>
	{{-- <tfoot>
		<tr>
                <th><h4>id</h4></th>
                <th><h4>name</h4></th>
                <th><h4>username</h4></th>
                <th><h4>Date Created</h4></th>
                <th><h4>Control</h4></th>
                <th><h4>Action</h4></th>
		</tr>
    </tfoot> --}}

</table>
    
<div class="row" align="right">
				
                
        <ul class="pagination">
            <li><a href="#"><i class="entypo-left-open-mini"></i></a></li>
            <li><a href="#">1</a></li>
            <li class="active"><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li class="disabled"><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><a href="#"><i class="entypo-right-open-mini"></i></a></li>
        </ul>
    </div> 

<div class="col-md-12" style="text-align:right" >
 
        <a href="/floors/create" class="btn btn-blue btn-icon btn-lg">
                ADD FLOOR
                <i class="glyphicon glyphicon-plus">&nbsp;</i> 
        </a>
</div> 
<br><br><br>
<script>
    $(document).read(function (){
        $(".delete").on("submit", function(){
            return confirm("Are you sure?");
        });
    });
</script>
@endsection
