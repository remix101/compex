@extends('layouts.admin')

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
            <strong>Success!</strong> Message to {{$message->receiver->getProfile()->fullName }} sent successfully.
        </div>
        @endif
        <div class="well">
            <form role="form">
                <div class="row">
                    <div class="col-sm-12 col-md-10">
                        <div class="form-inline">
                            <label for="select-superget">Send To:</label>
                            @if(isset($usr))
                            <p class="well">
                                 {{ $usr->fullName }}
                            </p>
                            @else
                            <select id="select-superget" placeholder="Enter name of recipient..." tabindex="-1" class="selectized" style="display: none; width: 300px;">
                                <option value="" selected="selected"></option>
                            </select>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="message-answer">
            <img src="{{ url(Auth::user()->getPhoto()) }}" alt="..." class="hidden-xs">
            <form action='{{ url("inbox/compose") }}' method="post" role="form">
                <input type="hidden" id="pm_receiver" name="recipient_id" value="{{isset($usr) ? $usr->id : '' }}">
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
{{ HTML::script('assets/js/md5.js') }}

<script type="text/javascript">
    
    function getRole(role_id)
    {
        r = parseInt(role_id);
        switch(r)
        {
            case {{ Config::get('constants.ROLE_BUYER') }}:
                return 'buyer';
            case {{ Config::get('constants.ROLE_BROKER') }}:
                return 'broker';
            case {{ Config::get('constants.ROLE_SELLER') }}:
                return 'seller';
            case {{ Config::get('constants.ROLE_ADMIN') }}:
                return 'admin';
        }
    }
    
    $('#select-superget').selectize({
        valueField: 'id',
        labelField: 'first_name',
        searchField: ['first_name', 'last_name'],
        render: {
            option: function (item, escape) {
                return '<div>' +
                    '<span class="title"><img class="pm-av" src="'
                    +  'https://www.gravatar.com/avatar/' + md5(escape(item.email)) + '?s=32' 
                    +'"/>' +
                    '<span class="pm-name">' + escape(item.first_name) + ' ' + escape(item.last_name) + '</span>' +
                    '</span>'+
                    '<ul class="meta fa-ul">' +
                    '<li><span>' + getRole(item.role_id) + '</span></li>'+
                    '</ul>' +
                    '</div>';
            }
        },
        load: function (query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: '{{ url("/getuser?q=") }}' + encodeURIComponent(query),
                type: 'GET',
                error: function () {
                    callback();
                },
                success: function (res) {
                    callback(res.slice(0, 100));
                }
            });
        },
        onChange: function(value){
            pm_receiver.value = value;
            return false;
        }    });
</script>
@stop