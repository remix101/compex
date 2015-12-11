@extends('layouts.front')

@section('title', 'Inbox')
@section('heading', 'View Message')

@section('content')

<div class="container">
    <h3 style="color: #481212;" class="page-title">View Message</h3>
    <div class="row">
        <div class="col-md-12">

            <span class="text-muted"><a href="{{ url('inbox') }}">Inbox</a> <i class="fa fa-long-arrow-right"></i> {{ $message->fullName }}</span>&nbsp;&nbsp;&nbsp;<i class="fa fa-trash-o"></i> <a id="cdelete" href="#" url='{{ url("inbox/delete/{$message->id}") }}'> Delete Conversation</a>
            <div class="clearfix"></div>
            <hr>
            @if($errors->has())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                {{ $error }}
            </div>
            @endforeach
            @endif

            <div class="pm bottom-15">
                <div class="media">
                    @if($message->listing != null)
                    <div class="listing">
                        <p>Included listing</p>
                        <div class="col-sm-6 col-md-3 col-xs-12">
                            <div class="blog-article">
                                <div class="blog-article-thumbnail">
                                    <a href="{{ $message->listing->url }}">
                                        <img src="{{ $message->listing->thumbnail }}" alt="">
                                    </a>
                                </div><!-- blog-article-thumbnail -->
                                <div class="blog-article-date">${{$message->listing->askingPrice}}</div>
                                <div class="blog-article-details blog-article-details_with-more text-center">
                                    <h5><a href="{{ $message->listing->url }}">{{ $message->listing->heading }}</a></h5>
                                    <p><a href="#">{{ $message->listing->location }}</a></p>
                                </div><!-- blog-article-details -->
                                <div class="text-center"><a class="btn btn-white" href="{{ $message->listing->url }}">View</a></div>
                            </div><!-- blog-article -->
                        </div>
                    </div>
                    @endif
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ $message->sender->getPhoto() }}" alt="">
                    </a>
                    <div class="media-body">
                        <p><a href="{{ url('profile/'.$message->sender->id) }}">{{ $message->sender->fullName }}</a></p>
                        <p>{{ $message->message }}</p>
                        <ul class="text-muted list-inline">
                            <li><i class="fa fa-clock-o"></i> {{ Carbon::parse($message->created_at)->diffForHumans() }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @foreach($message->replies as $reply)
            <div class="pm bottom-15">
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ $reply->sender->getPhoto() }}" alt="">
                    </a>
                    <div class="media-body">
                        <p><a href="{{ url('profile/'.$reply->sender->id) }}">{{ $reply->sender->fullName }}</a></p>
                        <p>{{ $reply->message }}</p>
                        <ul class="text-muted list-inline">
                            <li><i class="fa fa-clock-o"></i> {{ Carbon::parse($reply->created_at)->diffForHumans() }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="message-answer">
                <img src="{{ url(Auth::user()->getPhoto()) }}" alt="..." class="hidden-xs">
                <form action='{{ url("inbox/reply/{$message->id}") }}' method="post" role="form">
                    <div class="form-group">
                        <label for="message" class="sr-only">Message</label>
                        <textarea class="form-control" rows="3" name="message" id="message" placeholder="Reply to this message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
{{ HTML::style("assets/css/messages.css", ['property' => 'stylesheet']) }}

@stop

@section('footerscripts')


{{ HTML::script('assets/js/bootbox/bootbox.min.js') }}
{{ HTML::script('assets/js/bootstrap-toastr/toastr.min.js') }}
{{ HTML::style('assets/js/bootstrap-toastr/toastr.min.css') }}

<script type="text/javascript">

    $('#cdelete').click(function(){
        bootbox.confirm("Are you sure you want to delete this conversation?", function(result) {
            if(result)
            {
                $.ajax(
                    {
                        url: cdelete.getAttribute('url'),
                        method: 'delete',
                        success: function(data)
                        {
                            toastr['success']("Conversation deleted sucessfully. Redirecting to inbox...", "Success");
                            setTimeout(function(){ window.location = "{{url('inbox')}}"; }, 3000);
                        },
                        error: function(data)
                        {
                            toastr['error']("Unable to delete conversation", "Error");
                        }
                    });
            }
        }); 
    });

</script>

@stop