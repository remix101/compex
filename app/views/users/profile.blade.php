@extends((Auth::check() && !$user->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', $usr->fullName. "'s Profile | CompanyExchange")

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
                        <img class="img-responsive" src="{{ $usr->getPhoto() }}" alt="" />
                    </div>
                    <!-- Name -->
                    <h2>{{ $usr->title . ' ' . $usr->fullName }}</h2>
                    <hr class="bg-red" />
                    <!-- Team member details -->
                    <div class="member-dtls">
                        <ul class="list-unstyled">
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-female"></i> Country</h3>
                                    <span class="pull-right minfo">{{ $usr->profile ? $usr->profile->getCountry->name : 'Not provided' }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-envelope"></i> Email</h3>
                                    <span class="pull-right minfo"><a href="#">{{ $usr->email }}</a></span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-phone"></i> Personal Phone</h3>
                                    <span class="pull-right minfo">{{ $usr->profile ? $usr->profile->phone_number : 'Not provided' }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-child"></i> Account Type</h3>
                                    <span class="pull-right minfo">{{ ucwords($usr->role->name) }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-calendar"></i> Registered</h3>
                                    <span class="pull-right minfo">{{ $usr->created_at->diffForHumans() }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            @if($usr->isBroker())
                            <li>
                                <!-- Member details list item -->
                                <div class="list-item">
                                    <h3 class="pull-left"><i class="fa fa-map-marker"></i> Address</h3>
                                    <span class="pull-right minfo">{{ $usr->profile ? $usr->profile->address : 'Not provided' }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row ajaxrow">
                @if($usr->isSeller() || $usr->isBroker())
                @if($usr->profile->listings()->count() > 0)
                <div class="col-md-12">
                    <h4>Recent listings by {{ $usr->role->name }}</h4>
                </div>
                @foreach($usr->profile->listings()->take(5)->get() as $listing)
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
                    <h4 class="text-center">{{ ucwords($usr->role->name) }} has no listings yet</h4>
                </div>
                @endif
                @elseif($usr->isBuyer() && $usr->profile->adverts()->count() > 0)
                <div class="col-md-12">
                    <h4>Recent businesses wanted by {{ $usr->role->name }}</h4>
                </div>
                <div class="search-table table-responsive">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead class="bg-blue">
                            <tr>
                                <th>Category</th>
                                <th>Headline</th>
                                <th>Description</th>
                                <th><a href="javascript:;"></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usr->profile->adverts()->take(5)->get() as $advert)
                            <tr>
                                <td class="table-category">
                                    <a href="javascript:;">{{ $advert->categoryName }}</a>
                                    <p>Posted:
                                        <span class="font-grey-cascade">{{ $advert->created_at->diffForHumans() }}</span>
                                    </p>
                                </td>
                                <td class="table-title">
                                    <h5>
                                        <a href="javascript:;">
                                            <i class="fa fa-arrow-right font-blue"></i><span id="heading">{{$advert->heading}}</span> 
                                        </a>
                                    </h5>
                                </td>
                                <td class="table-desc"> {{ $advert->description }}</td>
                                <td class="table-status">
                                    <a href="javascript:;" class="bcontact" data-owner="{{ $advert->user->id }}" data-id="{{ $advert->id }}" data-toggle="modal" data-target="#fastcontact">
                                        <i class="fa fa-envelope font-green-soft"></i> Contact Buyer
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- UI thirty one end -->

@stop