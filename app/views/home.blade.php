@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'CompanyExchange')

@section('content')

<section class="full-section dark-section homepage-hero">
    <div class="full-section-overlay-color"></div>
    <div class="full-section-container">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="headline">
                        <h3 class="homepage-hero__title">Welcome to the largest marketplace of businesses for sale in Africa. Find Yours</h3>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->

        <div class="container">
            <div class="row">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="widget widget-main-search">
                        <form name="search" method="get" action="{{ url('search') }}">
                            <fieldset>
                                <input type="text" name="q" placeholder="eg. Restaurant in South Africa" class="main-search">
                                <input class="btn btn-default main-search-btn" type="submit" value="Search">
                            </fieldset>
                        </form>
                        <div class="text-right mt-20">
                            <h5><a href="search/advanced">Advanced Search <i class="fa fa-arrow-right"></i></a></h5>
                        </div>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->

    </div><!-- full-section-container -->

</section>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h2>Recent Listings</h2>
            </div><!-- headline -->
        </div><!-- col -->
    </div><!-- row -->
    <div class="row">
        @foreach(App\Models\Listing::desc('created_at')->take(4)->get() as $listing)
        <div class="col-sm-6 col-md-3 col-xs-6">
            <a href="{{ $listing->url }}" title="{{ $listing->heading }}" class="nodecorate">
                <div class="blog-article">
                    <div class="blog-article-thumbnail" style="background-image: url('{{ $listing->thumbnail }}')">
                    </div><!-- blog-article-thumbnail -->
                    <!-- blog-article-thumbnail -->
                    <div class="blog-article-date">{{ $listing->askingPrice }} USD</div>
                    <div class="blog-article-details blog-article-details_with-more text-center">
                        <h5><span>{{$listing->heading}}</span>
                        </h5>
                        <p>{{ $listing->categoryName }}</p>
                    </div><!-- blog-article-details -->
                    <div class="text-center">
                        <span class="btn btn-white">View</span>
                    </div>
                </div><!-- blog-article -->
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="horizontal-tabs big-tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-6-2" data-toggle="tab"><i class="fa fa-briefcase2"></i>Search by Sector</a></li>
                    <li><a href="#tab-6-3" data-toggle="tab"><i class="fa fa-gps"></i>Search by Country</a></li>
                    <li><a href="#tab-6-6" data-toggle="tab"><i class="fa fa-stars"></i>Top Searches</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab-6-2">
                        <h4>Search by business listing category</h4>
                        <div class="col-sm-12">
                            <ul class="list-unstyled">
                                @foreach(App\Models\Category::with('Listings')->get()->sortByDesc('Listings')->take(10) as $c)
                                <li class="col-sm-6"><a href="{{ url('listings/categories/'.$c->id) }}">{{ $c->name }}</a> ({{$c->listings()->count()}})</li>
                                @endforeach
                            </ul>
                            <a class="btn btn-white pull-right" href="{{ url('search?q=') }}">More</a>
                        </div>
                    </div><!-- tab-pane -->
                    <div class="tab-pane fade" id="tab-6-3">
                        <h4>Business listings by country</h4>
                        <div class="col-sm-12">
                            <ul class="list-unstyled">
                                @foreach(App\Models\Country::with('Listings')->get()->sortByDesc('Listings')->take(10) as $c)
                                <li class="col-sm-6"><a href="{{ url('listings/countries/'.$c->id) }}">{{ $c->name }}</a> ({{$c->listings()->count()}})</li>
                                @endforeach
                            </ul>
                            <a class="btn btn-white pull-right" href="{{ url('search?q=') }}">More</a>
                        </div>
                    </div><!-- tab-pane -->
                    <div class="tab-pane fade" id="tab-6-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="list-unstyled">
                                    @foreach(App\Models\SearchQuery::where('results_count','>','0')->groupBy('search_term')->get() as $query)
                                    <li class="col-sm-6"><a href="{{ url('search?q='.urlencode($query->search_term)) }}">{{ucwords($query->search_term)}}</a> ({{$query->results_count}})</li>
                                    @endforeach
                                </ul>
                                <br>
                                <a class="btn btn-white pull-right" href="{{ url('search?q=') }}">More</a>
                            </div>
                        </div>
                    </div><!-- tab-pane -->
                </div><!-- tab-content -->
            </div>
        </div>
    </div>
</div>
<div class="full-section" id="section-12">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="headline">
                    <h3>About CompanyExchange.com</h3>
                </div><!-- headline -->
                <p>Born out of one man's need to advertise a business for sale, CompanyExchange exists to introduce people who want to buy a business to those who are selling a business. We intend to help business brokers and private sellers market their listings. From cafes to construction businesses, some of our most exciting business opportunities include life changing businesses that can change the way you smile!</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="headline">
            <h2>Advices &amp; Features</h2>
        </div><!-- headline -->
        <div>
            @foreach(App\Models\Article::desc('views')->take(6)->get() as $a)
            <div class="col-md-6 col-lg-4 col-xs-12 mbody">
                <div class="media">
                    <a class="pull-left" href="{{ url('articles/'.$a->slug) }}">
                        <img alt="{{ $a->title }}" class="media-object" src="{{ $a->featuredImage }}" height="84" width="84">
                    </a>
                    <div class="media-body">
                        <a href="{{ url('articles/'.$a->slug) }}">
                            <h6 class="media-heading">{{ $a->title }}</h6>
                        </a>
                        <!-- Nested media object -->
                        <div class="media atext">
                            {{ Str::limit(strip_tags($a->html), 60) }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@stop
