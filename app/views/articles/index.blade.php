@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'Viewing All Articles')

@section('content')

<div class="container">
    <div class="row">
        <div class="headline">
            <h2>All Articles</h2>
        </div><!-- headline -->
        @include('articles.sidebar')
        <div class="col-sm-12 col-md-9 col-lg-9">
            <?php $articles = App\Models\Article::paginate(24); ?>
            @foreach($articles as $a)
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="media">
                    <a class="pull-left" href="{{ url('articles/'.$a->slug) }}">
                        <img class="media-object" src="{{ $a->featuredImage }}" height="84" width="84">
                    </a>
                    <div class="media-body">
                        <a href="{{ url('articles/'.$a->slug) }}">
                            <h6 class="media-heading">{{ $a->title }}</h6>
                        </a>
                        <!-- Nested media object -->
                        <div class="media">
                            {{ Str::limit(strip_tags($a->html), 80) }}
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