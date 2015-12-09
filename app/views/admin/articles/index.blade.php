@extends('layouts.admin')

@section('title', 'All Articles')
@section('heading', 'All Articles')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-green pull-right" href="{{ url('admin/articles/create') }}">
                <i class="fa fa-plus"></i> New Article
            </a>
        </div>

        <div class="col-md-12">
            <h2>All Articles</h2>
            <div class="">
                <table class="table table-responsive responsive able-striped table-hover table-bordered" id="table_articles">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fa fa-picture"></i> IMG</th>
                            <th><i class="fa fa-user"></i> Title</th>
                            <th><i class="fa fa-bars"></i> Category</th>
                            <th><i class="fa fa-info-circle"></i> Publish Status</th>
                            <th><i class="fa fa-calendar-o"></i> Date Created</th>
                            <th><i class="fa fa-calendar-o"></i> Last Updated</th>
                            <th>  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $ids = array(); ?>
                        @foreach(App\Models\Article::all() as $i => $a)
                        <tr>
                            <?php $ids[$i + 1] = $a->id ?>
                            <td>{{ $i + 1 }}</td>
                            <td><img class="lightbox" width="80px" src="{{ $a->featuredImage }}"></td>
                            <td>{{ $a->title }}</td>
                            <td>{{ ucwords($a->category->name) }}</td>
                            <td>{{ $a->published ? 'Published' : 'Draft' }}</td>
                            <td>{{ $a->created_at->diffForHumans() }}</td>
                            <td>{{ $a->updated_at->diffForHumans() }}</td>
                            <td>
                                <span class="inline">
                                    <a class="view btn btn-xs red" href="{{ url('articles/'.$a->id) }}"> <i class="fa fa-eye"></i> View </a>
                                    <a class="btn btn-xs red" href="{{ url('admin/articles/edit/'.$a->id) }}"> <i class="fa fa-edit"></i> Edit </a>
                                    <a class="delete btn btn-xs red" href="javascript:;"> <i class="fa fa-trash-o"></i> Delete </a>
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

            var table = $('#table_articles');

            var oTable = table.dataTable({

                "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

                "sDom": '<"top"r>t<"bottom"p><"clear">',

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

            var tableWrapper = $("#table_articles");

            var nEditing = null;

            var nNew = false;

            table.on('click', '.delete', function (e) {
                e.preventDefault();
                if (confirm("Are you sure to delete this article ?") == false) {
                    return;
                }
                var nRow = $(this).parents('tr')[0];
                var aData = oTable.fnGetData(nRow);
                var ids = {{ json_encode($ids) }};
                     $.ajax({
                     url: '{{ url("admin/s/delete/").'/'}}' + ids[aData[0]],
                     method: 'delete',
                     success: function(data){
                toastr['success']("Article deleted sucessfully", "Success");
                oTable.fnDeleteRow(nRow);
            },
                error: function(data){
                    toastr['error']("Unable to delete article. Please try again", "Error");
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
             url: '{{ url("admin/articles/unapprove/").'/'}}' + ids[aData[0]],
             method: 'post',
             success: function(data)
    {
        toastr['success']("Article "+ data.heading + " unapproved sucessfully", "Success");
        oTable.fnDeleteRow(nRow);
        window.location.reload();
    },
        error: function(data)
    {
        toastr['error']("Unable to unapprove article. Please try again", "Error");
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
             url: '{{ url("admin/articles/approve/").'/'}}' + ids[aData[0]],
             method: 'post',
             success: function(data)
    {
        toastr['success']("Article "+ data.heading+ " approved sucessfully", "Success");
        oTable.fnDeleteRow(nRow);
        window.location.reload();
    },
        error: function(data)
    {
        toastr['error']("Unable to approve article. Please try again", "Error");
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