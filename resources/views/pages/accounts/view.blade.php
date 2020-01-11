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
            <i class="glyphicon glyphicon-user"></i>ACCOUNTS</p>
    </div>

    <div class="col-md-12">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th>
                        <h4>id</h4>
                    </th>
                    <th>
                        <h4>name</h4>
                    </th>
                    <th>
                        <h4>username</h4>
                    </th>
                    <th>
                        <h4>Date Created</h4>
                    </th>
                    <th>
                        <h4>Role</h4>
                    </th>
                    <th>
                        <h4>Action</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if(count($Allaccounts) > 0)
                    @foreach ($Allaccounts as $item)
                    <td>
                        <h5><strong>{{$item->id}}</strong></h5>
                    </td>
                    <td>
                        <h5>{{$item->name}}</h5>
                    </td>
                    <td>
                        <h5>{{$item->email}}</h5>
                    </td>
                    <td>
                        <h5>{{$item->created_at}}</h5>
                    </td>
                    <td>
                        <h5>
                            {{$item->position}}</h5>
                    </td>
                    <td>
                        <form action="{{ route('accounts.destroy', $item->id)}}" method="post" class="delete">
                            <a href="accounts/{{$item->id}}/edit" class="btn btn-default btn-sm btn-icon icon-left">
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
                <td>
                    <h4>No Data Found</h4>
                </td>
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
    </div>
</div>
<div class="col-md-12" style="text-align:right">
    <a href="/accounts/create" class="btn btn-blue btn-icon btn-lg">
        ADD ACCOUNTS
        <i class="glyphicon glyphicon-plus">&nbsp;</i>
    </a>
</div>
<br><br><br>

<script>
    $(document).ready(function(){
        $(".delete").on("submit", function(){
            return confirm("Are you sure?");
        });
    });
</script>
@endsection
