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
                            <a data-toggle="dropdown" class="dropdown-toggle btn" href="{{ url('admin/articles') }}"><i class="fa fa-edit"></i> Articles</a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ url('admin/articles/create') }}">New Article</a></li>
                                <li><a href="{{ url('admin/articles') }}">All Articles</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ url('dashboard') }}" class="dropdown-toggle btn btn_login" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bars"></i> Account</a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="">
                                    <a href="{{ url('admin/listings') }}" style="color:#000"><i class="fa fa-dashboard"></i> Dashboard</a>
                                </li>
                                <li class="divider"></li>
                                <li class="">
                                    <a href="{{ url('admin/listings') }}" style="color:#000"><i class="fa fa-bars"></i> Listings</a>
                                </li>
                                <li class="">
                                    <a href="{{ url('admin/users') }}" style="color:#111"><i class="fa fa-user"></i> Users</a>
                                </li>
                                <li>
                                    <a href="{{ url('inbox') }}" style="color:#111"><span class="badge">{{ Session::get('message_count') ? Session::get('message_count') : '' }}</span> <i class="fa fa-envelope"></i> Support</a>
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
                            @if(Request::is('admin/*'))
                            <li>
                                <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                            </li>
                            @else
                            <li>
                                <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            @endif
                            <li class="dropdown">
                                <a href="{{ url('listings') }}">Buy a business</a>
                                <ul>
                                    <li><a href="{{ url('listings') }}">All Listings</a></li>
                                    <li><a href="{{ url('search/advanced') }}">Advanced Search</a></li>
                                    <li><a href="{{ url('businesses') }}">Business Wanted Adverts</a></li>
                                    <li><a href="{{ url('brokers') }}">Brokers directory</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="{{ url('admin/listings') }}"><i class="fa fa-bars"></i> Listings</a>
                                <ul>
                                    <li><a href="{{ url('admin/listings/seller') }}">Seller Listings</a></li>
                                    <li><a href="{{ url('admin/listings/broker') }}">Broker Listings</a></li>
                                    <li><a href="{{ url('admin/adverts') }}">Business Wanted Adverts</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="{{ url('admin/users') }}"><i class="fa fa-users"></i> Manage Users</a>
                                <ul>
                                    <li><a href="{{ url('admin/users/sellers') }}">Seller Accounts</a></li>
                                    <li><a href="{{ url('admin/users/brokers') }}">Broker Accounts</a></li>
                                    <li><a href="{{ url('admin/users/buyers') }}">Buyer Accounts</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="{{ url('admin/settings') }}"><i class="fa fa-question-circle"></i> Support</a>
                                <ul>
                                    <li>
                                        <a href="{{ url('admin/inbox') }}"><span class="badge">{{ Session::get('message_count') ? Session::get('message_count') : '' }}</span><i class="fa fa-envelope"></i> Inbox</a>
                                        <a href="{{ url('admin/settings') }}"><i class="fa fa-cog"></i> Settings</a>
                                    </li>
                                </ul>
                            </li>
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
                        @if(Request::is('admin/*'))
                        <li>
                            <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        </li>
                        @else
                        <li>
                            <a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                        </li>
                        @endif
                        <li class="dropdown">
                            <a href="{{ url('listings') }}">Buy a business</a>
                            <ul>
                                <li><a href="{{ url('listings') }}">All Listings</a></li>
                                <li><a href="{{ url('search/advanced') }}">Advanced Search</a></li>
                                <li><a href="{{ url('businesses') }}">Business Wanted Adverts</a></li>
                                <li><a href="{{ url('brokers') }}">Brokers directory</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('admin/listings') }}"><i class="fa fa-bars"></i> Listings</a>
                            <ul>
                                <li><a href="{{ url('admin/listings/seller') }}">Seller Listings</a></li>
                                <li><a href="{{ url('admin/listings/broker') }}">Broker Listings</a></li>
                                <li><a href="{{ url('admin/adverts') }}">Business Wanted Adverts</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('admin/users') }}"><i class="fa fa-users"></i> Manage Users</a>
                            <ul>
                                <li><a href="{{ url('admin/users/sellers') }}">Seller Accounts</a></li>
                                <li><a href="{{ url('admin/users/brokers') }}">Broker Accounts</a></li>
                                <li><a href="{{ url('admin/users/buyers') }}">Buyer Accounts</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('admin/settings') }}"><i class="fa fa-question-circle"></i> Support</a>
                            <ul>
                                <li>
                                    <a href="{{ url('admin/inbox') }}"><span class="badge">{{ Session::get('message_count') ? Session::get('message_count') : '' }}</span><i class="fa fa-envelope"></i> Inbox</a>
                                    <a href="{{ url('admin/settings') }}"><i class="fa fa-cog"></i> Settings</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- container -->
</div><!-- HEADER -->