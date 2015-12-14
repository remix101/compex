@extends('layouts.front')

@section('title', 'Profile')

@section('content')

<div class="profile">
    <form id="account-update" class="form-horizontal" action="{{ url('account') }}" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="col-md-12">
                <br>
                <h3>Account Profile</h3>
                <hr>
                @if(isset($success))
                <div class="alert alert-dismissible admission alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    Account profile updated successfully.
                </div>
                @else
                @if(isset($errors))
                @foreach ($errors->all() as $e)
                <div class="alert alert-dismissible alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="danger"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    {{ $e }}
                </div>
                @endforeach
                @endif
                @endif
                <div class="col-md-6">
                    <p>Please edit to change your contact information</p>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Title</label>
                        <div class="col-md-8">
                            <select class="form-control" name="salutation">
                                <option value="Mr.">Mr.</option>
                                <option value="Ms.">Ms.</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">First Name</label>
                        <div class="col-md-8">
                            <input class="form-control" name="first_name" id="first-name" placeholder="First Name" type="text" required="" value="{{$user->first_name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Last Name</label>
                        <div class="col-md-8">
                            <input class="form-control" name="last_name" id="last-name" placeholder="Last Name" type="text" required="" value="{{$user->last_name}}">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Phone Number</label>
                        <div class="col-md-8">
                            <input class="form-control" name="phone_number" id="phone" placeholder="Mobile Phone" type="text" required="" value="{{$user->buyer->phone_number}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Country</label>
                        <div class="col-md-8">
                            <select name="country" class="form-control select2me">
                                @foreach(App\Models\Country::all() as $c)
                                <option value="{{$c->id}}" {{ $c->id == $user->buyer->country ? 'selected' : ''}}>{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Email</label>
                        <div class="col-md-8">
                            <input class="form-control has-dark-background" id="email" placeholder="Email" type="email" required="" value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-8">
                            <input class="form-control has-dark-background" name="password" id="password" placeholder="Password" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-8">
                            <input class="form-control has-dark-background" name="password_confirmation" placeholder="Confirm Password" type="password">
                        </div>
                    </div>
                    <br>                    
                    <input type="submit" value="Update Account" class="btn btn-success pull-right">		                            
                </div>
            </div>
        </div>
    </form>	
</div>
@stop