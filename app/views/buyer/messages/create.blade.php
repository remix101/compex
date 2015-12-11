@extends('layouts.front')

@section('title', 'Inbox')
@section('heading', 'Compose')

@section('content')

<div class="container">
    <h3 style="color: #481212;" class="page-title">Compose Message</h3>
    <div class="row">
        <div class="col-md-12">

            @if($errors->has())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                {{ $error }}
            </div>
            @endforeach
            @endif

            @if(isset($message))
            <div class="alert alert-success">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                <strong>Success!</strong> Message to {{$message->receiver->fullName }} sent successfully.
            </div>

            @endif
            <div class="well">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-12 col-md-10">
                            <div class="form-inline">
                                <label for="select-superget">Send To:</label>
                                <p class="well">
                                    {{ isset($usr) ? $usr->fullName : 'CompanyExchange Support' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <div class="message-answer">
                <img src="{{ url(Auth::user()->getPhoto()) }}" alt="..." class="hidden-xs">
                <form action='{{ url("inbox/compose") }}' method="post" role="form">
                    <input type="hidden" id="pm_receiver" name="recipient_id" value="{{ isset($usr) ? $usr->id : '1' }}">
                    <div class="form-group">                    
                        <label for="message" class="sr-only">Message</label>
                        <textarea class="form-control" rows="5" name="message" id="message" placeholder="Write a message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

@stop

@section('footerscripts')

{{ HTML::style("assets/css/messages.css", ['property' => 'stylesheet']) }}

{{ HTML::script('assets/js/list.min.js') }}
{{ HTML::style('assets/css/selectize.bootstrap3.css') }}
{{ HTML::script('assets/js/selectize.js') }}

@stop