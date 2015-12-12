@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'Viewing Article | ' .$article->title)

@section('content')

<div class="container">
    @include('articles.sidebar')
    <div class="col-sm-12 col-md-9 col-lg-9">
        <h1>{{ $article->title }}</h1>
        <p class="lead">
            Recommended for: <a href="{{ url('articles/'.$article->category->name.'s') }}">{{ ucwords($article->category->name) }}s</a>
        </p>
        <hr>
        <p><span class="fa fa-clock"></span> Posted {{ $article->created_at->diffForHumans() }}</p>
        <hr>
        <img class="img-responsive" src="{{ $article->featuredImage }}" alt="{{ $article->title }}">
        <hr>
        <!-- Post Content -->
        <div class="post-content">
            {{ $article->html }}
        </div>
    </div>
</div>

@stop