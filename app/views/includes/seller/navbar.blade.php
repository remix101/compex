<!-- HEADER -->
<header>
    <div id="header-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="widget widget-social">
                        <div class="social-media">
                            <a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
                            <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                            <a class="google" href="#"><i class="fa fa-google-plus"></i></a>
                            <a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                        </div><!-- social-media -->
                    </div>
                </div><!-- col -->
                <div class="col-sm-5 text-right">
                    <ul id="menu-top" class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{ url('account') }}" class="dropdown-toggle btn btn-green btn_login" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-user"></i> My Account</a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="">
                                    <a href="{{ url('seller/listings') }}" style="color:#000"><i class="fa fa-bars"></i> My Listings</a>
                                </li>
                                <li class="divider"></li>
                                <li class="">
                                    <a href="{{ url('profile') }}" style="color:#111"><i class="fa fa-user"></i> View Profile</a>
                                </li>
                                <li>
                                    <a href="{{ url('account') }}" style="color:#111"><i class="fa fa-edit"></i> Edit Profile</a>
                                </li>
                                <li>
                                    <a href="{{ url('inbox') }}" style="color:#111"><span class="badge">{{ Session::get('message_count') ? Session::get('message_count') : '' }}</span> <i class="fa fa-envelope"></i> Inbox</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ url('logout') }}" style="color:#111">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </div><!-- header-top -->

    <div id="header">
        <div class="container">
            <div class="row">
                <div class="col-xs-10 col-sm-10 col-lg-3 col-md-4">

                    <!-- LOGO -->
                    <div id="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ url('assets/img/logo.png') }}">
                        </a>
                    </div><!-- logo -->

                </div><!-- col -->
                <div class="col-xs-2 col-sm-2 col-lg-9 col-md-8">
                    <!-- MENU -->
                    <nav>
                        <a id="mobile-menu-button" href="#"><i class="fa fa-bars"></i></a>
                        <ul class="menu clearfix" id="menu">
                            @if(Request::is('seller/*'))
                            <li>
                                <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                            </li>
                            @endif
                            <li class="dropdown">
                                <a href="{{ url('listings') }}">Buy a business</a>
                                <ul>
                                    <li><a href="{{ url('listings') }}">All Listings</a></li>
                                    <li><a href="{{ url('search/advanced') }}">Advanced Search</a></li>
                                    <li><a href="{{ url('businesses') }}">Businesses Wanted</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="{{ url('admin/listings') }}"><i class="fa fa-bars"></i> My Listings</a>
                                <ul>
                                    <li><a href="{{ url('seller/listings/pending') }}">Pending Listings</a></li>
                                    <li><a href="{{ url('seller/listings/approved') }}">Approved Listings</a></li>
                                    <li><a href="{{ url('seller/listings') }}">All Listings</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="{{ url('seller/inbox') }}"><i class="fa fa-envelope"></i> Messages</a>
                                <ul>
                                    <li>
                                        <a href="{{ url('seller/inbox') }}"><span class="badge">{{ Session::get('message_count') ? Session::get('message_count') : '' }}</span><i class="fa fa-envelope"></i> Inbox</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="{{ url('brokers') }}"> Brokers</a>
                                <ul>
                                    <li><a href="{{ url('brokers') }}">Brokers Directory</a></li>
                                </ul>
                            </li>
                            @foreach(App\Models\Menu::asc('sort_id')->get() as $m)
                            <li {{ $m->items()->count() > 0 ? 'class="dropdown"' : '' }}>
                                <a href="{{ $m->link }}"> {{ $m->name }}</a>
                                @if($m->items()->count() > 0)
                                <ul>
                                    @foreach($m->items()->asc('sort_id')->get() as $item)
                                    <li><a href="{{ $item->link }}" title="{{ $item->title }}">{{ $item->title }}</a> </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </div>
</header>
<div id="header-sticky" class="">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-sm-10 col-lg-3 col-md-4">
                <!-- LOGO -->
                <div id="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ url('assets/img/logo.png') }}">
                    </a>
                </div><!-- logo -->
            </div><!-- col -->
            <div class="col-xs-2 col-sm-2 col-lg-9 col-md-8">

                <!-- MENU -->
                <nav>
                    <a id="mobile-menu-button" href="#"><i class="fa fa-bars"></i></a>

                    <ul class="menu clearfix" id="menu">
                        @if(Request::is('seller/*'))
                        <li>
                            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        </li>
                        @endif
                        <li class="dropdown">
                            <a href="{{ url('listings') }}">Buy a business</a>
                            <ul>
                                <li><a href="{{ url('listings') }}">All Listings</a></li>
                                <li><a href="{{ url('search/advanced') }}">Advanced Search</a></li>
                                <li><a href="{{ url('businesses') }}">Businesses Wanted</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('admin/listings') }}"><i class="fa fa-bars"></i> My Listings</a>
                            <ul>
                                <li><a href="{{ url('seller/listings/pending') }}">Pending Listings</a></li>
                                <li><a href="{{ url('seller/listings/approved') }}">Approved Listings</a></li>
                                <li><a href="{{ url('seller/listings') }}">All Listings</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('seller/inbox') }}"><i class="fa fa-envelope"></i> Messages</a>
                            <ul>
                                <li>
                                    <a href="{{ url('seller/inbox') }}"><span class="badge">{{ Session::get('message_count') ? Session::get('message_count') : '' }}</span><i class="fa fa-envelope"></i> Inbox</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('brokers') }}"> Brokers</a>
                            <ul>
                                <li><a href="{{ url('brokers') }}">Brokers Directory</a></li>
                            </ul>
                        </li>
                        @foreach(App\Models\Menu::asc('sort_id')->get() as $m)
                        <li {{ $m->items()->count() > 0 ? 'class="dropdown"' : '' }}>
                            <a href="{{ $m->link }}"> {{ $m->name }}</a>
                            @if($m->items()->count() > 0)
                            <ul>
                                @foreach($m->items()->asc('sort_id')->get() as $item)
                                <li><a href="{{ $item->link }}" title="{{ $item->title }}">{{ $item->title }}</a> </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- container -->
</div><!-- HEADER -->