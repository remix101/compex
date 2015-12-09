<!DOCTYPE html>
<html lang="en-US">
    <head>
        @include('includes.broker.head')
    </head>
    <body cz-shortcut-listen="true">

        <div class="wrap">

            @include('includes.broker.navbar')

            @yield('content')
            
        </div>

        @include('includes.broker.footer')
    </body>
</html>