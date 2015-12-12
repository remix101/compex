@extends('layouts.seller')

@section('title', 'Add Photos')

@section('content')

<div class="container no-pad">
</div>
<div class="container">
    <div class="business_create">
        <h1>Add Documents and Photos</h1>
        <form id="w0" action="{{ url('sellers/listings/'.$listing->id.'/photos') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-md-12">
                    @if(isset($errors))
                    @foreach ($errors->all() as $e)
                    <div class="alert alert-dismissible alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                        {{ $e }}
                    </div>
                    @endforeach
                    @endif
                    @if(isset($success))
                    <div class="alert alert-dismissible alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                        {{ $success }}
                    </div>
                    @endif
                    <p>Unless stated as required (*), all the fields are optional. We understand that anonymity and privacy may sometimes be key considerations when selling a business - therefore business names and location details do not have to be shown.
                        <br>
                        To achieve the best results please ensure you fill out as much information as possible.
                    </p>
                    <h4>Add photos to improve your listing quality</h4>
                    <div class="well">
                        <div class="form-group required">
                            <label class="control-label" for="category_id">Documents/Photos</label>
                            <input id="photos" type="file" multiple="multiple" class="form-control" name="photos[]">
                            <div class="hint-block">Select single or multiple documents supporting your listing. You may chose to do this later</div>
                            <div class="help-block"></div>
                            <div class="preview-area">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a type="preview" class="btn btn-success" href="{{ url('seller/listings/preview/'.$listing->id) }}">Preview</a>
                <button type="submit" role="reset" class="btn btn-info">Skip</button>
                <button type="submit" class="btn btn-default">Finish</button>
            </div>
        </form>
    </div>
    <!-- business_create -->
</div>

@stop

@section('footerscripts')

<script type="text/javascript">

    //bind the function to the input
    document.getElementById("photos").addEventListener("change",previewImages,false);

    function previewImages(){
        var fileList = this.files;
        var anyWindow = window.URL || window.webkitURL;
        if(fileList.length > 0)
        {
            $('.preview-area').html('');
        }
        for(var i = 0; i < fileList.length; i++){
            //get a blob to work with
            var objectUrl = anyWindow.createObjectURL(fileList[i]);
            // for the next line to work, you need something class="preview-area" in your html
            $('.preview-area').append('<img class="pthumb" src="' + objectUrl + '" />');
            // get rid of the blob
            window.URL.revokeObjectURL(fileList[i]);
        }
    }

</script>

@stop