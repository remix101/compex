@extends('layouts.broker')

@section('title', 'Create Listing')

@section('content')

<div class="container no-pad">
</div>
<div class="container">
    <div class="business_create">
        <h1>Sell your business</h1>
        <form id="w0" action="{{ url('broker/listings/create') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_csrf" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-md-12">
                    <p>Unless stated as required (*), all the fields are optional. We understand that anonymity and privacy may sometimes be key considerations when selling a business - therefore business names and location details do not have to be shown.
                        <br>
                        To achieve the best results please ensure you fill out as much information as possible.
                    </p>
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

                    <h4>Business details</h4>
                    <div class="well">
                        <div class="form-group required">
                            <label class="control-label" for="category_id">Business Category</label>
                            <select id="category_id" class="form-control" name="category">
                                @foreach(App\Models\Category::all() as $cg)
                                <option value="{{ $cg->id }}">{{ $cg->name }}</option>
                                @endforeach
                            </select>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="name">Listing Headline</label>
                            <input type="text" id="heading" class="form-control" name="heading" placeholder="Enter listing headline" value="{{ Input::old('heading') }}">
                            <div class="hint-block">This will appear as the main headline for your listing. For example, "Successful Devon Hotel and Restaurant For Sale".</div>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="desc">Business Description</label>
                            <textarea id="desc" class="form-control" name="description" rows="6" placeholder="Please write your business description">{{ Input::old('description') }}</textarea>
                            <div class="hint-block">Highlight the selling points of the business for sale. Say as much or as little as you want.</div>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="photos">Supporting Documents/Photos</label>
                            <input id="photos" type="file" multiple="multiple" class="form-control" name="photos[]">
                            <div class="hint-block">Select single or multiple documents supporting your listing. You may chose to do this later</div>
                            <div class="help-block"></div>
                            <div class="preview-area">
                                <img id="image_upload_preview" src="http://placehold.it/100x100" alt="your image" />
                            </div>
                            <div class="clearfix"></div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="country">Country</label>
                                    <select id="country" class="form-control" name="country">
                                        @foreach(App\Models\Country::all() as $c)
                                        <option value="{{ $c->id }}"{{ $user->broker->country == $c->id ? 'selected' : '' }}>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="state">State</label>
                                    <input id="state" class="form-control" name="state" type="text" value="{{ Input::old('state') }}">
                                    <div class="help-block">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="city">City</label>
                                    <input type="text" id="city" value="{{ Input::old('city') }}" class="form-control" name="city" placeholder="Please enter name of city where your business is located">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4>Property and financial details</h4>
            <div class="well">
                <div class="form-horizontal">
                    <div class="form-group required">
                        <div class="col-md-3">
                            <label class="control-label" for="property_status">Property Status</label>
                        </div>
                        <div class="col-md-9 form-inline">
                            <div id="property_status">
                                <label class="checkbox"><input type="radio" name="property_status" value="2" tabindex="3">Real Property</label>
                                <label class="checkbox"><input type="radio" name="property_status" value="1" tabindex="3">Lease</label>
                                <label class="checkbox"><input type="radio" name="property_status" value="3" tabindex="3">Both</label>
                                <label class="checkbox"><input type="radio" name="property_status" value="" tabindex="3">N/A</label>
                            </div>
                            <div class="hint-block">Is real property included? Or is the property leased by the business?</div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-md-3">
                            <label class="control-label" for="ask_price">Asking Price</label>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group"><div class="input-group-addon">$</div><span class="caret select-caret"></span>
                                        <select id="ask_price" class="form-control" name="ask_price">
                                            <option value="">Select...</option>
                                            @foreach(App\Models\PriceHelper::all() as $helper)
                                            <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <strong class="text-center">OR</strong> &nbsp; specific asking price
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input id="ask_price_exact" class="form-control" placeholder="Asking price" name="ask_price_exact">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-md-3">
                            <label class="control-label" for="annual_yearly_revenue">Sales Revenue (Yearly)</label>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group"><div class="input-group-addon">$</div><span class="caret select-caret"></span>
                                        <select id="yearly_revenue" class="form-control" name="yearly_revenue">
                                            <option value="">Select...</option>
                                            @foreach(App\Models\PriceHelper::all() as $helper)
                                            <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <strong class="text-center">OR</strong> &nbsp; specific sales revenue
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input id="yearly_revenu_exact" class="form-control" placeholder="Yearly sales revenue" value="" name="yearly_revenue_exact">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-md-3"><label class="control-label" for="cash_flow">Cash Flow</label></div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div><span class="caret select-caret"></span>
                                        <select id="cash_flow" class="form-control" name="cash_flow">
                                            <option value="">Select...</option>
                                            @foreach(App\Models\PriceHelper::all() as $helper)
                                            <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <strong class="text-center">OR</strong> &nbsp; specific cash flow
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input id="cash_flow_exact" class="form-control" placeholder="Cash flow" name="cash_flow_exact">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-md-3"><label class="control-label" for="operation_cost">Operation Cost</label></div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group"><div class="input-group-addon">$</div><span class="caret select-caret"></span>
                                        <select id="operation_cost" class="form-control" name="operation_cost">
                                            <option value="">Select...</option>
                                            @foreach(App\Models\PriceHelper::all() as $helper)
                                            <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <strong class="text-center">OR</strong> &nbsp; specific operation cost
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input id="operation_cost_exact" class="form-control" placeholder="Operation cost" name="operation_cost_exact">
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
            <h4>Operations</h4>
            <div class="well">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label" for="founding_year">Business start year</label></div>
                        <div class="col-md-8">
                            <select id="founding_year" class="form-control" name="founding_year">
                                @foreach(range(2015, 1910) as $index)
                                <option value="{{$index}}">{{$index}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"><label class="control-label" for="company_website">Company Website</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="company_website" class="form-control" value="{{ Input::old('company_website') }}" name="company_website" placeholder="Please write your business website">
                            <div class="hint-block">Add the website address of your business here.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"><label class="control-label" for="employee_no">Number of Employees</label>
                        </div>
                        <div class="col-md-8">
                            <input id="employee_no" type="number" value="{{ Input::old('employee_no') }}" placeholder="Number of employees" class="form-control" name="employee_no">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label" for="expansion_potential">Expansion Potential </label>
                        </div>
                        <div class="col-md-8">
                            <textarea rows="3" id="expansion_potential" class="form-control" name="expansion_potential" placeholder="Briefly explain the expansion potential of your business">{{ Input::old('expansion_potential') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"><label class="control-label" for="relocatable">Is this business Relocatable?</label></div><div class="col-md-8"><select id="relocatable" class="form-control" name="relocatable">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Additional Details</h4>
                    <div class="well">
                        <div class="form-horizontal">
                            <div class="form-group required">
                                <div class="col-md-4">
                                    <label class="control-label" for="reason">Reason for selling?</label>
                                </div>
                                <div class="col-md-8">
                                    <textarea id="reason" class="form-control" name="reason" rows="3" placeholder="Please write why you sell your business">{{ Input::old('reason') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="assets_included">Selling price includes assets?</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="assets_included" class="form-control" name="assets_included">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="assets_worth">Assets Worth</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input id="assets_worth" class="form-control" placeholder="Rough estimate of assets worth in USD" name="assets_worth">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label class="control-label" for="partial_sale">Are you open to selling part of the business?</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="partial_sale" class="form-control" name="partial_sale">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Next</button>
            </div>
        </form>
    </div>
    <!-- business_create -->
</div>

@stop

@section('footerscripts')

<script type="text/javascript">

    //bind the function to the input
    document.getElementById("photos").addEventListener("change",previewImages,false);

    function previewImages(){
        var fileList = this.files;
        var anyWindow = window.URL || window.webkitURL;
        if(fileList.length > 0)
        {
            $('.preview-area').html('');
        }
        for(var i = 0; i < fileList.length; i++){
            //get a blob to work with
            var objectUrl = anyWindow.createObjectURL(fileList[i]);
            // for the next line to work, you need something class="preview-area" in your html
            $('.preview-area').append('<img class="pthumb" src="' + objectUrl + '" />');
            // get rid of the blob
            window.URL.revokeObjectURL(fileList[i]);
        }
    }

</script>

@stop