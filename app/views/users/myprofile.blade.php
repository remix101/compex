@extends(!$user->isBuyer() ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'My Profile')

@section('content')

<div class="container">
    <div class="ui-31">
        <!-- UI content -->
        <div class="col-md-3">
            <div class="team">
                <div class="team-member">
                    <!-- Member image area -->
                    <div class="img-container">
                        <!-- image -->
                        <img class="img-responsive" src="{{ $user->getPhoto() }}" alt="" />
                    </div>
                    <!-- Name -->
                    <h2>{{ $user->title . ' ' . $user->fullName }}</h2>
                    <hr class="bg-red" />
                    <!-- Team member details -->
                    <div class="member-dtls">
                        <ul class="list-unstyled">
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-female"></i> Country</h3>
                                    <span class="pull-right minfo">{{ $user->profile ? $user->profile->getCountry->name : 'Not provided' }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-envelope"></i> Email</h3>
                                    <span class="pull-right minfo"><a href="#">{{ $user->email }}</a></span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-phone"></i> Personal Phone</h3>
                                    <span class="pull-right minfo">{{ $user->profile ? $user->profile->phone_number : 'Not provided' }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-child"></i> Account Type</h3>
                                    <span class="pull-right minfo">{{ ucwords($user->role->name) }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-calendar"></i> Registered</h3>
                                    <span class="pull-right minfo">{{ $user->created_at->diffForHumans() }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-map-marker"></i> Address</h3>
                                    <span class="pull-right minfo">{{ $user->profile ? $user->profile->address : 'Not provided' }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row ajaxrow">
                @if($user->isSeller() || $user->isBroker())
                @if($user->profile->listings()->count() > 0)
                <div class="col-md-12">
                    <h4>My recent listings</h4>
                </div>
                @foreach($user->profile->listings()->take(5)->get() as $listing)
                <div class="col-sm-6 col-md-3 col-xs-12">
                    <a href="{{ $listing->url }}">
                        <div class="blog-article">
                            <div class="blog-article-thumbnail" style="background-image: url('{{ $listing->thumbnail }}')">
                            </div>
                            <div class="blog-article-date">${{$listing->askingPrice}}</div>
                            <div class="blog-article-details blog-article-details_with-more text-center">
                                <h5><a href="{{ $listing->url }}">{{ $listing->heading }}</a></h5>
                                <p><a href="#">{{ $listing->location }}</a></p>
                            </div><!-- blog-article-details -->
                            <div class="text-center"><a class="btn btn-white" href="{{ $listing->url }}">View</a></div>
                        </div><!-- blog-article -->
                    </a>
                </div>
                @endforeach
                @else
                <div class="col-sm-12">
                    <h4 class="text-center">You have no listings yet</h4>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
<!-- UI thirty one end -->

@stop