<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title')</title>
<meta name="description" content="">
<meta name="keywords" content="business broker,business sales,business for sale,businesses">

{{ HTML::style("assets/css/bootstrap.css", ['property' => 'stylesheet']) }}
{{ HTML::style("assets/css/site.css", ['property' => 'stylesheet']) }}

@if(!isset($nobutton))
{{ HTML::style("assets/css/custom.css", ['property' => 'stylesheet']) }}
{{ HTML::style("assets/css/blue.css", ['property' => 'stylesheet']) }}
@endif

{{ HTML::style("assets/css/pages-style.css", ['property' => 'stylesheet']) }}
{{ HTML::style("assets/css/style.css", ['property' => 'stylesheet']) }}
