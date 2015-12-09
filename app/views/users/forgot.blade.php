@extends('layouts.front')

@section('title', 'Forgot Password')

@section('content')

<style>
    header#header{
        display: none;
    }
    footer{
        text-align: center;
    }
</style>
<div class="container" style="margin-top: 120px">    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Enter your email below to receive your password reset link</h3>
                </div>
                {{ Form::open(array('route' => 'password.request', 'class' =>'span5', 'style'=>'float:left')) }}
                @if(isset($message))
                <div class="alert alert-dismissible alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    {{$message}}
                </div>
                @endif

                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email">Email</label>
                        <div class="col-md-9">
                            <input autocomplete="off" type="email" name="email" class="required form-control" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="col-md-12 form-group">
                        <div style="float:left;line-height:3em">
                            <span>Not yet registered? <a href="{{ url('register') }}" title="Register">Register Now</a></span>
                            <span>Already registered? <a href="{{ url('login') }}" title="Login">Login</a></span>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-primary" style="width: 100%;" type="submit">Reset Password</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@stop