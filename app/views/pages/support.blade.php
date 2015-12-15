@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'Support | CompanyExchange')

@section('content')

<div class="container">
    <div id="page-header" class="page-header_business">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="page-header_business__text">Support</h1>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </div>

    <div class="row contact-form-container">
        <div class="col-md-12">
            <br>
            <hr>
        </div>
        <div class="col-md-6">
            <h4>Contact Us</h4>
            <hr>
            <form class="form-horizontal" method="post" action="{{ url('support') }}">
                @if(isset($errors))
                @foreach ($errors->all() as $e)
                <div class="alert alert-dismissible alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    {{ $e }}
                </div>
                @endforeach
                @endif
                @if(isset($success))
                <div class="alert alert-dismissible alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    {{ $success }}
                </div>
                @endif
                @if(isset($error))
                <div class="alert alert-dismissible alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                    {{ $error }}
                </div>
                @endif
                <div class="form-group">
                    <label class="control-label col-md-3" for="fname">Your Name <small class="red">Required</small></label>
                    <div class="col-md-9">                        
                        <input class="form-control" data-invalid="" id="fname" maxlength="30" name="name" placeholder="Your Name" required="" type="text" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3" for="email">Your Email Address <small class="red">Required</small></label>
                    <div class="col-md-9">
                        <input class="form-control" data-invalid="" id="txtEmail" name="email" pattern="email" placeholder="Your Email Address" required="" type="email" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3" for="phone">Phone <small>Optional</small></label>
                    <div class="col-md-9">
                        <input class="form-control" id="inputPhone" maxlength="17" name="phone_number" placeholder="Your Phone number" type="text" value="" />                     
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3" for="message">Your Message <small class="red">Required</small></label>
                    <div class="col-md-9">
                        <textarea class="form-control" cols="30" data-invalid="" id="message" name="message" placeholder="Your Message" required="" rows="5"></textarea>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group pull-right">
                    <input type="submit" value="Submit" class="button button-red small radius" />
                </div>
            </form>
        </div>
        <div class="col-md-6 quick-contacts">
            <div class="qcontact-item">
                <h4>Partnerships</h4>
                <hr>
                <p>You think we can do business together. Let us know how at .<br>
                    <a href="mailto:marketing@listings.ng.cx">marketing@listings.ng.cx</a></p>
            </div>
            <div class="qcontact-item">
                <h4>Subscriptions</h4>
                <p>Thinking of CompanyExchange subscription, drop us a line at<br>
                    <a href="mailto:sales@listings.ng.cx">sales@listings.ng.cx</a></p>
            </div>
            <div class="qcontact-item">
                <h4>Already Subscribed</h4>
                <p>Tell us about your updates and concerns at.<br>
                    <a href="mailto:business@listings.ng.cx">business@listings.ng.cx</a></p>
            </div>
            <div class="qcontact-item">
                <h4>Share with Us</h4>
                <p>Have something to share with us but don't know where? No Wahala. Contact us at <br>
                    <a href="mailto:info@listings.ng.cx">info@listings.ng.cx</a></p>
            </div>
        </div>
    </div>
</div>

@stop

@section('footerscripts')

{{ HTML::style("vendor/intl-phone/css/intlTelInput.css", ['property' => 'stylesheet']) }}
{{ HTML::script("vendor/intl-phone/js/intlTelInput.min.js") }}
{{ HTML::script("app.js") }}

@stop