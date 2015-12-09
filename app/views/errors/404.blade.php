@extends('layouts.front')

@section('title', 'Application Error')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">Page not Found</h1>
        <div class="row">
            <div class="text-center">
                <div class="alert alert-dismissible alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    Page not found
                </div>
                <p class="lead">We were unable to find the page you requested.
                </p>
                <p class="">Please contact us if you think tihs is an error</p>

            </div>
        </div>
    </div>
</div>


@stop