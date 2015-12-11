<?php $nobutton = true; ?>

@extends('layouts.admin')

@section('title', 'Create New Article')

@section('content')


<div class="container">
    <div class="row">
        <form role="form" action="{{ url('admin/articles/create') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
            @if(isset($success))
            <div class="alert alert-dismissible alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                Article created successfully.
            </div>
            @else
            @if(isset($errors))
            @foreach ($errors->all() as $e)
            <div class="alert alert-dismissible alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="danger"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                {{ $e }}
            </div>
            @endforeach
            @endif
            @endif

            <div class="col-md-12">
                <div class="col-md-offset-2">
                    <h4>Create an article</h4>
                </div>
                <hr>
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="heading">Title</label>
                        <div class="col-md-10">                            
                            <input type="text" name="title" placeholder="Enter a title for this article" class="form-control" id="heading" value="{{ Input::old('title') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Content</label>
                        <div class="col-md-10">
                            <textarea class="wysihtml5 form-control" name="html" rows="6">{{ Input::old('html') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="category">User Category</label>
                        <div class="col-md-10">
                            <div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div><span class="caret select-caret"></span>
                                <select id="category" class="form-control" name="category_id">
                                    @foreach(App\Models\Role::all() as $r)
                                    @if($r->id != Config::get('constants.ROLE_ADMIN'))
                                    <option value="{{ $r->id }}">{{ ucwords($r->name) }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="heading">Featured Image</label>
                        <div class="col-md-10">                            
                            <input type="file" name="featured" class="form-control" id="featured" required>
                            <div class="preview-area">
                                
                            </div>
                        </div>
                    </div>

                    <div class="form-group last" style="margin-left:2em">
                        <div class="col-md-offset-2 checkbox-list">
                            <label class="checkbox" for="description">
                                <input type="checkbox" checked value="1" name="published"> Publish now</label>
                        </div>
                    </div>
                </div>
                <div class="form-footer">
                    <div class="col-md-offset-2">
                        <input type="submit" value="Create Article" class="btn btn-success">		                            
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </form>
    </div>
</div>
@stop

@section('footerscripts')

{{ HTML::style("assets/css/bootstrap-wysihtml5.css", ['property' => 'stylesheet']) }}
{{ HTML::script("assets/js/wysihtml5-0.3.0.js") }}
{{ HTML::script("assets/js/bootstrap-wysihtml5.js") }}

<script type="text/javascript">
    if (jQuery().wysihtml5) {

        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": ["{{ url('assets/css/wysiwyg-color.css') }}"]
            });
        }
    }

    //bind the function to the input
    document.getElementById("featured").addEventListener("change",previewImages,false);

    function previewImages(){
        var fileList = this.files;
        var anyWindow = window.URL || window.webkitURL;
        if(fileList.length > 0)
        {
            $('.preview-area').html('');
        }
        if(fileList.length > 0){
            //get a blob to work with
            var objectUrl = anyWindow.createObjectURL(fileList[0]);
            // for the next line to work, you need something class="preview-area" in your html
            $('.preview-area').append('<img class="pthumb" src="' + objectUrl + '" />');
            // get rid of the blob
            window.URL.revokeObjectURL(fileList[0]);
        }
    }

</script>

@stop