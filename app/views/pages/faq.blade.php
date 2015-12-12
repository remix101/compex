@extends((Auth::check() && !Auth::user()->isBuyer()) ? 'layouts.'.$user->role->name : 'layouts.front')

@section('title', 'FAQ | CompanyExchange')

@section('content')

<div class="container">
    <div id="page-header" class="page-header_business">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="page-header_business__text">Frequently Asked Questions</h1>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </div>
    <div class="row">
        <div class="col-md-12" id="faqlist" role="tablist" aria-multiselectable="true">
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq1" data-parent="#faqlist">
                        How do I list my business for sale?
                    </span>
                </h4>
                <div class="collapse" id="faq1">
                    Click the signup Button and create a seller account. Once you have registered and signed up; you can then list your business
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq2" data-parent="#faqlist">
                        If I have created my account and forgot my password, how do I retrieve it?
                    </span>
                </h4>
                <div class="collapse" id="faq2">
                    Click the forgot password on the login page and follow the next steps
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq3" data-parent="#faqlist">
                        How do I contact a seller regarding a listing?
                    </span>
                </h4>
                <div class="collapse" id="faq3">
                    Click on the contact seller button on a listing
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq4" data-parent="#faqlist">
                        How do I contact a buyer?
                    </span>
                </h4>
                <div class="collapse" id="faq4">
                    Click on the contact Buyer link on the buyer you wish to contact
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq5" data-parent="#faqlist">
                        How do I contact a Broker?
                    </span>
                </h4>
                <div class="collapse" id="faq5">
                    You can contact a broker through their listings or directly via their profile
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq6" data-parent="#faqlist">
                        Where can I find a broker in my country?
                    </span>
                </h4>
                <div class="collapse" id="faq6">
                    Use the search filter to drill down to brokers of a particular country
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq7" data-parent="#faqlist">
                        How do I signup to list Business wanted?
                    </span>
                </h4>
                <div class="collapse" id="faq7">
                    To create a business wanted advert, you need to sign up as a buyer. Once you have signed up and activated the account, you can then create a business wanted advert
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq8" data-parent="#faqlist">
                        How can I modify my Listing?
                    </span>
                </h4>
                <div class="collapse"id="faq8">
                    Yes. If there are changes you want to make to your business listing; you can click edit to change them
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq9" data-parent="#faqlist">
                        Can I list business as a broker?
                    </span>
                </h4>
                <div class="collapse"id="faq9">
                    Yes. If you are signed up as a broker, you can list a business for sale on behalf of someone or an organization
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq10" data-parent="#faqlist">
                        Which type of account do I need to list a business?
                    </span>
                </h4>
                <div class="collapse"id="faq10">
                    You need to create a seller account to list a business
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq11" data-parent="#faqlist">
                        Which type of account do I need to buy a business?
                    </span>
                </h4>
                <div class="collapse"id="faq11">
                    You need a create a buyer account to buy a business on Compex Africa
                </div>

            </div>
            <div class="bs-callout bs-callout-primary">
                <h4 class="panel-title">
                    <span role="button" data-toggle="collapse" data-target="#faq12" data-parent="#faqlist">
                        Which type of account do I need to create a business wanted advert
                    </span>
                </h4>
                <div class="collapse"id="faq12">
                    You need to create a buyer account to create business wanted adverts
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .bs-callout {
        padding: 12px;
        margin: 18px 0;
        border: 1px solid #eee;
        border-left-width: 5px;
        border-radius: 3px;
    }
</style>

@stop