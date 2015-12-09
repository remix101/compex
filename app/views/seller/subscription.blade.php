@extends('layouts.seller')

@section('title', 'Subscription')
@section('heading', 'Subscription')

@section('content')
{{ HTML::style('assets/front/css/main.css') }}
<div class="col-md-12 col-xs-12">
    <div class="row panel panel-back noti-box">
        <div class="panel well">
            @if(isset($message))
            <div class="alert alert-dismissible alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                {{ $message }}
            </div>
            @endif
            @if(Session::get('success'))
            <div class="alert alert-dismissible alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
                {{ $success }}
            </div>
            @endif
            <form class="form-inline" action="{{ url('subscription') }}" method="post">
                <div>
                    <p class="help-text">You will only need to pay the difference between your selected plan and your current plan</p>
                </div>
                <div class="input-group">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="form-about-yourself">Plan</label>
                        <div class="col-md-9">
                            <select name="plan" class="form-control">
                                @foreach(CostStructure::all() as $c)
                                <option value="{{$c->id}}">{{$c->name}} - €{{ $c->subscription }} Setup Fee</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right">
                            <i class="fa fa-paypal fa-fw"></i> Change Plan
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container">
            <h2>Compare Pricing</h2>
            <style type="text/css">
                li:first-child {
                    list-style-type: none; 
                }
            </style>
            <div id="pricing-table" class="row">
                <?php $costs = CostStructure::all(); ?>
                @foreach($costs as $i => $s)
                <div class="col-sm-{{ 12 / $costs->count() }}">
                    <ul class="plan {{$i == 1 ? 'featured' : ''}}">
                        <li class="plan-name" style="line"><h3 style="color:#4cae4c;">{{ $s->name }}</h3></li>
                        <li class="plan-price"><strong>ONE TIME Set Up Fee: €{{ number_format((float)$s->subscription, 2, '.', '') }}</strong></li>
                        <li><strong>{{ $s->account_limit == 0 ? 'Unlimited' : $s->account_limit }} Call Account{{ $s->account_limit > 1 ? 's' : '' }}</strong></li>
                        <li class="">€{{ round($s->cost_per_minute, 4) }}/min</li>
                        <li>{{ $s->id == 1 ? 'Email Support Only' : '24hr Customer Support' }}</li>
                    </ul>
                </div><!--/.col-sm-4-->
                @endforeach
            </div> 
        </div>
    </div>
</div>

@stop