@extends('layouts.admin')

@section('title', 'View/Manage Listings')
@section('heading', 'View/Manage Listings')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>All Listings</h2>
            <div class="">
                <table class="table table-striped table-bordered table-hover" id="table_listings">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Business Owner </th>
                            <th>Heading </th>
                            <th>Ask Price </th>
                            <th>Date/Time </th>
                            <th>Verification </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $listings = App\Models\Listing::desc('created_at')->get(); ?>
                        @foreach($listings as $i => $listing)
                        <tr>
                            <?php $ids[$i + 1] = $listing->id ?>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $listing->user ? $listing->user->fullName : 'Broken Upload' }}</td>
                            <td>{{ $listing->heading }}</td>
                            <td>
                                <label class="label label-info">{{ $listing->askingPrice }} </label>
                            </td>
                            <td>{{ Carbon::parse($listing->created_at)->diffForHumans() }}</td>
                            <td>
                                @if($listing->verified == 0)
                                <a class="approve btn btn-xs default tableActionButtonMargin" href="javascript:;"> <i class="fa fa-check"></i> Approve</a>
                                @else
                                <a class="unapprove btn btn-xs default tableActionButtonMargin" href="javascript:;"> <i class="fa fa-ban"></i> Unapprove</a>
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

            var table = $('#table_listings');

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

            var tableWrapper = $("#table_listings");

            var nEditing = null;

            var nNew = false;

            table.on('click', '.delete', function (e) {
                e.preventDefault();
                if (confirm("Are you sure to delete this listing ?") == false) {
                    return;
                }
                var nRow = $(this).parents('tr')[0];
                var aData = oTable.fnGetData(nRow);
                var ids = {{ json_encode($ids) }};
                     $.ajax({
                     url: '{{ url("admin/listings/delete/").'/'}}' + ids[aData[0]],
                     method: 'delete',
                     success: function(data){
                toastr['success']("Listing deleted sucessfully", "Success");
                oTable.fnDeleteRow(nRow);
            },
                error: function(data){
                    toastr['error']("Unable to delete listing. Please try again", "Error");
                }
        });
    });

    table.on('click', '.unapprove', function (e) {
        e.preventDefault();

        var nRow = $(this).parents('tr')[0];
        var aData = oTable.fnGetData(nRow);
        var ids = {{ json_encode($ids) }};
             $.ajax(
             {
             url: '{{ url("admin/listings/unapprove/").'/'}}' + ids[aData[0]],
             method: 'post',
             success: function(data)
    {
        toastr['success']("Listing "+ data.heading + " unapproved sucessfully", "Success");
        oTable.fnDeleteRow(nRow);
        window.location.reload();
    },
        error: function(data)
    {
        toastr['error']("Unable to unapprove listing. Please try again", "Error");
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
             url: '{{ url("admin/listings/approve/").'/'}}' + ids[aData[0]],
             method: 'post',
             success: function(data)
    {
        toastr['success']("Listing "+ data.heading+ " approved sucessfully", "Success");
        oTable.fnDeleteRow(nRow);
        window.location.reload();
    },
        error: function(data)
    {
        toastr['error']("Unable to approve listing. Please try again", "Error");
    }
    });
    });

    table.on('click', '.cancel', function (e) {
        e.preventDefault();
        if (nNew) {
            oTable.fnDeleteRow(nEditing);
            nEditing = null;
            nNew = false;
        } else {
            restoreRow(oTable, nEditing);
            nEditing = null;
        }
    });

    table.on('click', '.edit', function (e) {
        e.preventDefault();

        /* Get the row as a parent of the link that was clicked on */
        var nRow = $(this).parents('tr')[0];

        if (nEditing !== null && nEditing != nRow) {
            /* Currently editing - but not this row - restore the old before continuing to edit mode */
            restoreRow(oTable, nEditing);
            editRow(oTable, nRow);
            nEditing = nRow;
        } else if (nEditing == nRow && this.innerHTML == "Save") {
            /* Editing this row and want to save it */
            saveRow(oTable, nEditing);
            nEditing = null;
        } else {
            /* No edit in progress - let's start one */
            editRow(oTable, nRow);
            nEditing = nRow;
        }
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