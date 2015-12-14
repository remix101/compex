<?php $nobutton = true; ?>
@extends('layouts.admin')
@section('title', 'Settings')
@section('heading', 'Settings')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(isset($error))
            <div class="alert alert-dismissible alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                {{ $error }}
            </div>
            @endif
            @if(Session::get('success'))
            <div class="alert alert-dismissible alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                {{ Session::get('success') }}
            </div>
            @endif
            <h3>Site Navigation</h3>
            <h5 class="panel-title">Configure Additional Site Navigation Menus</h5>
            <br>
            <div class="panel panel-info">
                <form id="menuForm" method="post" class="form-horizontal">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        @if(App\Models\Menu::all()->count() > 0)
                        <div class="menupanel">
                            @foreach(App\Models\Menu::all() as $i => $m)
                            <div class="menurow" menu-id="{{ $m->id }}">
                                <h4>Menu {{$i+1}}:</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label">Menu Name: </label>
                                        <input name="menus[{{ $m->id }}]" value="{{ $m->name }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Sort ID: </label>
                                        <input name="msorts[{{ $m->id }}]" value="{{ $m->sort_id }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Link: </label>
                                        <input name="mlinks[{{ $m->id }}]" value="{{ $m->link }}">
                                    </div>                                
                                    <div class="col-md-2">
                                        <button class="btn btn-danger deleteMenu" title="Delete Menu"> <i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary addMenu" title="Add Menu"> <i class="fa fa-plus"></i></button>
                                        @if($m->items()->count() == 0)
                                        <button class="btn btn-success addSubmenu" title="Add Submenu"> <i class="fa fa-arrow-down"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="items col-md-offset-1">
                                @if($m->items()->count() > 0)                                
                                <h6>Menu Items: </h6>
                                @foreach($m->items as $item)
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label">Item Title: </label>
                                        <input name="imenus[{{ $m->id }}][{{ $item->id }}]" value="{{ $item->title }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Sort ID: </label>
                                        <input name="isorts[{{ $m->id }}][{{ $item->id }}]" value="{{ $item->sort_id }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Link: </label>
                                        <input name="ilinks[{{ $m->id }}][{{ $item->id }}]" value="{{ $item->link }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-danger deleteItem" title="Delete item"> <i class="fa fa-minus"></i></button>
                                        <button class="btn btn-success addItem" title="Add menu item"> <i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <h4>You have not created a menu yet.</h4>                            
                        <a class="addMenu"><i class="fa fa-plus"></i> Click here to create a menu.</a>
                        @endif
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary btn-other" style="margin-bottom:0px">
                            <i class="fa fa-bars"></i> Save Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Search Settings</h3>
            <h5 class="panel-title">Configure search results listing</h5>
            <br>
            <div class="panel panel-info">
                <div class="form-horizontal">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Configure site results listing</label>
                            <div class="col-md-8">
                                <input id="search_pages" name="search_pages" class="form-control" value="{{ App\Models\SiteConfig::getValueByName('search_pages') }}" type="number" placeholder="Enter number of results to show in site search results">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button onclick="updateSearch()" class="btn btn-primary btn-other" style="margin-bottom:0px">
                            <i class="fa fa-search"></i> Save Settings
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<style>
    .menurow{
        margin: 4px 9px;
    }
    .items .row{
        margin: 4px;
    }
</style>

@stop

@section('footerscripts')

{{ HTML::script('assets/js/bootstrap-toastr/toastr.min.js') }}
{{ HTML::style('assets/js/bootstrap-toastr/toastr.min.css') }}

<script type="text/javascript">

    $("#menuForm").submit(function(e) {

        var url = "{{ url('admin/settings') }}";

        $.ajax({
            type: "POST",
            url: url,
            data: $("#menuForm").serialize(), // serializes the form's elements.
            success: function(data)
            {
                console.log(data);
                toastr['success']('Menu settings saved successfully', 'Success');
            },
            error: function(data){
                toastr['error']("Unable to save menu. Please try again", "Error");
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    var lastMenuId = 0;//auto incrementing id

    $(document).on('click', '.addMenu', function(e) {
        lastMenuId++;
        $(this).closest('.menupanel').append('<div class="menurow" menu-id="'+lastMenuId+'"><div class="row"><div class="col-md-3"><label class="control-label">Menu Name: </label><input name="newmenus['+lastMenuId+']" value="New Menu"></div><div class="col-md-3"><label class="control-label">Sort ID: </label><input name="newsorts['+lastMenuId+']" value=""></div><div class="col-md-4"><label class="control-label">Link: </label><input name="newlinks['+lastMenuId+']" value="#"></div><div class="col-md-2"><button class="btn btn-danger deleteMenu" title="Delete Menu"> <i class="fa fa-minus"></i></button><button class="btn btn-primary addMenu" title="Add Menu"> <i class="fa fa-plus"></i></button><button class="btn btn-success addSubmenu" title="Add Submenu"> <i class="fa fa-arrow-down"></i></button></div></div></div>');
        return false;
    });

    $(document).on('click', '.deleteMenu', function(e){
        $(this).closest('.menurow').next('.items').remove();
        $(this).closest('.menurow').remove();
        return false;
    });

    $(document).on('click', '.addItem', function(e) {
        lastMenuId = $(this).parent().parent().parent().prev('.menurow').attr('menu-id');
        $(this).closest('.row').after('<div class="row"><div class="col-md-3"><label class="control-label">Item Title: </label><input name="submenus['+lastMenuId+'][]" value="Example submenu"></div><div class="col-md-3"><label class="control-label">Sort ID: </label><input name="subsorts['+lastMenuId+'][]" value=""></div><div class="col-md-4"><label class="control-label">Link: </label><input name="sublinks['+lastMenuId+'][]" value="#"></div><div class="col-md-2"><button class="btn btn-danger deleteItem" title="Delete item"> <i class="fa fa-minus"></i></button><button class="btn btn-success addItem" title="Add menu item"> <i class="fa fa-plus"></i></button></div>');
        return false;
    });

    $(document).on('click', '.addSubmenu', function(e) {
        lastMenuId = $(this).closest('.menurow').attr('menu-id');
        $(this).closest('.menurow').after('<div class="items col-md-offset-1"><div class="row"><div class="col-md-3"><label class="control-label">Item Title: </label><input name="submenus['+lastMenuId+'][]" value="Example submenu"></div><div class="col-md-3"><label class="control-label">Sort ID: </label><input name="subsorts['+lastMenuId+'][]" value=""></div><div class="col-md-4"><label class="control-label">Link: </label><input name="sublinks['+lastMenuId+'][]" value="#"></div><div class="col-md-2"><button class="btn btn-danger deleteItem" title="Delete item"> <i class="fa fa-minus"></i></button><button class="btn btn-success addItem" title="Add menu item"> <i class="fa fa-plus"></i></button></div>');
        $(this).hide();
        return false;
    });

    $(document).on('click', '.deleteItem', function(e) {
        if($(this).closest('.items').find('.row').length == 1)
        {
            $(this).parent().parent().parent().prev('.menurow').find('.addSubmenu:hidden').show();
            $(this).closest('.items').remove();
        }
        else
        {
            $(this).closest('.row').remove();
        }
        return false;
    });

    function updateSearch(e)
    {
        $.ajax({
            url: '{{ url("admin/search") }}',
            method: 'post',
            data: {
                search_pages: search_pages.value,
            },
            success: function(data){
                console.log(data);
                toastr['success']("Search settings saved sucessfully", "Success");
            },
            error: function(data){
                toastr['error']("Unable to save search settings. Please try again", "Error");
            }
        });
        e.preventDefault();
    }

    jQuery(document).ready(function(){
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