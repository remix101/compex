@extends((Auth::check() && !$user->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title',  'Broker Directory')

@section('content')

<div class="container">
    <div class="row search">
        @include('search.broker_sidebar')
        <div class="col-sm-12 col-md-9 col-lg-10">
            <div class="row">
                <div class="col-sm-12">
                    <div class="headline tiny">
                        <h3>Viewing broker directory listing</h3>
                    </div>
                    <!-- headline -->
                </div>
                <!-- col -->
            </div>
            @if(count($results))
            <ul class="list-unstyled">
                @foreach($results as $broker)
                <li class="list-item well col-sm-6">
                    <div class="list-icon-container">
                        <h3 class="uppercase">
                            <a href="profile/{{ $broker->user_id }}"><i class="fa fa-angle-right"></i> {{ $broker->user->fullName }}</a>
                        </h3>
                    </div>
                    <div class="list-item-content">
                        <a href="{{ url('inbox/compose/'.$broker->user_id) }}">
                            <i class="fa fa-envelope"></i>  {{ $broker->user->email }}
                        </a>
                    </div>
                    <div class="list-datetime bold uppercase font-red"><i class="fa fa-calendar-o"></i> Member since: {{ $broker->created_at->diffForHumans() }} 
                        <p><i class="fa fa-map-marker"></i>  {{ $broker->address }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
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

@stop

@section('footerscripts')

<script type="text/javascript">
    $('#conselect').on('change', function(){
        location.href = "{{ url('brokers') }}" + '?country=' + $(this).val();
    });
</script>

@stop