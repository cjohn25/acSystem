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
            <i class="glyphicon glyphicon-user"></i>LIST OF ROLES</p>
    </div>

</div>
<div class="col-md-6">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th class="col-md-5">
                    <h4>Role</h4>
                </th>
                <th>
                    <h4>Action</h4>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if(count($dataRoles) > 0)
                @foreach ($dataRoles as $item)
                <td>
                    <h5>{{$item->position}}</h5>
                </td>
                <td>
                    <form action="{{ route('roles.destroy', $item->typeID)}}" method="post" class="delete">
                        <a href="roles/{{$item->typeID}}/edit" class="btn btn-default btn-sm btn-icon icon-left">
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
            @endif

        </tbody>
        <tfoot>
		<tr>
                <th class="col-md-5">
                        <h4>Role</h4>
                    </th>
                    <th>
                        <h4>Action</h4>
                    </th>
		</tr>
	</tfoot>
    </table> 
    {{$dataRoles->links()}}
</div>

<div class="col-md-6 panel-primary">
<div class="col-md-12" style="text-align:right"> 
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#roleModal">
        SHOW ROLE FORM
    </button>
    
    <div class="alert alert-danger" id="errorMessage">
            <ul id="parseMessage">
            </ul>
        </div>
        <br />
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <form id="addRoleForm" class="form-horizontal form-groups-bordered">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                    <h3 class="modal-title" id="roleModalLabel">ADD ROLES</h3>
                    </center>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><strong>ROLE TYPE</strong></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="position" name="position"
                                placeholder="example = user">
                        </div>
                    </div>
                    <input type="token" value={{csrf_token()}} name="token" hidden> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-secondary">
                        ADD
                        <i class="entypo-list-add">&nbsp;</i>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
</div></div>

<br><br><br>
<script>
    $(document).ready(function () {
        
        $('#errorMessage').hide();
        $('#addRoleForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "role/Addroles",
                data: $('#addRoleForm').serialize(),
                success: function (response) {
                    $('#roleModal').modal('hide')
                    location.reload();
                    alert('Data Saved!');
                },
                error: function (error) {

                    $.each(error.responseJSON.errors, function (k, v) {
                        // $('#parseMessage').val(v);
                        $('#parseMessage').append(
                            '<li><div class="boxgrid captionfull">' + v +
                            '"</div></li>');
                    });

                    $('#roleModal').modal('hide')
                    $('#errorMessage').show();
                }
            });
        });
 
    $(".delete").on("submit", function(){
        return confirm("Are you sure?");
    }); 
    });

</script>
@endsection
