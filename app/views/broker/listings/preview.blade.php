@extends('layouts.broker')

@section('title', 'Viewing Listing : '.$listing->heading . ' | CompanyExchange')

@section('content')

<div class="container no-pad">
    <ul class="list-unstyled">
        <li>
            <a href="{{ url('listings/categories/'.$listing->id) }}">{{ $listing->categoryName }}</a>
        </li>
    </ul>
</div>
<div id="page-header" class="page-header_business">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header_business__text">{{ $listing->heading }}</h1>
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- container -->
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="blog-article">
                <div class="blog-article-thumbnail blog-article-thumbnai_in-view">
                    <img src="{{ $listing->thumbnail }}" alt="">
                    @if($listing->photos->count() > 0)
                    <ul class="list-unstlyed" style="padding: 4px">
                        @foreach($listing->photos()->get() as $photo)
                        <li>
                            <a href="{{ $photo->url }}" class="gallery-item fancybox" rel="businessGallery">
                                <img src="{{ $photo->url }}" alt="{{ $photo->photo_caption }}">
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div class="blog-article-date">{{ $listing->askingPrice }} {{ $listing->assets_included ? '(Assets inclusive)' : '' }}</div>
                <div class="blog-article-details">
                    <p>
                        @if($listing->assets_included)
                        <b>Assets Worth: {{ $listing->assetWorth }}</b>
                        @endif
                    </p>
                    <div>
                        <span>
                            @if(Auth::check())
                            <a class="btn btn-green btn-lg" data-toggle="modal" data-target="#fastcontact"><i class="fa fa-envelope mr-5"></i>Contact Seller</a>
                            @else
                            <a class="btn btn-green btn-lg" href="#contact"><i class="fa fa-envelope mr-5"></i>Contact Seller</a>
                            @endif
                        </span>
                    </div>
                    <div class="text-box rounded default">
                        {{ $listing->description }}
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>{{ $listing->location }}</h5>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <h6>Property and financial details</h6>
                            <ul class="check-list blue mt-20">
                                <li>Asking Price: <b> {{ $listing->askingPrice }}</b></li>
                                <li>Annual Sales revenue: <b> {{ $listing->salesRevenue }}</b></li>
                                <li>Annual cash flow: <b> {{ $listing->cashFlowText }}</b></li>
                                <li>Annual operation cost: <b> {{ $listing->operationCostText }}</b></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Operations</h6>
                            <ul class="check-list blue mt-20">
                                <li>Property Status: <b> {{ $listing->status }}</b></li>
                                <li>Business start year: <b>{{ $listing->year_founded }}</b></li>
                                <li>Number of Employees: <b>{{ $listing->employee_no }}</b></li>
                                <li>Business <b>is {{ $listing->relocatable ? '' : 'not '}}</b>relocatable</li>
                            </ul>
                        </div>
                    </div>
                    @if($listing->expansion_potential != '')
                    <h5>Expansion</h5>
                    <p>{{ $listing->expansion_potential }}</p>
                    @endif
                    <ul class="check-list blue mt-20">
                        <li>Reason for selling: <b>{{ $listing->reason }}</b></li>
                        <li>Owner <b>{{ $listing->partial_sale ? "considers" : "doesn't consider"}} partial sale</b></li>
                    </ul>
                </div>
            </div>
            <div class="well">
                <h4 id="contact">Contact Seller: </h4>
            </div>
            <div class="mt-20 mb-20">
                <div class="business-contact-form">
                    @if(Auth::check())
                    <div action="{{ url('messages/compose') }}" method="post" class="form-horizontal col-sm-12">
                        <p class="help-block pull-left text-danger hide" id="form-error">&nbsp; Something went wrong. </p>
                        <div class="form-group">
                            <h4>Please specify additional info you require from seller.</h4>
                            <input type="hidden" value="{{ $listing->user->id }}" name="recipient_id">
                            <input type="hidden" value="{{ $listing->id }}" name="listing_id">
                            <textarea name="message" class="form-control" rows="4" placeholder="Please type a message..." data-placement="top" data-trigger="manual" required>Hi, Please provide additional information about {{$listing->heading}}</textarea>
                            <p class="text-info">Included Listing: {{$listing->heading}}</p>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success pull-right">Send</button>
                        </div>
                    </div>

                    @else
                    <div id="w0" action="{{ url('messages/compose') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    <label class="control-label" for="firstname">First Name</label>
                                    <input type="text" id="firstname" class="form-control" value="{{Input::old('first_name')}}" name="first_name" placeholder="Please write your first name" required>
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    <label class="control-label" for="lastname">Last Name</label>
                                    <input type="text" id="lastname" class="form-control" value="{{Input::old('last_name')}}" name="last_name" placeholder="Please write your last name" required>
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    <label class="control-label" for="inputEmail">Email</label>
                                    <input type="text" maxlength="50" class="form-control" value="{{Input::old('email')}}" name="email" id="inputEmail" placeholder="Enter an email to use in accessing your account" required>
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    <label class="control-label" for="phone">Phone</label>
                                    <input type="text" maxlength="17" class="form-control" value="{{Input::old('phone_number')}}" name="phone_number" id="inputPhone" placeholder="Use international format, e.g. +234 809 901 9404">
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group field-contactform-message required">
                                    <h4>Please specify additional info you require from seller.</h4>
                                    <input type="hidden" value="{{ $listing->user->id }}" name="recipient_id">
                                    <input type="hidden" value="{{ $listing->id }}" name="listing_id">
                                    <label class="control-label" for="contactform-message">Message</label>
                                    <textarea name="message" class="form-control" rows="4" placeholder="Please type a message..." data-placement="top" data-trigger="manual" required>Hi, Please provide additional information about {{$listing->heading}}</textarea>
                                    <p class="text-info">Included Listing: {{$listing->heading}}</p>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                        <!--
<div class="row">
<div class="col-sm-12">
<div class="checkbox field-contactform-agreement required">

<input type="hidden" name="ContactForm[agreement]" value="0"><label><input type="checkbox" id="contactform-agreement" name="ContactForm[agreement]" value="1"> Agreement</label>

<div class="help-block"></div>
</div>
</div>
</div>-->
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Send</button>
                        </div>
                    </div>
                    @endif
                </div><!-- business-contact-form -->
            </div>
        </div><!-- blog-article-author -->
        <div class="col-sm-12 col-md-3 col-lg-3">
            <div class="widget widget-search">

                <div name="search" method="get" action="{{ url('search') }}">
                    <fieldset>
                        <input type="search" name="q" placeholder="search...">
                        <input type="submit" value="">
                    </fieldset>
                </div>

            </div>
            <div class="widget widget-categories">
                <h6 class="widget-title">Top Categories</h6>
                <ul>
                    @foreach(App\Models\Category::with('Listings')->take(6)->get()->sortByDesc('Listings') as $c)
                    <li><a href="{{ url('listings/categories/'.$c->id) }}">{{ $c->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="widget widget-recent-posts">
                <h6 class="widget-title">Latest Articles</h6>
                <ul>
                    @foreach(App\Models\Article::desc('created_at')->take(5)->get() as $a)
                    <li>
                        <a class="post-title" href="{{ url('articles/'.$a->slug) }}">{{ $a->title }}</a><br>
                        <a class="post-date" href="{{ url('articles/'.$a->slug) }}">{{ $a->created_at->diffForHumans() }}</a><br>
                        <a class="read-more" href="{{ url('articles/'.$a->slug) }}">Read more</a>
                    </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@if(Auth::check())
<div id="fastcontact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fastContact" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="applyLabel">Leave a message for this seller</h3>
            </div>
            <div action="{{ url('messages/compose') }}" method="post">
                <div class="modal-body">
                    <p class="help-block pull-left text-danger hide" id="form-error">&nbsp; Something went wrong. </p>
                    <div class="form-group">
                        <h4>Please specify additional info you require from seller.</h4>
                        <input type="hidden" value="{{ $listing->user->id }}" name="recipient_id">
                        <input type="hidden" value="{{ $listing->id }}" name="listing_id">
                        <textarea name="message" class="form-control" rows="4" placeholder="Please type a message..." data-placement="top" data-trigger="manual" required>Hi, Please provide additional information about {{$listing->heading}}</textarea>
                        <p class="text-info">Included Listing: {{$listing->heading}}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right">Send</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

@stop

@section('footerscripts')

{{ HTML::script('assets/js/jquery.fancy-thumbs.js') }}
{{ HTML::style('assets/css/jquery.fancy-thumbs.css') }}

@stop