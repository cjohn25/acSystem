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
        <i class="glyphicon glyphicon-th-list"></i>ROOMS</p>
</div>
<div class="col-md-12">
    <div class="col-md-4">
        <form action="search" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search Name"> <span
                    class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>
    <div>
        <br><br><br>
        <div class="container">
            @if(isset($details))
            <p> The Search results for your query <b> {{ $query }} </b> are :</p>
            <h2>Sample User details</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>
                    <h4>Room Name</h4>
                </th>
                <th>
                    <h4>STATUS</h4>
                </th>
                <th>
                    <h4>ROUTE</h4>
                </th>
                <th>
                    <h4>DEVICE</h4>
                </th> 
                <th>
                    <h4>POWER</h4>
                </th>
                <th>
                    <h4>VOLTAGE</h4>
                </th>
                <th>
                    <h4>Date Created</h4>
                </th>
                <th>
                    <h4>Action</h4>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if(count($roomsData) > 0)
                @foreach ($roomsData as $item)
                <td>
                    <h5>{{$item->roomName}}</h5>
                </td>
                <td>
                    <h5>
                        @if ($item->status==1)
                        <label style="color:green">Inactive</label>
                        @else
                        <label style="color:red">Active</label>
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
                    <h5>{{$item->power}}</h5>
                </td>
                <td>
                    <h5>{{$item->voltage}}</h5>
                </td>
                <td>
                    <h5>{{$item->created_at}}</h5>
                </td>

                <td>
                    <form action="{{ route('rooms.destroy', $item->id)}}" method="POST" class="delete">
                        <a href="rooms/{{$item->id}}/edit" class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            Edit</a>
                        @csrf
                        @method('DELETE')
                        @if(Auth::user()->typeID == 1)
                        <button type="submit" class="btn btn-danger btn-sm btn-icon icon-left">
                            <i class="entypo-cancel"></i>Delete</button>
                        @else
                        @endif
                        <a href="{{route('add.roomShow',['id'=>$item->id])}}"
                            class="btn btn-success btn-sm btn-icon icon-left">
                            <i class="entypo-shareable"></i>
                            SHOW
                        </a>
                        {{-- <a href="rooms/Show/{{$item->room_ID}}" class="btn btn-success btn-sm btn-icon icon-left">
                        <i class="entypo-shareable"></i>
                        Show{{$item->room_ID}}
                        </a> --}}
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <td>
                <h4>No Data Found</h4>
            </td>
            <td>
                <h4>No Data Found</h4>
            </td>
            <td>
                <h4>No Data Found</h4>
            </td>
            <td>
                <h4>No Data Found</h4>
            </td>
            <td>
                <h4>No Data Found</h4>
            </td>
            <td>
                <h4>No Data Found</h4>
            </td>
            <td>
                <h4>No Data Found</h4>
            </td>
            <td>
                <h4>No Data Found</h4>
            </td> 
            @endif
        </tbody>
        <tfoot>
            <tr>
                    <th>
                            <h4>Room Name</h4>
                        </th>
                        <th>
                            <h4>STATUS</h4>
                        </th>
                        <th>
                            <h4>ROUTE</h4>
                        </th>
                        <th>
                            <h4>DEVICE</h4>
                        </th> 
                        <th>
                            <h4>POWER</h4>
                        </th>
                        <th>
                            <h4>VOLTAGE</h4>
                        </th>
                        <th>
                            <h4>Date Created</h4>
                        </th>
                        <th>
                            <h4>Action</h4>
                        </th>
            </tr>
        </tfoot>

    </table>
    {{$roomsData->links()}}
</div>
@if(Auth::user()->typeID == 1)
<div class="col-md-12" style="text-align:right">
    <a href="/rooms/create" class="btn btn-blue btn-icon btn-lg">
        ADD ROOM
        <i class="glyphicon glyphicon-plus">&nbsp;</i>
    </a>
</div>
@else
@endif
<br><br><br>
<script>
    $(document).ready(function (){
        $(".delete").on("submit", function(){
            return confirm("Are you sure?");
        }); 
    });
</script>
@endsection
