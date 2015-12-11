<!DOCTYPE html>
<html lang="en-US">
    <head>
        @include('includes.admin.head')
    </head>
    <body>

        <div class="wrap">

            @include('includes.admin.navbar')

            @yield('content')
            
        </div>

        @include('includes.admin.footer')
    </body>
</html>