@extends('layouts.admin')

@section('title', 'Inbox')
@section('heading', 'Messages')

@section('content')

<div class="container">
    <h3>Inbox</h3>
    <div class="row">
        <div class="col-md-12">
            <!-- List of recent dialogs -->
            <ul class="text-muted list-inline">
                <li><i class="fa fa-comments-o"></i> {{ count($messages) }} conversations</li>
                <li><i class="fa fa-envelope-o"></i> {{$data['unread_count']}} unread</li>
                <li><a href="{{url('inbox/compose')}}"><i class="fa fa-edit"></i> New Message</a></li>
            </ul>
            <div id="pm-list" class="row pm-list">
                <div class="pm-search">
                    <form role="form">
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <div class="input-group">
                                    <label class="sr-only" for="pm-search">Email address</label>
                                    <input type="text" class="search form-control" id="pm-search" placeholder="Enter your search query here">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-dark">Search</button>
                                        <button class="sort btn btn-default" data-sort="sender">Sort by sender</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="list">
                    @foreach($messages as $msg)
                    <!-- Message dialog -->
                    <li {{ $msg->hasUnread ? 'class="pm-unread"' : "" }}>
                        <p class="col-md-4 text-muted">
                            <?php $uid = Auth::user()->id; ?>
                            @if($msg->sender_id === $uid)
                            <img src="{{ $msg->recipient->getPhoto() }}" alt="...">
                            To: <a class="sender" href='{{ url("profile/{$msg->recipient_id}") }}'>{{ $msg->recipient->fullName }}</a><br />
                            @else
                            <img src="{{ $msg->sender->getPhoto() }}" alt="...">
                            From: <a class="sender" href='{{ url("profile/{$msg->sender_id}") }}'>{{ $msg->sender->fullName }}</a><br />
                            @endif
                            <small>{{ Carbon::parse($msg->last_reply)->diffForHumans() }}</small>
                        </p>
                        <p class="col-md-8 text-muted mbody">
                            <a href='{{ url("inbox/{$msg->id}") }}' class="inbox-dialog">{{ Str::limit($msg->message, 180) }}</a>
                        </p>
                        <div class="clearfix"></div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- Pagination -->
            <ul class="pagination pull-right">
                {{ $messages->links() }}
            </ul>
        </div>
    </div>

</div>

{{ HTML::style("assets/css/messages.css", ['property' => 'stylesheet']) }}
@stop

@section('footerscripts')

{{ HTML::script("assets/js/list.min.js") }}

<script type="text/javascript">

    var options = {
        valueNames: [ 'sender', 'mbody' ]
    };

    var userList = new List('pm-list', options);
</script>
@stop