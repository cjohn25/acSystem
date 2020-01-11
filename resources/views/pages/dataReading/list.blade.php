@extends('layouts.index')
@section('content')
   

    
<br />
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
<div class="form-group">
       
        <div class="panel-title col-md-12">
                <p style="font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8;padding:10px">
                    <i class="entypo-tools"></i>List of Transactions</p>  
            </div>
 
    </div>
    <div  class="col-md-12">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr> 
                    <th> 
                        <h4>DEVICE NAME</h4>
                    </th> 
                    <th> 
                        <h4>ROOM NAME</h4>
                    </th> 
                    <th > 
                        <h4>POWER</h4>
                </th>
                <th> 
                        <h4>STATUS</h4>
                </th>  
                <th>
                        <h4>DATA TRANSACTION</h4>
                </th>
                <th>
                        <h4>USER NAME</h4>
                </th>
                </tr>
            </thead>

            <tbody> <tr>
                    @if(count($device) > 0)
                    @foreach ($device as $item) 
                    <td><h5>{{$item->name}}</h5></td> 
                    <td><h5>{{$item->roomName}}</h5></td>
                    <td><h5>{{$item->power}}</h5></td>
                    <td><h5>
                            @if ($item->status==1)
                            <label style="color:green">ON</label>
                            @else
                            <label style="color:red">OFF</label>
                            @endif 
                        </h5></td>
                    <td><h5>{{$item->created_at}}</h5>
                        </td>
                        <td>
                            <h5>
                                {{$item->Name}}
                            </h5>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <td><h4>No Data Found</h4></td>
                    <td><h4>No Data Found</h4></td> 
                    <td><h4>No Data Found</h4></td>
                    <td><h4>No Data Found</h4></td>  
                    <td><h4>No Data Found</h4></td>  
                    <td><h4>No Data Found</h4></td>  
                    @endif 
            
            </tbody>
            <tfoot>
                    <tr> 
                        <th> 
                            <h4>DEVICE NAME</h4>
                        </th> 
                        <th> 
                            <h4>ROOM NAME</h4>
                        </th> 
                        <th > 
                            <h4>POWER</h4>
                        </th>
                        <th> 
                            <h4>STATUS</h4>
                        </th>  
                        <th>
                        <h4>DATA TRANSACTION</h4>
                        </th>
                        <th>
                            <h4>USER NAME</h4>
                        </th>
                        </tr>
            </tfoot>
        </table>  
        {{$device->links()}}
</div> 
<br><br><br>
@endsection
