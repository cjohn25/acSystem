@extends('layouts.index')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('assets/js/dataTable/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/js/dataTable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<script src="{{asset('assets/js/dataTable/jquery.dataTables.min.js')}}"></script>
<div class="panel-title">
    <p style="font-weight:bolder;font-size:20px;background-color:#303641;color:#c8c8c8;padding:10px">
        <i class="glyphicon glyphicon-th-list"></i>
        TIME SCHEDULE SETUP &nbsp;
    </p>
</div>
<div class="col-md-12 panel panel-primary" data-collapsed="0">
    <form id="setupScheduleForm" name="setupScheduleForm" role="form" class="form-horizontal form-groups-bordered">
        <div class="panel-heading">
            <label for="field-1" class="col-sm-3 control-label">
            </label>
        </div>

        <ul id="errors" name='errors'>

            {{-- <div class="alert alert-danger">
            
        </div> --}}
        </ul><br />

        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        {{-- left column --}}
        <div class="col-md-6 panel-body">

            <div class="col-md-12">
                {{-- <div class="input-group">
                    <label class="control-label">Room Name:</label>
                    <div class="col-sm-12">
                        <select name="roomID" id="roomID" class="form-control action" required>
                            <option value="">-----------Select-----------</option>
                        </select>
                    </div>
                </div> --}}
                <label class="control-label"><strong>
                        <h3>Select Room</h3>
                    </strong></label>
                <div class="panel-body">
                    <div class="form-group">
                        <select multiple class="form-control " id="multiRooms" name="multiRooms">
                            {{--                             
                            <option value="Audi">Audi</option>
                            <option value="BMW" selected="selected">BMW</option>
                            <option value="Buick">Buick</option> --}}
                            {{-- <option value="elem_1">elem 1</option>
                            <option value="elem_2">elem 2</option>
                            <option value="elem_3">elem 3</option>
                            <option value="elem_4">elem 4</option>
                            <option value="elem_5">elem 5</option>
                            <option value="elem_6">elem 6</option>
                            <option value="elem_7">elem 7</option>
                            <option value="elem_8" selected>Selected element</option>
                            <option value="elem_9" selected>Selected element 2</option> --}}
                        </select>
                    </div>
                    {{-- <a href="#" class="btn btn-primary" id="refresh" name="refresh"></a> --}}
                    <input type="hidden" name="hidden_rooms" id="hidden_rooms" />
                </div>
                <div class="col-md-12">
                    <br>
                    <label class="col-sm-2 control-label">Days Of The Week:</label>
                    <div class="col-sm-10">
                        <ul class="icheck-list" style="list-style-type:none !important;" id="checkDay">
                            <li class="input-group col-sm-1 selected">
                                <label>Mon</label>
                                <input type="checkbox" class="checkDay" name="checkDay">
                            </li>
                            <li class="input-group col-sm-1 selected">
                                <label>Tue</label>
                                <input type="checkbox" class="checkDay" name="checkDay">
                            </li>
                            <li class="input-group col-sm-1 selected">
                                <label>Wed</label>
                                <input type="checkbox" class="checkDay" name="checkDay">
                            </li>
                            <li class="input-group col-sm-1 selected">
                                <label>Thu</label>
                                <input type="checkbox" class="checkDay" name="checkDay">
                            </li>
                            <li class="input-group col-sm-1 selected">
                                <label>Fri</label>
                                <input type="checkbox" class="checkDay" name="checkDay">
                            </li>
                            <li class="input-group col-sm-1 selected">
                                <label>Sat</label>
                                <input type="checkbox" class="checkDay" name="checkDay">
                            </li>
                            <li class="input-group col-sm-1 selected">
                                <label>Sun</label>
                                <input type="checkbox" class="checkDay" name="checkDay">
                            </li>
                        </ul>
                    </div>

                </div>

                <br><br>
                <br><br><br><br>

                <div class="col-md-6">
                    <div class="input-group">
                        <label class="col-sm-2 control-label">Time In:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" data-template="dropdown"
                                    data-show-seconds="true" data-default-time="7:25 AM" data-show-meridian="true"
                                    data-minute-step="5" data-second-step="5" id="timeIn" name="timeIn">
                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-clock"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <label class="col-sm-3 control-label">Time Out:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" data-template="dropdown"
                                    data-show-seconds="true" data-default-time="7:25 AM" data-show-meridian="true"
                                    data-minute-step="5" data-second-step="5" id="timeOut" name="timeOut">
                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-clock"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <br><br>
                    <button type="submit" class="btn btn-success" id="submit" name="submit">Save changes</button>
                </div>
                <div class="col-md-6" style="text-align:left">
                    <br><br>
                    <a href="/rooms" class="btn btn-blue">
                        BACK
                        <i class="glyphicon glyphicon-arrow-left">&nbsp;</i>
                    </a>
                </div>
            </div>
        </div>
        {{-- End Left Column --}}
        {{-- Right Column --}}
        <div class="col-md-5 panel-body">
            <table class="table table-bordered table-striped" id="data_table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>
                            Room Name
                        </th>
                        <th>
                            Device Name
                        </th>
                        <th>
                            In
                        </th>
                        <th>
                            Out
                        </th>
                        <th>
                            Days
                        </th>
                        <th>
                            action
                        </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
        {{-- End Right Column --}}
    </form>




    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel"
        aria-hidden="true">
        <form id="addRoleForm" class="form-horizontal form-groups-bordered">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <center>
                            <h3 class="modal-title" id="roleModalLabel">TIME SCHEDULE UPDATE</h3>
                        </center>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="margin-top:-20px">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="schedID" name="schedID" disabled>
                            <label for="field-1" class="col-sm-3 control-label"><strong>Schedule ID</strong></label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="roomName" name="roomName" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                                <div class="col-md-12">
                                        <br>
                                        <label class="col-sm-2 control-label">Days Of The Week:</label>
                                        <div class="col-sm-10">
                                            <ul class="icheck-list" style="list-style-type:none !important;" id="checkDayModal">
                                                <li class="input-group col-sm-1 selected">
                                                    <label>Mon</label>
                                                    <input type="checkbox" class="checkDayModal" name="checkDayModal">
                                                </li>
                                                <li class="input-group col-sm-1 selected">
                                                    <label>Tue</label>
                                                    <input type="checkbox" class="checkDayModal" name="checkDayModal">
                                                </li>
                                                <li class="input-group col-sm-1 selected">
                                                    <label>Wed</label>
                                                    <input type="checkbox" class="checkDayModal" name="checkDayModal">
                                                </li>
                                                <li class="input-group col-sm-1 selected">
                                                    <label>Thu</label>
                                                    <input type="checkbox" class="checkDayModal" name="checkDayModal">
                                                </li>
                                                <li class="input-group col-sm-1 selected">
                                                    <label>Fri</label>
                                                    <input type="checkbox" class="checkDayModal" name="checkDayModal">
                                                </li>
                                                <li class="input-group col-sm-1 selected">
                                                    <label>Sat</label>
                                                    <input type="checkbox" class="checkDayModal" name="checkDayModal">
                                                </li>
                                                <li class="input-group col-sm-1 selected">
                                                    <label>Sun</label>
                                                    <input type="checkbox" class="checkDayModal" name="checkDayModal">
                                                </li>
                                            </ul>
                                        </div>
                    
                                    </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><strong>Time In:</strong></label>

                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker" data-template="dropdown"
                                        data-show-seconds="true" data-default-time="7:25 AM" data-show-meridian="true"
                                        data-minute-step="5" data-second-step="5" id="timeIn1" name="timeIn1">
                                    <div class="input-group-addon">
                                        <a href="#"><i class="entypo-clock"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label"><strong>Time Out:</strong></label>
    
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" data-template="dropdown"
                                            data-show-seconds="true" data-default-time="7:25 AM" data-show-meridian="true"
                                            data-minute-step="5" data-second-step="5" id="timeOut1" name="timeOut1">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-clock"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <input type="token" value={{csrf_token()}} name="token" hidden>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-primary">
                            UPDATE
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

{{-- <div align="center" class="col-md-12">
    <a href="/rooms" class="btn btn-blue btn-icon btn-lg">
        BACK
        <i class="glyphicon glyphicon-arrow-left">&nbsp;</i>
    </a>
</div> --}}
<br>

<script type="text/javascript">
    $(function () {

        //initialize the element

        $('#multiRooms').lwMultiSelect({
            addAllText: "Select All",
            removeAllText: "Remove All",
            selectedLabel: "Values accepted",

        });

        //initialize element of days
        var daysCheck = false;;
        //initialize element of rooms
        var roomCheck = false;
        var selOpts = "";
        getTable();

        function getTable() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#data_table').DataTable({
                processing: false,
                serverSide: false,
                ajax: "{{ route('rooms.getSetupSchedule') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'roomName',
                        name: 'roomName'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'time_in',
                        name: 'time_in'
                    },
                    {
                        data: 'time_out',
                        name: 'time_out'
                    },
                    {
                        data: 'set_day',
                        name: 'set_day'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        }
        getRoom();
        //get rooms for select room name
        function getRoom() {
            $.ajax({
                url: '/roomInstance',
                type: "GET",
                dataType: 'json',
                success: function (data) {

                    var set = "";
                    var deviceOpts = "";
                    for (i = 0; i < data.length; i++) {
                        var getRoomId = data[i].id;
                        var getRoomName = data[i].roomName;
                        var getDeviceName = data[i].name;
                        var getDeviceID = data[i].device_ID;
                        selOpts += "<option value='" + getRoomId + "'>" + getRoomName + "</option>";
                        set += "<li id='" + getRoomId + "' value='test'>" + getRoomName + "</li>";
                        // deviceOpts += "<option value='" + getDeviceID + "'>" + getDeviceName +
                        //     "</option>";

                        $('#multiRooms').html(selOpts);
                        $('#multiRooms').data('plugin_lwMultiSelect').updateList();

                    }
                    // $('#roomID').append(selOpts);
                    // $('#deviceID').append(deviceOpts);
                    console.log(data);

                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
        $('.checkDay').on('click', function (e) {
            // daysCheck = true; 
            var checkWD = $('.checkDay').is(':checked');
            daysCheck = checkWD;
        });
        //save instance for schedule
        var getData = "";
        $('.lwms-list').on('click', function () {
            $('#hidden_rooms').val($('#multiRooms').val());
            getData = $('#multiRooms').val();
            if (getData == null) {
                $('#multiRooms').html(selOpts);
                $('#multiRooms').data('plugin_lwMultiSelect').updateList();
            }


            roomCheck = $('#hidden_rooms').val() == '' ? false : true;
        });
        $('.lwms-addall').hide();
        $('#setupScheduleForm').on('submit', function (e) {
            e.preventDefault();

            if (daysCheck == false) {
                alert('Weekdays selection cannot be empty');
            } else if (roomCheck == false) {

                alert('rooms cannot be empty');
            } else {
                var form_data = $(this).serialize();
                var getData = [];
                var cboxes = document.getElementsByName('checkDay');
                for (var i = 0; i < cboxes.length; i++) {
                    getData.push(cboxes[i].checked ? 1 : 0);
                }
                $.ajax({
                    data: form_data + ' & ' + 'days=' + getData,
                    url: "/setTime/calendar",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        // location.reload();
                    },
                    error: function (data) {
                        var getErrorMessage = "";
                        var getLength = data.readyState;
                        // var getErrorMessage = data.responseJSON.errors;
                        // console.log(data.responseJSON.errors); 
                        console.log('Error:', data);
                    }
                });
            }
        }); 
 
        $('#addRoleForm').on('submit', function (e) {
            e.preventDefault();
            alert('testing');
            // $.ajax({
            //     type: "POST",
            //     url: "role/Addroles",
            //     data: $('#addRoleForm').serialize(),
            //     success: function (response) {
            //         $('#roleModal').modal('hide')
            //         location.reload();
            //         alert('Data Saved!');
            //     },
            //     error: function (error) {

            //         $.each(error.responseJSON.errors, function (k, v) {
            //             // $('#parseMessage').val(v);
            //             $('#parseMessage').append(
            //                 '<li><div class="boxgrid captionfull">' + v +
            //                 '"</div></li>');
            //         });

            //         $('#roleModal').modal('hide')
            //         $('#errorMessage').show();
            //     }
            // });
        });
    });

</script>
@endsection
