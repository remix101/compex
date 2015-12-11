@extends('layouts.broker')

@section('title', 'Create Business Wanted Advert')

@section('content')

<div class="container">
    <div class="row">
        <form role="form" action="{{ url('broker/adverts/create') }}" method="post" class="form-horizontal">
            @if(isset($success))
            <div class="alert alert-dismissible alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                Business wanted advert created successfully.
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

            <div class="col-md-12">
                <div class="col-md-offset-3">
                <h4>Briefly provide a heading for your business wanted advert</h4>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="heading">Heading</label>
                    <div class="col-md-9">                            
                        <input type="text" name="heading" placeholder="Enter a heading this advert will appear as" class="form-control" id="heading" value="{{ Input::old('heading') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="description">Description</label>
                    <div class="col-md-9">                            
                        <textarea name="description" maxlength="255" placeholder="Please provide a detailed description of your advert" class="form-control" id="description" rows="3" required>{{ Input::old('description') }}</textarea> 
                    </div>
                </div>
                <div class="form-group required">
                    <label class="col-md-3 control-label" for="asking_price">Asking Price</label>
                    <div class="col-md-9">
                        <div class="input-group"><div class="input-group-addon">$</div><span class="caret select-caret"></span>
                            <select id="asking_price" class="form-control" name="asking_price">
                                <option value="">Select...</option>
                                @foreach(App\Models\PriceHelper::all() as $helper)
                                <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group required">
                    <label class="col-md-3 control-label" for="country">Country</label>
                    <div class="col-md-9">
                        <select id="country" class="form-control" name="country">
                            @foreach(App\Models\Country::all() as $c)
                            <option value="{{ $c->id }}"{{ $user->broker != null ? ($user->broker->country == $c->id ? 'selected' : '') : '' }}>{{$c->name}}</option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group required">
                    <label class="col-md-3 control-label" for="category_id">Business Category</label>
                    <div class="col-md-9">
                        <select id="category_id" class="form-control" name="category">
                            @foreach(App\Models\Category::all() as $cg)
                            <option value="{{ $cg->id }}" {{ Input::old("category") == $cg->id ? "selected" : "" }}>{{ $cg->name }}</option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-md-offset-3">
                <input type="submit" value="Create Advert" class="btn btn-success">		                            
                </div>
            </div>
            <div class="clearfix"> </div>
        </form>
    </div>
</div>
@stop
