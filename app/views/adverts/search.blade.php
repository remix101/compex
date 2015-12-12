@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'Business Wanted')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h2>Recent Business Wanted</h2>
            </div><!-- headline -->
        </div><!-- col -->
    </div><!-- row -->
    <div class="page-content-inner">
        <div class="search-page search-content-4">
            <div class="search-bar bordered">
                <div class="row">
                    <div class="col-lg-8">
                        <form>
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn green-soft uppercase bold" type="submit">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <a href="{{ url('buyer/feature') }}">
                            <button class="btn grey-cararra font-blue">Create a Business Wanted AD</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="search-table table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead class="bg-blue">
                        <tr>
                            <th>Buyer Seeks: Headline</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th><a href="javascript:;"></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $advert)
                        <tr>
                            <td class="table-title">
                                <h5>
                                    <span>
                                        <i class="fa fa-arrow-right font-blue"></i><span id="heading">{{$advert->heading}}</span> 
                                    </span>
                                </h5>
                            </td>
                            <td class="table-category">
                                <span>{{ $advert->categoryName }}</span>
                                <p>Posted:
                                    <span class="font-grey-cascade">{{ $advert->created_at->diffForHumans() }}</span>
                                </p>
                            </td>
                            <td class="table-desc"> {{ $advert->description }}</td>
                            <td class="table-country">
                                <span>{{ $advert->countryName }}</span>
                            </td>
                            <td class="table-price">
                                <span>{{ $advert->askingPrice->text }}</span>
                            </td>
                            <td class="table-status">
                                <a href="javascript:;" class="bcontact" data-owner="{{ $advert->user->id }}" data-id="{{ $advert->id }}" data-toggle="modal" data-target="#fastcontact">
                                    <i class="fa fa-envelope font-green-soft"></i> Contact User
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="search-pagination pagination-rounded">
                <ul class="pagination">
                    {{ $results->links() }}
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="fastcontact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fastcontact" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ url('messages/compose') }}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="applyLabel" class="modal-title">Leave a message for buyer</h3>
                </div>
                @if(Auth::check())
                <div class="modal-body">
                    <p class="help-block pull-left text-danger hide" id="form-error">&nbsp; Something went wrong. </p>
                    <div class="form-group">
                        <h4>Initiate communication with buyer.</h4>
                        <input type="hidden" id="recipient" value="" name="recipient_id">
                        <input type="hidden" id="advert" value="" name="advert_id">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <textarea name="message" class="form-control" rows="4" placeholder="Please type a message..." data-placement="top" data-trigger="manual" required>Hi, I have a property you may be interested in... </textarea>
                        <p class="text-info" id="infotext">Included Advert: </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right">Send</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>
                </div>
                @else
                <div class="modal-body">
                    <p class="help-block pull-left text-danger hide" id="form-error">&nbsp; Something went wrong. </p>
                    <div class="form-group" style="margin-bottom:0px">
                        <h4>Initiate communication with buyer.</h4>
                        <input type="hidden" id="recipient" value="" name="recipient_id">
                        <input type="hidden" id="advert" value="" name="advert_id">
                        <textarea name="message" class="form-control" rows="4" placeholder="Please type a message..." data-placement="top" data-trigger="manual" required>Hi, I have a property you may be interested in... </textarea>
                        <p class="text-info" id="infotext">Included Advert: </p>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group required" style="margin-bottom:0px">
                                <input type="text" id="firstname" class="form-control" value="{{Input::old('first_name')}}" name="first_name" placeholder="Please write your first name" required>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group required" style="margin-bottom:0px">
                                <input type="text" id="lastname" class="form-control" value="{{Input::old('last_name')}}" name="last_name" placeholder="Please write your last name" required>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group required" style="margin-bottom:0px">
                                <input type="text" maxlength="50" class="form-control" value="{{Input::old('email')}}" name="email" id="inputEmail" placeholder="Enter an email to use in accessing your account" required>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group required" style="margin-bottom:0px">
                                <input type="text" maxlength="17" class="form-control" value="{{Input::old('phone_number')}}" name="phone_number" id="inputPhone" placeholder="Phone number in international format, e.g. +2348099019404">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right">Send</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>
                </div>
            </form>            
            @endif
        </div>
    </div>
</div>




@stop

@section('footerscripts')

{{ HTML::style('assets/css/search.css') }}

<script type="text/javascript">

    $('.bcontact').on('click', function(o, e){
        $('#advert').val( $(this).attr('data-id') );
        $('#recipient').val( $(this).attr('data-owner') );
        $('#infotext').text( "Included advert: " + $('#heading').text() );
    });


</script>

@stop