@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'Advanced Search')

@section('content')

<div class="container">
    <h3>Advanced Search</h3>
    <hr>
    <div class="widget widget-main-search">
        <div class="advance_search well">

            <form id="w0" action="{{ url('search/advanced') }}" method="post">
                <input type="hidden" name="_csrf" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <div class="form-group field-query">
                            <label class="control-label" for="keyword">Keyword</label>
                            <input type="text" id="keyword" class="form-control" name="keyword" value="" placeholder="ex. Restaurant">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="control-label" for="categoryID">Category</label>
                            <select id="categoryID" class="form-control" name="category">
                                <option value="">Any</option>
                                @foreach(App\Models\Category::all() as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach                            
                            </select>

                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label class="control-label" for="country">Country</label>
                            <select id="country" class="form-control" name="country">
                                <option value="">Select ...</option>
                                @foreach(App\Models\Country::all() as $c)
                                <option value="{{$c->id}}" {{ $c->id == 36 ? 'selected' : '' }} >{{$c->name}}</option>
                                @endforeach
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="prop_status">Property Status</label>
                            <select id="property_status" class="form-control" name="property_status">
                                <option value="">Any</option>
                                <option value="1">Real Property</option>
                                <option value="2">Lease</option>
                                <option value="3">Both</option>
                            </select>
                        </div>                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="ask_price">Ask Price</label><div class="input-group mb-20"><div class="input-group-addon">$</div><span class="caret select-caret"></span>
                            <select id="ask_price" class="form-control" name="ask_price">
                                <option value="">Any</option>
                                @foreach(App\Models\PriceHelper::all() as $helper)
                                <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="annual_sales_revenue">Annual Sales Revenue</label><div class="input-group mb-20"><div class="input-group-addon">$</div><span class="caret select-caret"></span>
                            <select id="annual_sales_revenue" class="form-control" name="annual_sales_revenue">
                                <option value="">Any</option>
                                @foreach(App\Models\PriceHelper::all() as $helper)
                                <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                @endforeach
                            </select></div>
                        </div>                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="annual_cash_flow">Annual Cash Flow</label><div class="input-group mb-20"><div class="input-group-addon">$</div><span class="caret select-caret"></span>
                            <select id="annual_cash_flow" class="form-control" name="annual_cash_flow">
                                <option value="">Any</option>
                                @foreach(App\Models\PriceHelper::all() as $helper)
                                <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                @endforeach
                            </select></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="annual_operation_cost">Annual Operation Cost</label>
                            <div class="input-group mb-20">
                                <div class="input-group-addon">$</div><span class="caret select-caret"></span>
                                <select id="annual_operation_cost" class="form-control" name="annual_operation_cost">
                                    <option value="">Any</option>
                                    @foreach(App\Models\PriceHelper::all() as $helper)
                                    <option value="{{ $helper->id }}">{{ $helper->text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <button type="submit" class="btn btn-default adv-search-submit btn-block">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- advance_search -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h2>Business matches your search criteria</h2>
            </div>
            <!-- headline -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->
    <div class="row ajaxrow">                
        @if(count($results))
        @foreach($results as $listing)
        <div class="col-sm-6 col-md-3 col-xs-12">
            <a href="{{ $listing->url }}">
                <div class="blog-article">
                    <div class="blog-article-thumbnail" style="background-image: url('{{ $listing->thumbnail }}')">
                    </div><!-- blog-article-thumbnail -->
                    <div class="blog-article-date">${{$listing->askingPrice}}</div>
                    <div class="blog-article-details blog-article-details_with-more text-center">
                        <h5><a href="{{ $listing->url }}">{{ $listing->heading }}</a></h5>
                        <p><a href="#">{{ $listing->location }}</a></p>
                    </div><!-- blog-article-details -->
                    <div class="text-center"><a class="btn btn-white" href="{{ $listing->url }}">View</a></div>
                </div><!-- blog-article -->
            </a>
        </div>
        @endforeach
        <div class="clearfix"></div>
        <ul class="pagination">
            {{ $results->links() }}
        </ul>
        @else
        <div class="col-sm-12">
            <h4 class="text-center">No results found for "{{ Input::get('q') }}". Please try again</h4>
        </div>
        @endif
    </div>
</div>

@stop

@section('footerscripts')

@stop