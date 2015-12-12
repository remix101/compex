@extends('layouts.front')

@section('title', 'Reset Password')

@section('content')

<div class="container">    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:9px">
                    <h3>Password Update</h3>
                    <h5>Please enter a new password to log in to your account</h5>
                </div>
                {{ Form::open(array('class' => 'form-horizontal', 'route' => array('password.update', $token))) }}
                @if(isset($message))
                <div class="alert alert-dismissible alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    {{$message}}
                </div>
                @endif

                <div class="panel-body">
                    <br>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email">Email</label>
                        <div class="col-md-9">
                            <input autocomplete="off" type="email" name="email" class="required form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">New Password</label>
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
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="panel-footer">
                    <div class="" style="margin:10px 12px 2px 0px">
                        <button class="btn btn-primary" style="margin-bottom:10px" type="submit">Update Password</button>
                        <div class="pull-right">
                            Or <a href="{{ url('login') }}" title="Login">Click here to log in</a>
                        </div>
                    </div>
                </div>

                {{ Form::hidden('token', $token) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@stop