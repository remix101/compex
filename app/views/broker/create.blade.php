@extends('layouts.front')

@section('title', 'Create Broker Account')

@section('content')

<div class="container">
    <div class="site-signup">
        <h1>Please provide your contact information </h1>
        <p>Please fill out the following fields:</p>
        <form id="form-signup" action="{{ url('broker/create') }}" method="post" role="form">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    @if(isset($errors))
                    @foreach ($errors->all() as $e)
                    <div class="alert alert-dismissible alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                        {{ $e }}
                    </div>
                    @endforeach
                    @endif
                    @if(Session::has('success'))
                    <div class="alert alert-dismissible alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group required">
                        <label class="control-label" for="title">Title</label>
                        <select id="title" class="form-control" name="title">
                            <option value="0">Select...</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Miss.">Miss.</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Prof.">Prof.</option>
                        </select>
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="firstname">First Name</label>
                        <input type="text" id="firstname" class="form-control" value="{{Input::old('first_name')}}" name="first_name" placeholder="Please write your first name" required>
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="lastname">Last Name</label>
                        <input type="text" id="lastname" class="form-control" value="{{Input::old('last_name')}}" name="last_name" placeholder="Please write your last name" required>
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="bname">Business/Company Name</label>
                        <input type="text" id="bname" class="form-control" value="{{Input::old('business_name')}}" name="business_name" placeholder="Please enter the name of your company/business" required>
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="phone">Work Phone</label>
                        <input type="text" maxlength="17" class="form-control" value="{{Input::old('work_phone')}}" name="work_phone" id="inputPhone" placeholder="Use international format, e.g. +234 809 901 9404">
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="accountType">Country</label>
                        <select class="form-control" name="country" id="country">
                            @foreach(App\Models\Country::all() as $c)
                            <option value="{{$c->id}}" {{ $c->id == 36 ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="lastname">Address</label>
                        <textarea id="address" class="form-control" rows="2" name="address" placeholder="Please enter your business address" required>{{Input::old('address')}}</textarea>
                        <p class="help-block help-block-error"></p>
                    </div>

                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="well">
                        <div id="social-signup" class="auth-clients text-center">
                            <h5>Or Signup with your Social Account</h5>
                            <hr>
                            <ul class="list-unstyled list-inline">
                                <li><a class="btn btn-default ce-auth-btn ce-auth-btn_facebook" href="{{ url('auth/facebook/broker') }}"><i class="ce-auth-btn__icon fa fa-facebook"></i>facebook</a></li>
                                <li><a class="btn btn-default ce-auth-btn ce-auth-btn_linkedin" href="{{ url('auth/yahoo/broker') }}"><i class="ce-auth-btn__icon fa fa-yahoo"></i>yahoo</a></li>
                                <li><a class="btn btn-default ce-auth-btn ce-auth-btn_google" href="{{ url('auth/google/broker') }}"><i class="ce-auth-btn__icon fa fa-google"></i>google</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="inputEmail">Email</label>
                        <input type="text" maxlength="50" class="form-control" value="{{Input::old('email')}}" name="email" type="email" id="inputEmail" placeholder="Enter an email to use in accessing your account" required>
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label">Password</label>
                        <input class="form-control has-dark-background" name="password" id="password" placeholder="Password" type="password">
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label">Confirm Password</label>
                        <input class="form-control has-dark-background" name="password_confirmation" placeholder="Confirm Password" type="password">
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group required">
                        <label class="control-label" for="accountType">Account Type</label>
                        <select class="form-control" name="role_id" id="role_id">
                            @foreach(App\Models\Role::all() as $role)
                            @if($role->name != 'admin')
                            <option value="{{$role->id}}" {{ $role->name == 'broker' ? 'selected' : '' }}>{{ ucwords($role->name) }}</option>
                            @endif
                            @endforeach
                        </select>
                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Signup</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

@stop

@section('footerscripts')
{{ HTML::style("vendor/intl-phone/css/intlTelInput.css", ['property' => 'stylesheet']) }}
{{ HTML::script("vendor/intl-phone/js/intlTelInput.min.js") }}
{{ HTML::script("app.js") }}

@stop