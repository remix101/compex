<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="well">
                            <div class="text-center">
                                <h5 class="widget-title">Select your account type</h5>
                                <p>New to CompanyExchange.com? Whether you are a buyer, seller or broker we have a range of services to help you. </p><p>Choose one of options:</p>
                                <ul class="list-unstyled list-inline">
                                    <li><a class="btn btn-green huge-type-btn btn-xl" href="{{ url('register') }}"><i class="glyphicon glyphicon-circle-arrow-down huge-type-btn__icon mr-5"></i>Business buyer</a></li>
                                    <li><a class="btn btn-info huge-type-btn btn-xl " href="{{ url('register/seller') }}"><i class="glyphicon glyphicon-circle-arrow-up huge-type-btn__icon mr-5"></i>Business seller</a></li>
                                    <li><a class="btn btn-warning  huge-type-btn btn-xl" href="{{ url('register/broker') }}"><i class="glyphicon glyphicon-transfer huge-type-btn__icon mr-5"></i>Business broker</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  
<div id="footer">

<div class="container">
<div class="row">
<div class="col-sm-3 col-xs-6">
<div class="widget widget-categories">
<ul>
<li>
<a href="{{ url('listings') }}">Buy a Business</a>
</li>
</ul>
</div>
</div>
<div class="col-sm-3 col-xs-6">
<div class="widget widget-categories">
<ul>
<li><a href="{{ url('sell') }}">Sell a Business</a></li>
</ul>
</div>
</div>
<div class="col-sm-3 col-xs-6">
<div class="widget widget-categories">
<ul>
<li><a href="{{ url('buyer/feature') }}">Advertise a Wanted Business</a></li>
</ul>
</div>
</div>
<div class="col-sm-3 col-xs-6">
<div class="widget widget-categories">
<ul>
<li><a href="{{ url('brokers') }}">Find Business Brokers</a></li>
</ul>
</div>
</div>
</div> row 
</div>
</div> container -->

<div id="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="widget widget-text">
                    <div>
                        <p>CompanyExchange © {{ date('Y') }}. All Rights Reserved</p>
                    </div>
                </div><!-- widget-text -->
            </div><!-- col -->
            <div class="col-sm-3">
                <div class="widget widget-social">
                    <div class="social-media">
                        <a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
                        <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                        <a class="google" href="#"><i class="fa fa-google-plus"></i></a>
                        <a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                    </div><!-- social-media -->
                </div><!-- widget-social -->
            </div>
            <div class="col-sm-5">
                <div class="widget widget-pages">
                    <ul>
                        <li><a href="#">Advertising and Branding</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                </div><!-- widget-pages -->
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- container -->
</div>

{{ HTML::style("assets/css/font-awesome.min.css", ['property' => 'stylesheet']) }}
{{ HTML::script("assets/js/jquery.js") }}
{{ HTML::script("assets/js/custom.js") }}
{{ HTML::script("assets/js/bootstrap.min.js") }}
{{ HTML::script("assets/js/jquery.fancybox.pack.js") }}
{{ HTML::script("assets/js/jquery.validate.min.js") }}
{{ HTML::script('assets/js/flowtype.js') }}
{{ HTML::style("assets/css/sweet-alert.css", ['property' => 'stylesheet']) }}
{{ HTML::script("assets/js/sweet-alert.min.js") }}
<!--[if IE]>
{{ HTML::script('assets/js/polyfill.object-fit.min.js') }}
{{ HTML::style('assets/css/polyfill.object-fit.min.css', ['property' => 'stylesheet']) }}
<![endif]-->

<!-- Include this after the sweet alert js file -->
@include('sweet::alert')
@if(Request::is('search*'))
<script type="text/javascript">

    jQuery(document).ready(function () {

        $('#catselect').on('change', function(e){
            var catId = $(this).val();
            @if(Input::get('category'))
            var cIndex = location.href.indexOf('&category=');
            var eIndex = location.href.indexOf('&', cIndex + 10);
            var href = "";
            console.log(cIndex);
            console.log(eIndex);
            if(eIndex >= 0)
            {
                href = location.href.slice(0, cIndex + 10);
                var pwidth = eIndex - (cIndex + 10 + catId.toString().length);
                href += catId + location.href.slice(cIndex + 10 + catId.toString().length + pwidth);
                console.log(href);
            }
            else
            {
                href = location.href.slice(0, cIndex + 10);
                href += catId;
                console.log(href);
            }
            location.href = href;
            @else
                location = location.href + '&category='+catId;
            @endif
        });
        $('#conselect').on('change', function(e){
            var conId = $(this).val();
            @if(Input::get('country'))
            var cIndex = location.href.indexOf('&country=');
            var eIndex = location.href.indexOf('&', cIndex + 10);
            var href = "";
            console.log(cIndex);
            console.log(eIndex);
            if(eIndex >= 0)
            {
                href = location.href.slice(0, cIndex + 10);
                var pwidth = eIndex - (cIndex + 10 + conId.toString().length);
                href += conId + location.href.slice(cIndex + 10 + conId.toString().length + pwidth);
                console.log(href);
            }
            else
            {
                href = location.href.slice(0, cIndex + 10);
                href += conId;
                console.log(href);
            }
            location.href = href;
            @else
                location = location.href + '&country='+conId;
            @endif
        });
    });
</script>
@endif

<script type="text/javascript">
    $('.blog-article-details h5').flowtype({
        minimum : 500,
        maximum : 1200
    });
    $('.atext').flowtype({
        minimum : 450,
        maximum : 700
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $("form").each(function () { 
            var validator = $(this).validate();
            validator.resetForm();
            $("#reset").click(function () {
                validator.resetForm();
            });
        });
    });
</script>

@yield('footerscripts')