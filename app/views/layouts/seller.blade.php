<!DOCTYPE html>
<html lang="en-US">
    <head>
        @include('includes.seller.head')
    </head>
    <body>

        <div class="wrap">

            @include('includes.seller.navbar')

            @yield('content')
            
        </div>

        @include('includes.seller.footer')
    </body>
</html>