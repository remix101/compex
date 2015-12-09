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
<div class="container">    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding:9px">
                    <h3>Enter your email below to reset your password</h3>
                </div>
                {{ Form::open(array('route' => 'password.request', 'class' =>'from-horizontal')) }}
                @if(isset($message))
                <div class="alert alert-dismissible alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    {{$message}}
                </div>
                @endif

                <div class="panel-body">
                    <div class="form-group">
                        <br>
                        <label class="col-md-3 control-label" for="email">Email</label>
                        <div class="col-md-9">
                            <input autocomplete="off" type="email" name="email" class="required form-control" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="clearfix"></div>
                    <div class="">
                        <button class="btn btn-primary pull-right" type="submit">Reset Password</button>
                        <div style="line-height:3em">
                            <span>Not yet registered? <a href="{{ url('register') }}" title="Register">Register Now</a></span>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@stop