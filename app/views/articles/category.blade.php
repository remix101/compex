@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'Viewing All Articles in '.ucwords($category->name))

@section('content')

<div class="container">
    <div class="row">
        @include('articles.sidebar')
        <div class="headline">
            <h2>Viewing Articles for {{ ucwords($category->name) }}s</h2>
        </div><!-- headline -->
        <div class="col-sm-12 col-md-9 col-lg-9" style="padding:12px">
            @foreach($articles as $a)
            <div class="col-xs-12" style="margin-bottom:10px">
                <div class="media">
                    <a class="pull-left" href="{{ url('articles/'.$a->slug) }}">
                        <img class="media-object image-respsonsive" src="{{ $a->featuredImage }}" alt="{{ $a->title }}" height="120px" width="120px">
                    </a>
                    <div class="media-body">
                        <a href="{{ url('articles/'.$a->slug) }}">
                            <h6 class="media-heading">{{ $a->title }}</h6>
                        </a>
                        <!-- Nested media object -->
                        <div class="media">
                            {{ Str::limit(strip_tags($a->html), 120) }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <ul class="pagination">
                {{ $articles->links() }}
            </ul>
        </div>
    </div>
</div>

@stop