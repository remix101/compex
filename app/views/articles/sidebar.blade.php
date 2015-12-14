<div class="col-sm-12 col-md-3 col-lg-3 left-sidebar">
    <div class="widget widget-search">

        <form name="search" method="get" action="{{ url('articles') }}">
            <fieldset>
                <input type="search" name="q" value="{{ Input::get('q') }}" placeholder="search...">
                <input type="submit" value="">
            </fieldset>
        </form>

    </div>
    <div class="widget widget-recent-posts">
        <h6 class="widget-title">Top Articles</h6>
        <ul>
            @foreach(App\Models\Article::desc('views')->take(5)->get() as $a)
            <li>
                <a class="post-title" href="{{ url('articles/'.$a->slug) }}">{{ $a->title }}</a><br>
                <a class="post-date" href="{{ url('articles/'.$a->slug) }}">{{ $a->created_at->diffForHumans() }}</a><br>
                <a class="read-more" href="{{ url('articles/'.$a->slug) }}">Read more</a>
            </li>
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