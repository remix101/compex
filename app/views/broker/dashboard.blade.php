@extends('layouts.seller')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')

@if(Session::get('message_count'))
<div class="alert alert-dismissible alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
    You have {{ Session::get('message_count') }} unread messages in your account inbox.
</div>
@endif

@if(Session::has('validate_password'))
<div class="container">
    <div class="col-md-12">
        <form id="account-update" class="form-horizontal" action="{{ url('account') }}" method="post" enctype="multipart/form-data">
            <h4>Account Update</h4>
            <legend class="col-md-9 col-md-offset-3">
                <h4>Please set a password to access your account with</h4>
            </legend>
            <div class="form-group">
                <label class="col-md-3 control-label">Password</label>
                <div class="col-md-9">
                    <input class="form-control has-dark-background" name="password" id="password" placeholder="Password" type="password">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Confirm Password</label>
                <div class="col-md-9">
                    <input class="form-control has-dark-background" name="password_confirmation" placeholder="Confirm Password" type="password">
                </div>
            </div>
            <input type="submit" value="Update Account" class="btn btn-success pull-right">		                            
        </form>
    </div>
</div>
@else

@if($user->customer->accounts()->count() == 0)
<div class="alert alert-dismissible alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
    You have not created a call account yet, <a id="new_account" href="#" data-toggle="modal" data-target="#create_account" >click here now</a> to create a new call account
</div>
@else
<h3>Call Accounts</h3>
<hr>
<table class="table table-responsive responsive able-striped table-hover table-bordered" id="table_applications">
    <thead>
        <tr>
            <th>ID</th>
            <th><i class="fa fa-mobile"></i> Destination Phone Number</th>
            <th><i class="fa fa-globe"></i> Website</th>
            <th><i class="fa fa-at"></i> Account Id</th>
            <th><i class="fa fa-key"></i> Account Key</th>
            <th><i class="fa fa-bar-chart"></i> Total Calls</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user->customer->accounts()->take(15)->get() as $i => $a)
        <tr>                            
            <td>{{ $i + 1 }}</td>
            <td>{{ $a->phone }}</td>
            <td>{{ $a->website_domain }}</td>
            <td>{{ $a->account_id }}</td>
            <td>
                <a id="key" data-id="{{$a->id}}" class="key btn btn-xs default tableActionButtonMargin" href="javascript:;">
                    <i class="fa fa-eye"></i> Show Key</a>
            </td>
            <td>{{ $a->sessions()->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<hr>
<h4>Last Call Records</h4>
<hr>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Destination Phone Number </th>
            <th>Customer Number </th>
            <th>Duration </th>
            <th>Charge </th>
            <th>Date/Time </th>
        </tr>
    </thead>
    <tbody>
        <?php $sessions = CallSession::where('customer_id', '=', $user->customer->id)->desc('created_at')->take(5)->get(); ?>
        @foreach($sessions as $call)
        <tr>
            <td>{{ $call->phone_number }}</td>
            <td>{{ $call->connecting_number }}</td>
            <td>
                <label class="label label-info label-lg">{{ $call->duration }}s </label>
            </td>
            <td>
                <label class="label label-success label-lg">{{ $call->cost }}</label></td>
            <td>{{ date('Y-m-d H:i:s', strtotime($call->created_at)) }}</td>
        </tr>
        @endforeach
        @if($sessions->count() == 0)
        <tr>
            <td colspan="5" class="text-center">There have not been any calls on your account yet</td>
        </tr>
        @endif
    </tbody>
</table>
<a href="{{ url('crm/calls') }}" class="btn btn-default btn-sm pull-right"> <i class="glyphicon glyphicon-repeat"></i> View All Call Sessions</a>
@endif
@endif
<div class="modal modal-backdrop fade" id="create_account" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title" id="modal-register-label">Create New Call Account</h3>
            </div>

            <div class="modal-body">
                <div style="padding:20px; margin-left:0px">
                    <form role="form" action="{{ url('crm/accounts/create') }}" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="sr-only col-md-3" for="form-website-domain">Website Domain</label>
                            <div class="col-md-9">                            
                                <input type="text" name="website_domain" placeholder="Enter website domain without www, e.g. myexample.com" class="form-control" id="form-website-domain" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="help-text" style="margin-left:1em">Enter phone number you will use in communicating with customers...</p>
                            <label class="sr-only col-md-3" for="form-phone-number">Connecting Phone Number</label>
                            <div class="col-md-9">                            
                                <input type="text" maxlength="16" name="phone" placeholder="Use international format, e.g. +301303848938" class="form-control" id="inputPhone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="checkbox" style="margin-left:3em; line-height:1.5em">
                                <input type="checkbox" name="enable_international"> Enable International Calls
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox" style="margin-left:3em; line-height:1.5em">
                                <input type="checkbox" name="enable_captcha"> Enable Captcha on Contact Forms
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg">Create Now</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="keymodal" tabindex="-1" role="dialog" aria-labelledby="modal-register-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title" id="modal-register-label">Account Key</h3>
            </div>

            <div class="modal-body">
                <form role="form">
                    <textarea class="form-control" id="keytext"></textarea>
                </form>

            </div>

        </div>
    </div>
</div>
<style>
    .modal-backdrop.in {
        opacity: 0.9;
    }
</style>
@stop

@section('footerscripts')

{{ HTML::style("vendor/intl-phone/css/intlTelInput.css") }}
{{ HTML::script("vendor/intl-phone/js/intlTelInput.min.js") }}
{{ HTML::script("app.js") }}

<script type="text/javascript">
    var keys = {{ json_encode(CallAccount::all()->lists('account_key', 'id')) }};

    $(document).on('click', '.key', function() {
        keytext.value = keys[$(this).attr('data-id')];
        $('#keymodal').modal('show');
        return false;
    });
</script>
@stop