@extends('layouts.front')

@section('title', 'Payments')
@section('heading', 'Payments')

@section('content')

<div class="col-md-12 col-xs-12">
    @if(isset($error))
    <div class="alert alert-dismissible alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
        {{ $error }}
    </div>
    @endif
    @if(Session::get('success'))
    <div class="alert alert-dismissible alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
        {{ Session::get('success') }}
    </div>
    @endif
    <div class="row panel panel-back noti-box">
        <div class="panel well">
            @if($user->customer->subscription->cost_per_second > CostStructure::min('cost_per_second'))
            <h4>You are currently on <span class="label label-warning">{{ $user->customer->subscription->name }}</span> plan &nbsp;&nbsp;<a class="btn btn-success" href="{{ url('subscription') }}">Upgrade Now</a></h4>
            @else
            <h3>You are currently on <span class="label label-success">{{ $user->customer->subscription->name }}</span> plan</h3>
            @endif
            <p class="">
                <i class="fa fa-credit-card fa-lg"></i>
                You have EUR <span id="cv" name="cv">{{ number_format((float)$user->customer->balance, 2, '.', ''); }}</span> Credits in your account
            </p>
            <form action="{{ url('payment') }}" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">€</span>
                        <input type="text" class="form-control" value="30" name="amount" id="amount" style="width:60px">
                        &nbsp;<button type="submit" class="btn btn-primary btn-other">
                        <i class="fa fa-paypal fa-fw"></i> Recharge Now
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <h3>Payment History</h3>
            <hr>
            <div class="table-responsive">
                <table id="table_payments" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Payment ID </th>
                            <th>Transaction Type </th>
                            <th>Amount Paid </th>
                            <th>Date/Time </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $history = $user->customer->payments()->desc('created_at')->get(); ?>
                        @foreach($history as $h)
                        <tr>
                            <td>{{ $h->payment_id }}</td>
                            <td>{{ $h->transaction_type == Config::get('constants.SUBSCRIPTION_UPGRADE') ? 'Subscription Upgrade' : 'Amount Recharge' }}</td>
                            <td>
                                <label class="label label-success label-lg">{{ $h->amount }} EUR </label>
                            </td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($h->created_at)) }}</td>
                        </tr>
                        @endforeach
                        @if($history->count() == 0)
                        <tr>
                            <td colspan="5" class="text-center">You have not made any payments yet</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('footerscripts')
{{ HTML::script("https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js") }}
{{ HTML::script("assets/js/datatables/dataTables.buttons.min.js") }}
{{ HTML::script("assets/js/datatables/buttons.flash.js") }}
{{ HTML::script("assets/js/datatables/buttons.print.min.js") }}
{{ HTML::script("assets/js/datatables/buttons.html5.min.js") }}
{{ HTML::script("//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js") }}
{{ HTML::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js") }}
{{ HTML::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js") }}
{{ HTML::script("assets/js/datatables/buttons.bootstrap.min.js") }}
{{ HTML::script("assets/js/datatables/dataTables.bootstrap.js") }}
{{ HTML::style("assets/js/datatables/dataTables.bootstrap.css") }}


<script type="text/javascript">

    jQuery(document).ready(function(){
        //TableEditable.init();
        $('#table_payments').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    });

</script>

@stop