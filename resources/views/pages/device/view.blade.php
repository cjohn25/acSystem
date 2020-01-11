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
            <i class="entypo-tools"></i>LIST OF DEVICE</p>
    </div>

</div>
<div class="col-md-12">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>
                    <h4>DEVICE NAME</h4>
                </th>
                <th>
                    <h4>DESC</h4>
                </th>
                <th>
                    <h4>MAC ADDRESS</h4>
                </th>
                <th>
                    <h4>LOCATION</h4>
                </th>
                <th>
                    <h4>Action</h4>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if(count($device) > 0)
                @foreach ($device as $item)
                <td>
                    <h5>{{$item->name}}</h5>
                </td>
                <td>
                    <h5>{{$item->desc}}</h5>
                </td>
                <td>
                    <h5>{{$item->mac_add}}</h5>
                </td>
                <td>
                    <h5>{{$item->location}}</h5>
                </td>
                <td>
                    <form action="{{ route('device.destroy', $item->device_ID)}}" method="post" class="delete">
                        <a href="device/{{$item->device_ID}}/edit" class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-pencil"></i>
                            Edit
                        </a>
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm btn-icon icon-left" type="submit">
                            <i class="entypo-cancel"></i>Delete</button>

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
            @endif

        </tbody>
        <tfoot>

            <tr>
                <th>
                    <h4>DEVICE NAME</h4>
                </th>
                <th>
                    <h4>DESC</h4>
                </th>
                <th>
                    <h4>MAC ADDRESS</h4>
                </th>
                <th>
                    <h4>LOCATION</h4>
                </th>
                <th>
                    <h4>Action</h4>
                </th>
            </tr>
        </tfoot>
    </table>
    {{$device->links()}}
</div>
<div class="col-md-12" style="text-align:right">
    <a href="/device/create" class="btn btn-blue btn-icon btn-lg">
        ADD DEVICE
        <i class="glyphicon glyphicon-plus">&nbsp;</i>
    </a>
</div>
<br><br><br>
<script>
    $(document).ready(function(){
        $(".delete").on("submit", function (){
            return confirm("Are you sure?");
        });
    });
</script>
@endsection
