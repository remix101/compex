@extends('layouts.admin')
@section('title', 'Add User')
@section('heading', 'Add User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('user_new'))
            <div class="alert alert-success" alert-dismissable>
                User {{ Session::get('usr')->fullName }} added successfully.<button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif
            <div class="portlet box blue-steel ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-plus"></i> Add New User
                    </div>
                    <div class="tools">
                        <a href="" class="collapse" data-original-title="" title="">
                        </a>
                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
                        </a>
                        <a href="" class="reload" data-original-title="" title="">
                        </a>
                        <a href="" class="remove" data-original-title="" title="">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" action="{{ url('/admin/users/create') }}" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="" name="first_name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Last Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="" name="last_name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" value="" name="email" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phone</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="" name="phone" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="" name="password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Role</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="role_id">
                                        @foreach(App\Models\Role as $role)
                                        <option value="{{$role->id}}">{{ ucwords($role->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Country</label>
                                <div class="col-md-9">
                                    <select name="country_id" class="form-control select2me">
                                        @foreach(App\Models\Country::all() as $c)
                                        <option value="{{$c->id}}" {{ $c->id == 78 ? 'selected' : ''}}>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions pull-right">
                            <button type="button" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-success">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@stop