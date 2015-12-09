@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

<?php $query = Input::get('q') ?>
@section('title',  $query ? $query .' | Search Results' : 'All Listings')

@section('content')

<div class="container">
    <div class="row search">
        @include('search.sidebar')
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="row">
                <div class="col-sm-12">
                    <div class="headline tiny">
                        <h3>Viewing business listings in {{ $category->name }}</h3>
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
                            </div>
                            <div class="blog-article-date">${{$listing->askingPrice}}</div>
                            <div class="blog-article-details blog-article-details_with-more text-center">
                                <h5><a href="{{ $listing->url }}">{{ $listing->heading }}</a></h5>
                                <p>{{ $listing->location }}</p>
                            </div><!-- blog-article-details -->
                            <div class="text-center"><a class="btn btn-white" href="{{ $listing->url }}">View</a></div>
                        </div><!-- blog-article -->
                    </a>
                </div>
                @endforeach
                <ul class="pagination">
                    {{ $results->links() }}
                </ul>
                @else
                <div class="col-sm-12">
                    <h4 class="text-center">No listings found for category "{{ $category->name }}". Please try again</h4>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@stop

@section('footerscripts')

@stop