@extends('layouts.broker')

@section('title', 'Businesses Pending Approval')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Businesses Pending Approval</h3>
            <a class="btn green pull-right" href="{{ url('sell') }}">
                <i class="fa fa-plus"></i> New Listing
            </a>
        </div>
        <div class="col-md-12">
            @if(isset($errors))
            @foreach ($errors->all() as $e)
            <div class="alert alert-dismissible alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                {{ $e }}
            </div>
            @endforeach
            @endif
            @if(Session::has('success'))
            <div class="alert alert-dismissible alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                {{ Session::get('success') }}
            </div>
            @endif
            <div class="">
                <table class="table table-responsive responsive able-striped table-hover table-bordered" id="table_listings">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fa fa-edit"></i> Heading</th>
                            <th><i class="fa fa-bars"></i> Category</th>
                            <th><i class="fa fa-question"></i> Asking Price</th>
                            <th><i class="fa fa-info-circle"></i> Property Type</th>
                            <th><i class="fa fa-bar-chart"></i> Views</th>
                            <th><i class="fa fa-info-circle"></i> Status</th>
                            <th>  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $ids = array(); ?>
                        @foreach($user->broker->listings()->verified()->get() as $i => $l)
                        <tr>
                            <?php $ids[$i + 1] = $l->id ?>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ Str::limit($l->heading, 40) }}</td>
                            <td>{{ $l->categoryName }}</td>
                            <td>{{ $l->askingPrice }}</td>
                            <td>{{ $l->status }}</td>
                            <td>{{ $l->views }}</td>
                            <td>{{ $l->verified ? 'Verified' : 'Pending' }}</td>
                            <td>
                                <span>
                                    <a class="btn btn-xs default" href="{{ url('broker/listings/preview/'.$l->id) }}"><i class="fa fa-eye"></i> Preview</a>
                                    <a class="btn btn-xs default" href="{{ url('broker/listings/edit/'.$l->id) }}"> <i class="fa fa-ban"></i> Edit</a><a class="delete btn btn-xs red" href="javascript:;"> <i class="fa fa-trash-o"></i> Delete </a>
                                </span>
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
{{ HTML::style("assets/js/datatables/dataTables.bootstrap.css", ['property' => 'stylesheet']) }}

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

                "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

                "sDom": '<"top"lfi>rt<"bottom"p><"clear">',

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
                     console.log(oTable);
            $.ajax(
                {
                    url: '{{ url("broker/listings/delete/").'/'}}' + ids[aData[0]],
                    method: 'delete',
                    success: function(data)
                    {
                        toastr['success']("Listing deleted sucessfully", "Success");
                        oTable.fnDeleteRow(nRow);
                    },
                    error: function(data)
                    {
                        toastr['error']("Unable to delete listing. Please try again", "Error");
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
        };
    });

</script>

@stop