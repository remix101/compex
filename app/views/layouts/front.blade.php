<!DOCTYPE html>
<html lang="en-US">
    <head>
        @include('includes.front.head')
    </head>
    <body>

        <div class="wrap">

            @include('includes.front.navbar')

            @yield('content')
            
        </div>

        @include('includes.front.footer')
    </body>
</html>