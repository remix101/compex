<div class="col-sm-12 col-md-3 left-sidebar">
    <div class="widget widget-search">

        <form name="search" id="sidesearch" method="get" action="{{ url('search') }}">
            <fieldset>
                <input type="search" name="q" value="{{ Input::get('q') }}" placeholder="search...">
                <input type="submit" value="">
            </fieldset>
        </form>

    </div>
    <div class="widget widget-categories form-horizontal">
        <h6 class="widget-title">Filter By</h6>
        <ul>
            <li>
                Category: <select id="catselect" class="form-control">
                <option value="" selected>Any</option>
                @foreach(App\Models\Category::all()->sortByDesc('Listings') as $c)
                <option value="{{$c->id}}"{{ (Input::get("category") && Input::get("category") == $c->id) ? 'selected' : '' }}>{{$c->name}}</option>
                @endforeach
                </select>
            </li>
            <li>
                Country: <select id="conselect" class="form-control">
                <option value="" selected>Any</option>
                @foreach(App\Models\Country::all()->sortByDesc('Listings') as $c)
                <option value="{{$c->id}}"{{ (Input::get("country") && Input::get("country") == $c->id) ? 'selected' : '' }}>{{$c->name}}</option>
                @endforeach
                </select>
            </li>
        </ul>
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
        <h6 class="widget-title">Latest Listings</h6>
        <ul>
            @foreach(App\Models\Listing::verified()->desc('created_at')->take(5)->get() as $l)
            <li>
                <a class="post-title" href="{{ url('listings/'.$l->slug) }}">{{ $l->heading }}</a><br>
                <a class="post-date" href="{{ url('listings/'.$l->slug) }}">{{ $l->created_at->diffForHumans() }}</a><br>
                <a class="read-more" href="{{ url('listings/'.$l->slug) }}">Read more</a>
            </li>
            @endforeach
        </ul>

    </div>
</div>
