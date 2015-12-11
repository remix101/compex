<div class="col-sm-12 col-md-3 col-lg-2 left-sidebar">
    <div class="widget widget-search">

        <form name="search" method="get" action="{{ url('brokers') }}">
            <fieldset>
                <input type="search" name="q" value="{{ Input::get('q') }}" placeholder="search for brokers...">
                <input type="submit" value="">
            </fieldset>
        </form>
    </div>
    <div class="widget widget-categories">
        <h6 class="widget-title">Filter By Country</h6>
        <ul>
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
        <h6 class="widget-title">Top Brokers</h6>
        <ul>
            @foreach(App\Models\Broker::with('Listings')->take(5)->get()->sortByDesc('Listings') as $b)
            <li><a href="{{ url('profile/'.$b->user_id) }}">{{ $b->user->fullName }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="widget widget-recent-posts">
        <h6 class="widget-title">Latest Listings</h6>
        <ul>
            @foreach(App\Models\Listing::desc('created_at')->take(5)->get() as $listing)
            <li>
                <a class="post-title" href="{{ url('listings/'.$listing->slug) }}#">{{ $listing->heading }}</a><br>
                <a class="post-date" href="#">{{ $listing->created_at->diffForHumans() }}</a><br>
                <a class="read-more" href="{{ url('listings/'.$listing->slug) }}">Read more</a>
            </li>
            @endforeach
        </ul>

    </div>
</div>