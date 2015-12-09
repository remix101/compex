@extends('layouts.admin')
@section('title', 'Seller Accounts')
@section('heading', 'Seller Accounts')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <table id="table_users" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> </th>
                            <th>User Name</th>
                            <th>Account Type</th>
                            <th>Email</th>
                            <th>Personal Phone</th>
                            <th>Work Phone</th>
                            <th>No of Listings</th>
                            <th>Join Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $ids = []; ?>
                        @foreach(App\Models\Seller::desc('created_at')->get() as $i => $b)
                        <tr {{ $b->user->status == Config::get('constants.USER_STATUS_BANNED') ? 'style="background-color:#ecc"' : '' }}>
                            <?php $ids[$i + 1] = $b->user->id ?>
                            <td>{{$i + 1}}</td>
                            <td>{{ $b->user->fullName }}</td>
                            <td>{{ ucwords($b->user->role->name) }}</td>
                            <td>{{ $b->user->email }}</td>
                            <td>{{ $b->user->phone_number }}</td>
                            <td>{{ $b->work_phone }}</td>
                            <td>{{ $b->listings->count() }}</td>
                            <td>{{ Carbon::parse($b->created_at)->diffForHumans() }}</td>
                            <td>
                                @if($b->user->status == Config::get('constants.USER_STATUS_BANNED'))
                                <a class="unban btn btn-xs default tableActionButtonMargin" href="javascript:;"> <i class="fa fa-exclamation-circle"></i> Unban</a>
                                @elseif($b->user->status == Config::get('constants.USER_STATUS_PENDING'))
                                <a class="approve btn btn-xs default tableActionButtonMargin" href="javascript:;"> <i class="fa fa-check"></i> Approve</a>
                                @else
                                <a class="ban btn btn-xs default tableActionButtonMargin" href="javascript:;"> <i class="fa fa-ban"></i> Ban</a>
                                @endif
                                <a class="delete btn btn-xs red tableActionButtonMargin" href="javascript:;"> <i class="fa fa-trash-o"></i> Delete </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@stop

@section('footerscripts')

{{ HTML::script("assets/js/datatables/media/js/jquery.dataTables.min.js") }}
{{ HTML::script("assets/js/datatables/extensions/TableTools/js/dataTables.tableTools.min.js") }}
{{ HTML::script("assets/js/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js") }}
{{ HTML::script("assets/js/datatables/extensions/Scroller/js/dataTables.scroller.min.js") }}
{{ HTML::script("assets/js/datatables/dataTables.bootstrap.js") }}

{{ HTML::script('assets/js/bootstrap-toastr/toastr.min.js') }}
{{ HTML::style('assets/js/bootstrap-toastr/toastr.min.css') }}

<script type="text/javascript">

    var TableEditable = function () {

        var editTD = "";

        var handleTable = function () {
            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }
                oTable.fnDraw();
            }


            var table = $('#table_users');

            var oTable = table.dataTable({

                "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12 text-right'f>r>t<'row'<'col-md-8 col-sm-12'p><'col-md-4 col-sm-12 text-right'i>>",

                "lengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 10,

                "language": {
                    "lengthMenu": " _MENU_ records"
                },
                "columnDefs": [{ // set default column settings
                    'orderable': true,
                    'targets': [0]
                }, {
                    "searchable": true,
                    "targets": [0]
                }],
                "order": [
                    [0, "asc"]
                ] // set first column as a default sort by asc
            });

            var tableWrapper = $("#table_users");

            table.on('click', '.delete', function (e) {
                e.preventDefault();
                if (confirm("Are you sure to delete this user ?") == false) {
                    return;
                }
                var nRow = $(this).parents('tr')[0];
                var aData = oTable.fnGetData(nRow);
                var ids = {{ json_encode($ids) }};
                     console.log(oTable);
            $.ajax(
                {
                    url: '{{ url("admin/users/delete/").'/'}}' + ids[aData[0]],
                    method: 'delete',
                    success: function(data)
                    {
                        toastr['success']("User deleted sucessfully", "Success");
                        oTable.fnDeleteRow(nRow);
                    },
                    error: function(data)
                    {
                        toastr['error']("Unable to delete user. Please try again", "Error");
                    }
                });
        });

        table.on('click', '.ban', function (e) {
            e.preventDefault();

            if (confirm("Are you sure to ban this user ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            var aData = oTable.fnGetData(nRow);
            var ids = {{ json_encode($ids) }};
                 $.ajax(
                 {
                 url: '{{ url("admin/users/ban/").'/'}}' + ids[aData[0]],
                 method: 'post',
                 success: function(data)
        {
            toastr['success']("User "+ data.first_name+ " banned sucessfully", "Success");
            oTable.fnDeleteRow(nRow);
            window.location.reload();
        },
            error: function(data)
        {
            toastr['error']("Unable to ban user. Please try again", "Error");
        }
    });
    });

    table.on('click', '.unban', function (e) {
        e.preventDefault();

        var nRow = $(this).parents('tr')[0];
        var aData = oTable.fnGetData(nRow);
        var ids = {{ json_encode($ids) }};
             $.ajax(
             {
             url: '{{ url("admin/users/unban/").'/'}}' + ids[aData[0]],
             method: 'post',
             success: function(data)
    {
        toastr['success']("User "+ data.first_name+ " unbanned sucessfully", "Success");
        oTable.fnDeleteRow(nRow);
        window.location.reload();
    },
        error: function(data)
    {
        toastr['error']("Unable to unban user. Please try again", "Error");
    }
    });
    });

    table.on('click', '.approve', function (e) {
        e.preventDefault();

        var nRow = $(this).parents('tr')[0];
        var aData = oTable.fnGetData(nRow);
        var ids = {{ json_encode($ids) }};
             $.ajax(
             {
             url: '{{ url("admin/users/unban/").'/'}}' + ids[aData[0]],
             method: 'post',
             success: function(data)
    {
        toastr['success']("User "+ data.first_name+ " approved sucessfully", "Success");
        oTable.fnDeleteRow(nRow);
        window.location.reload();
    },
        error: function(data)
    {
        toastr['error']("Unable to approve user. Please try again", "Error");
    }
    });
    });

    }

    return {

        //main function to initiate the module
        init: function () {
            handleTable();
        }

    };
    }();

    jQuery(document).ready(function(){
        TableEditable.init();
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-top-right",
            "showDuration": "3000",
            "hideDuration": "1000",
            "timeOut": "7000",
            "extendedTimeOut": "3000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    });
</script>


@stop