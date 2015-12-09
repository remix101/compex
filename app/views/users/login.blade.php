@extends('layouts.front')

@section('title', 'Login')

@section('content')
<div class="container no-pad">
    <ul class="breadcrumb"><li><a href="{{ url('/') }}">Home</a></li>
        <li class="active">Log-in details</li>
    </ul>    </div>
<div class="container">
    <div class="site-signup">
        <h1 class="text-center">Log-in details</h1>
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <div class="well">
                    <div class="well well_white text-center">
                        <p>Use your account on any of the following sites to login</p>
                        <div id="w0" class="auth-clients">
                            <ul class="list-unstyled list-inline">
                                <li><a class="btn ce-auth-btn ce-auth-btn_facebook" href="{{ url('auth/facebook') }}"><i class="ce-auth-btn__icon fa fa-facebook fa fa-facebook"></i>facebook</a></li>
                                <li><a class="btn ce-auth-btn ce-auth-btn_linkedin" href="{{ url('auth/yahoo') }}"><i class="ce-auth-btn__icon fa fa-linkedin fa fa-yahoo"></i>yahoo</a></li>
                                <li><a class="btn ce-auth-btn ce-auth-btn_google" href="{{ url('auth/google') }}"><i class="ce-auth-btn__icon fa fa-google fa fa-google-plus"></i>google</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-divider text-center"><hr class="hr text-divider__divider"><span class="text-divider__text text-divider__text_in-well">Or</span></div>

                    <form id="form-login" action="{{ url('login') }}" method="post" role="form">
                        @if(isset($errors))
                        @foreach ($errors->all() as $e)
                        <div class="alert alert-dismissible alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                            {{ $e }}
                        </div>
                        @endforeach
                        @endif
                        @if(Session::has('success'))
                        <div class="alert alert-dismissible alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if(isset($success))
                        <div class="alert alert-dismissible alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                            {{ $success }}
                        </div>
                        @endif
                        @if(isset($message))
                        <div class="alert alert-dismissible alert-info" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                            {{ $message }}
                        </div>
                        @endif

                        <input type="hidden" name="_csrf" value="{{ csrf_token() }}">
                        <div class="form-group required">
                            <label class="control-label" for="email">Email</label>
                            <input type="text" id="email" class="form-control" name="email">

                            <p class="help-block help-block-error"></p>
                        </div>
                        <div class="form-group field-signupform-password required">
                            <label class="control-label" for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password">

                            <p class="help-block help-block-error"></p>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Login</button>
                            <div class="pull-right">
                                                        <span>Not yet registered? <a href="{{ url('register') }}" title="Register">Register Now</a></span> | <span><a href="{{ url('password/reset') }}" title="Register">Forgot Password?</a></span>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


@stop