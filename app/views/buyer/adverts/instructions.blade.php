@extends('layouts.customer')

@section('title', 'HTML Code for your Click2Call')
@section('heading', 'HTML Code for your Click2Call')

@section('content')

<div class="row">
    <div class="panel well">
        <div class="panel-body">
            <a class="btn btn-success pull-right" style="margin-left:2px" href="#" onclick="window.open('{{ url('click2call/'.$account->account_id) }}', 'newwindow', 'width=641, height=651, scrollbars=no, resizable=no, left = '+((screen.width/2)-320)+', top = '+((screen.height/2)-325));return false;">Preview Now</a>
            <h5><strong>Click2Call ID:</strong><br> {{ $account->account_id }}</h5>
            <h5><strong>Destination Phone Number:</strong><br> {{ $account->phone }}</h5>
        </div>
    </div>
    <div class="col-md-12">
    </div>

    <p>
        Paste the following code at any desired place in your website, e.g your navbar/header to get the Click2Call button.
        You can place as many buttons as you want. The style however should be added once to your stylesheet.
        Pleace contact us if you need any help/support.
    </p>
    <div class="center-block">
        <br>
        <h4 style="color:#4cae4c; margin-bottom:0px">Button Code</h4>
        <span>Place this anywhere you want to have a Click2Call button on your website</span>
        <pre class="prettyprint lang-html">&lt;a class=&quot;cbutton&quot; href=&quot;#&quot; onclick=&quot;window.open(&#39;{{ htmlentities(url('/click2call/'.$account->account_id)) }}&#39;, &#39;newwindow&#39;, &#39;width=641, height=651, scrollbars=no, resizable=no, left = &#39;+((screen.width/2)-320)+&#39;, top = &#39;+((screen.height/2)-325));return false;&quot;&gt;Click to Call&lt;/a&gt;</pre>
        <br>
        <h4 style="color:#4cae4c; margin-bottom:0px">Then</h4>
        <p>Place this inside the &#x3C;head&#x3E; tag in your html</p>
        <pre class="prettyprint lang-css">&#x3C;style type=&#x22;text/css&#x22;&#x3E;
    .cbutton {
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        padding: 12px 24px;
        border: 1px solid #a12727;
        border-radius: 8px;
        background: #ff4a4a;
        background: -webkit-gradient(linear, left top, left bottom, from(#ff4a4a), to(#992727));
        background: -moz-linear-gradient(top, #ff4a4a, #992727);
        background: linear-gradient(to bottom, #ff4a4a, #992727);
        text-shadow: #591717 1px 1px 1px;
        font: normal normal bold 20px arial;
        color: #ffffff;
        text-decoration: none;
}
.cbutton:hover,
.cbutton:focus {
    background: #ff5959;
    background: -webkit-gradient(linear, left top, left bottom, from(#ff5959), to(#b62f2f));
    background: -moz-linear-gradient(top, #ff5959, #b62f2f);
    background: linear-gradient(to bottom, #ff5959, #b62f2f);
    color: #ffffff;
    text-decoration: none;
}
.cbutton:active {
    background: #982727;
    background: -webkit-gradient(linear, left top, left bottom, from(#982727), to(#982727));
    background: -moz-linear-gradient(top, #982727, #982727);
    background: linear-gradient(to bottom, #982727, #982727);
}
.cbutton:before{
    content:  &#x22;\0000a0&#x22;;
    display: inline-block;
    height: 24px;
    width: 24px;
    line-height: 24px;
    margin: 0 4px -6px -4px;
    position: relative;
    top: 0px;
    left: 0px;
    background: url(&#x22;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAD6UlEQVRIiZ2WTUxcVRTHfxdBPiLJpF9Bwn1vBFxIYwNk0hilQpDCwhK7MI1pST8CMdVK+pXQJnzE2rCwiakLExcYI1YXEhCtsVjjAqxgYIcFBCyBcZoMAkL7apgZYN5xgfP4mGFoPMnNPffdc//n3P895+QpHkNMw0hB5DDwGpAP7AGCwDjwPSKfee/fn4t1VsUF1joReBOlGp/OyMg4WF5OQUEBu3bvJhQMMjY+zg9dXQzdvWuJyEUSEj71er324wSNoXWGqXXPfo9H2traJBgMSjgcFtu2ndm2bVlZWZGuW7ekMD9fTK0/MAwjYVtwt9aZpmGMHa+qktnZWQcs3vhjfFz2ezxian0uLripdYqpdX9NdbUEAgEJh8MSDodlbHRURkZGnHWs8cudO5LtdgdMrbPjObhaWlIilmU50f02OCjP790r+fv2yeTkZBRN66l76/RpMbX+eCvwDLdhPOrp7t5w/ZrqanEbhrgNQy5euBATPKL39vaKqfVfptZPAmx+kKPP5eU99VJRESLiDJ/PByIAKLWaeJG9zbrH4yE1NXUPkBvLQUVxcbEDEplzc3IAKCoq4v1r11BKbTmSkpIwDAPAiHKgINswDMdYRFBKcbC8HJTi7/l5J9J4kpaWBhBNkUBweXk56vrlFRVkZWXx+8gI7125QjAQwLZtfu7pwbKsKHvLsgDmY1E0Ojw87FATkeTkZOouXQLg89ZWXj5wgLLSUk6eOEFpSQl9fX3OjUOhED6fbwW4F8vBtz/evo1lWVHcvnroECdPnQJgbm6OqakpAObn52lsaHDebGBggKWlpZGllZXpWA7aFxYW7n14/XpUhiilaGxq4tz58yQmJq5m1X/fa2trHbuO9naAr/x+f+wHMrUuf8Y0QwP9/Vu2heGhIblcVyc11dXy3c2bTi2MjY7Kszk5j9xa74qNvubk13ebmrZ0EKvQQqGQvHHkiJhaX94OPC/b7Q74fL4te04EOKIvLy9LQ329mFr3RCo4IgnrgF2m1lVA6ytlZSmZmZkopVhcXOSTlha8Xq9zaH0tzMzM8M6ZM3xx4wbAP8DrptauyL4ytU4D6oG3lVIugKvNzVRWVtLR3k5LSwvTfj/p6ekcPXaM4pISXC4X034/3d3dfNPZGcn79QE8AD4CmpWpdaeCw+sNCgoLmZiYwHr4MC6d24nA18rUekEp5UIElMKZ18JZW8eyiaMLWAnAWUSCzsamKt6wjmWzhS6rPwVnn9ixc+eg2HYHSqUgkqsg+X/xsQZsAV8Cx234aUO4ptYpwIvAC0ABqz09C9ihIGETFbaIPFDwp6z2nUGgD+jz+nzBCOa/vUfchcy/+10AAAAASUVORK5CYII=&#x22;) no-repeat left center transparent;
    background-size: 100% 100%;
}
&#x3C;/style&#x3E;</pre>
    </div>
</div>
@stop

@section('footerscripts')
{{ HTML::script('assets/js/google-code-prettify/prettify.js') }}
{{ HTML::style('assets/css/prettify.css') }}
<script type="text/javascript">

    (function(jQuery){

        jQuery( document ).ready( function() {

            prettyPrint();

        } );

    }(jQuery))

</script>
<style type="text/css">
    pre.prettyprint{
        width: auto;
        overflow: auto;
        //max-height: 240px
    }
</style>
@stop
