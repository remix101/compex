@extends('layouts.seller')

@section('title', 'Edit Listing')

@section('content')

<div class="container no-pad">
</div>
<div class="container">
    <div class="business_create">
        <h1>Edit business listing: {{$listing->heading}}</h1>
        <form id="w0" action="{{ url('sellers/listings/edit/'.$listing->id) }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

                    <h4>Business details</h4>
                    <div class="well">
                        <div class="form-group required">
                            <label class="control-label" for="category_id">Business Category</label>
                            <select id="category_id" class="form-control" name="category">
                                @foreach(App\Models\Category::all() as $cg)
                                <option value="{{ $cg->id }}" {{ $cg->id == $listing->category ? "selected" : "" }}>{{ $cg->name }}</option>
                                @endforeach
                            </select>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="name">Listing Headline</label>
                            <input type="text" id="heading" class="form-control" name="heading" placeholder="Enter listing headline" value="{{ $listing->heading }}">
                            <div class="hint-block">This will appear as the main headline for your listing. For example, "Successful Devon Hotel and Restaurant For Sale".</div>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="desc">Business Description</label>
                            <textarea id="desc" class="form-control" name="description" rows="6" placeholder="Please write your business description">{{ $listing->description }}</textarea>
                            <div class="hint-block">Highlight the selling points of the business for sale. Say as much or as little as you want.</div>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="photos">Supporting Documents/Photos</label>
                            <input id="photos" type="file" multiple="multiple" class="form-control" name="photos[]">
                            <div class="hint-block">Select single or multiple documents supporting your listing. You may chose to do this later</div>
                            <div class="help-block"></div>
                            <div class="preview-area">
                                @foreach($listing->photos as $photo)
                                <div class="pthumb-container" data-id="{{ $photo->id }}" >
                                    <img id="image_upload_preview" class="pthumb" src="{{ $photo->url }}" alt="{{ $listing->heading }}" />
                                    <a href="#" class="remove" title="Remove image"><span class="fa fa-times"></span></a>
                                    <input type="hidden" name="photos_kept[]" value="{{ $photo->id }}" />
                                </div>
                                @endforeach
                            </div>
                            <div class="clearfix"></div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="country">Country</label>
                                    <select id="country" class="form-control" name="country">
                                        @foreach(App\Models\Country::all() as $c)
                                        <option value="{{ $c->id }}"{{ $listing->country == $c->id ? 'selected' : '' }}>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="state">State</label>
                                    <input id="state" class="form-control" name="state" type="text" value="{{ $listing->state }}">
                                    <div class="help-block">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label class="control-label" for="city">City</label>
                                    <input type="text" id="city" value="{{ $listing->city }}" class="form-control" name="city" placeholder="Please enter name of city where your business is located">
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
                                            <option value="{{ $helper->id }}" {{ $listing->ask_price != null && $helper->id == $listing->ask_price ? "selected" : "" }}>{{ $helper->text }}</option>
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
                                        <input id="ask_price_exact" class="form-control" placeholder="Asking price" name="ask_price_exact" value="{{ $listing->ask_price_exact != null ? $listing->ask_price_exact : "" }}">
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
                                            <option value="{{ $helper->id }}"{{ $listing->yearly_revenue != null && $helper->id == $listing->yearly_revenue ? "selected" : "" }}>{{ $helper->text }}</option>
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
                                        <input id="yearly_revenu_exact" class="form-control" placeholder="Yearly sales revenue" value="{{ $listing->yearly_revenue_exact != null ? $listing->yearly_revenue_exact : "" }}" name="yearly_revenue_exact">
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
                                            <option value="{{ $helper->id }}"{{ $listing->cash_flow != null && $helper->id == $listing->cash_flow ? "selected" : "" }}>{{ $helper->text }}</option>
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
                                        <input id="cash_flow_exact" class="form-control" placeholder="Cash flow" name="cash_flow_exact" value="{{ $listing->cash_flow_exact != null ? $listing->cash_flow_exact : "" }}">
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
                                            <option value="{{ $helper->id }}"{{ $listing->operation_cost != null && $helper->id == $listing->operation_cost ? "selected" : "" }}>{{ $helper->text }}</option>
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
                                        <input id="operation_cost_exact" class="form-control" placeholder="Operation cost" name="operation_cost_exact" value="{{ $listing->operation_cost_exact != null ? $listing->operation_cost_exact : "" }}">
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
                            <select id="founding_year" class="form-control" name="year_founded">
                                @foreach(range(2015, 1910) as $index)
                                <option value="{{$index}}" {{ $listing->year_founded == $index ? "selected" : "" }}>{{$index}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"><label class="control-label" for="company_website">Company Website</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="company_website" class="form-control" value="{{ $listing->company_website }}" name="company_website" placeholder="Please write your business website">
                            <div class="hint-block">Add the website address of your business here.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"><label class="control-label" for="employee_no">Number of Employees</label>
                        </div>
                        <div class="col-md-8">
                            <input id="employee_no" type="number" value="{{ $listing->employee_no }}" placeholder="Number of employees" class="form-control" name="employee_no">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label" for="expansion_potential">Expansion Potential </label>
                        </div>
                        <div class="col-md-8">
                            <textarea rows="3" id="expansion_potential" class="form-control" name="expansion_potential" placeholder="Briefly explain the expansion potential of your business">{{ $listing->expansion_potential }}</textarea>
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
                                    <textarea id="reason" class="form-control" name="reason" rows="3" placeholder="Please write why you sell your business">{{ $listing->reason }}</textarea>
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
                                        <option value="1" {{ $listing->partial_sale == 1 ? "selected" : "" }}>Yes</option>
                                        <option value="0" {{ $listing->partial_sale == 1 ? "selected" : "" }}>No</option>
                                    </select>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Update</button>
            </div>
        </form>
    </div>
    <!-- business_create -->
</div>

@stop

@section('footerscripts')

<script type="text/javascript">

    $(document).on('click', '.pthumb-container .remove', function(e){
        e.preventDefault();        
        var deleter = $(this);
        swal({
            title: "Delete image?",
            text: "You are about to delete the selected image from your listing",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false}, function(isConfirm) {
            if (isConfirm) {
                deleter.closest('.pthumb-container').remove();
            }
        });
    });

    var storedFiles = [];
    
    //bind the function to the input
    document.getElementById("photos").addEventListener("change",previewImages,false);

    function previewImages(e){
        
        //remove all new image uploads from preview
        $('.nfile').remove();
        
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        
        filesArr.forEach(function(f) {			

            if(!f.type.match("image.*")) {
                return;
            }
            //storedFiles.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
                var html = '<div class="nfile pthumb-container"><img src="' + e.target.result + '" class="pthumb" data-file="'+f.name+'"/></div>';
                $('.preview-area').append(html);
            }
            reader.readAsDataURL(f); 
        });
    }

</script>

@stop