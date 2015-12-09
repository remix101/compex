@extends('layouts.front')

@section('title', 'Error')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">Error</h1>
        <div class="row">
            <div class="text-center">
                <div class="alert alert-dismissible alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    {{ $message }}
                </div>
                <p class="lead">{{ $message }}</p>
                
                @if(isset($button))
                <a class="btn btn-success" href="{{ $button['href'] }}" title="{{ $button['title'] }}"><i class="fa fa-link"></i> {{ $button['title'] }}</a>
                @endif

            </div>
        </div>
    </div>
</div>


@stop