<?php

use App\Models\Buyer;
use App\Models\Broker;
use App\Models\Seller;
use App\Models\Role;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class UsersController extends BaseController {

    public function login()
    {
        if(!Auth::check())
        {
            return View::make('users.login');
        }
        else
        {
            return Redirect::intended('/');
        }
    }    

    /**
	 * Store a newly created resource in storage.
	 * POST /login
	 *
	 * @return Response
	 */
    public function authenticate()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $u = User::where('email', '=', $email)->first();
        if($u != null && $u->status == 1)
        {
            return View::make('users.login')->with('message', 'Account not verified. Please verify your account first and try logging in again.');
        }
        if(Auth::attempt(array('email' => $email, 'password' => $password)))
        {
            $u->last_login = date('YmdHis');
            $u->save();
            return Redirect::intended('/');
        }
        return View::make('users.login')->with('message', 'Incorrect login details. Please try again.');
    }


    /**
     * Login user with facebook
     * @return void
     */
    public function loginWithFacebook($rolename = 'buyer')
    {
        $a = null;
        $role_id = Config::get('constants.ROLE_BUYER');
        switch(strtolower($rolename))
        {
            case 'buyer':
                $a = new Buyer;
                $role_id = Config::get('constants.ROLE_BUYER');
                break;
            case 'seller':
                $a = new Seller;
                $role_id = Config::get('constants.ROLE_SELLER');
                break;
            case 'broker':
                $a = new Broker;
                $role_id = Config::get('constants.ROLE_BROKER');
                break;
        }

        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = OAuth::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $data = json_decode( $fb->request( '/me?fields=email,verified,first_name,last_name' ) );

            $usr = User::where('email', '=', $data->email)->first();

            if($usr == null)
            {
                $usr = new User(['email' => $data->email]);
                $usr->first_name = (property_exists($data, 'first_name')) ? $data->first_name : "";
                $usr->last_name = (property_exists($data, 'last_name')) ? $data->last_name : "";
                $usr->role_id = $role_id;
                $usr->status = 2;//maybe register and request verification for some
                $this->registerAndWelcomeUser($data, $usr, $a);
                return Redirect::intended('/');
            }
            else
            {
                Auth::loginUsingId($usr->id);
                $usr->last_login = date('YmdHis');
                $usr->save();
                return Redirect::intended('/');
            }

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }

    }

    public function loginWithGoogle($rolename = 'buyer')
    {
        $a = null;
        $role_id = Config::get('constants.ROLE_BUYER');
        switch(strtolower($rolename))
        {
            case 'buyer':
                $a = new Buyer;
                $role_id = Config::get('constants.ROLE_BUYER');
                break;
            case 'seller':
                $a = new Seller;
                $role_id = Config::get('constants.ROLE_SELLER');
                break;
            case 'broker':
                $a = new Broker;
                $role_id = Config::get('constants.ROLE_BROKER');
                break;
        }

        // get data from input
        $code = Input::get( 'code' );

        // get google service
        $googleService = OAuth::consumer( 'Google' );

        //https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read https://www.google.com/m8/feeds/

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );

            // Send a request with it
            $data = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ) );

            $usr = User::where('email', '=', $data->email)->first();

            if($usr == null)
            {
                $usr = new User(['email' => $data->email]);
                $usr->first_name = (property_exists($data, 'givenName')) ? $data->givenName : "";
                $usr->last_name = (property_exists($data, 'familyName')) ? $data->familyName : "";
                $usr->role_id = $role_id;
                $usr->status = 2;
                $this->registerAndWelcomeUser($data, $usr, $a);
                return Redirect::intended('/');
            }
            else
            {
                Auth::loginUsingId($usr->id);
                $usr->last_login = date('YmdHis');
                $usr->save();
                return Redirect::intended('/');
            }
        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::to( (string)$url );
        }
    }

    public function loginWithTwitter() {

        // get data from input
        $token = Input::get( 'oauth_token' );
        $verify = Input::get( 'oauth_verifier' );

        // get twitter service
        $tw = OAuth::consumer( 'Twitter' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $token ) && !empty( $verify ) ) {

            // This was a callback request from twitter, get the token
            $token = $tw->requestAccessToken( $token, $verify );

            // Send a request with it
            $result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );

            $message = 'Your unique Twitter user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message. "<br/>";

            //Var_dump
            //display whole array().
            dd($result);

        }
        // if not ask for permission first
        else {
            // get request token
            $reqToken = $tw->requestRequestToken();

            // get Authorization Uri sending the request token
            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            // return to twitter login url
            return Redirect::to( (string)$url );
        }
    }

    public function loginWithYahoo($rolename = 'buyer')
    {
        $a = null;
        $role_id = Config::get('constants.ROLE_BUYER');
        switch(strtolower($rolename))
        {
            case 'buyer':
                $a = new Buyer;
                $role_id = Config::get('constants.ROLE_BUYER');
                break;
            case 'seller':
                $a = new Seller;
                $role_id = Config::get('constants.ROLE_SELLER');
                break;
            case 'broker':
                $a = new Broker;
                $role_id = Config::get('constants.ROLE_BROKER');
                break;
        }

        $code = Input::get( 'code' );
        $yh = OAuth::consumer( 'Yahoo' );

        if ( !empty( $code ) ) {

            // This was a callback request from yahoo, get the token
            $token = $yh->requestAccessToken( $code );
            $xid = array($token->getExtraParams());
            $result = json_decode( $yh->request( 'https://social.yahooapis.com/v1/user/'.$xid[0]['xoauth_yahoo_guid'].'/profile?format=json' ) );
            //$contacts = json_decode( $yh->request( 'https://social.yahooapis.com/v1/user/'.$xid[0]['xoauth_yahoo_guid'].'/contacts?format=json' ), true ); 
            //Log::info($contacts);
            $usr = User::where('yahoo_guid', '=', $result->profile->guid)->first();

            if($usr == null)
            {
                $data = $result->profile;
                $usr = new User(['yahoo_guid' => $data->guid]);
                if (isset($data->emails)) {
                    $email = "";
                    foreach ($data->emails as $v) {
                        if (isset($v->primary) && $v->primary) {
                            $email = (property_exists($v, 'handle')) ? $v->handle : "";
                            break;
                        }
                    }
                    $usr->email = $email;
                }
                $usr->first_name = (property_exists($data, 'givenName')) ? $data->givenName : "";
                $usr->last_name = (property_exists($data, 'familyName')) ? $data->familyName : "";
                $usr->first_name = $usr->first_name == "" ? ((property_exists($data, 'nickname')) ? $data->nickname : "") : "";
                $usr->role_id = $role_id;
                $usr->status = 2;
                $this->registerAndWelcomeUser($data, $usr, $a);
                return Redirect::intended('/');
            }
            else
            {
                Auth::loginUsingId($usr->id);
                $usr->last_login = date('YmdHis');
                $usr->save();
                return Redirect::intended('/');
            }
        }
        // if not ask for permission first
        else {

            $url = $yh->getAuthorizationUri();

            // return to google login url
            return Redirect::to( (string)$url );
        }
    }

    private function registerAndWelcomeUser($data, $usr, $account)
    {
        $data = (array) $data;
        if(isset($data['email']))
        {
            if(!isset($data['password']) || $data['password'] == "")
            {
                $pwd = Str::random(10);
                $data['password'] = $data['password_confirmation'] = $pwd;
            }
            $data['password'] = Hash::make($data['password']);
            $usr->password = $data['password'];
        }
        $usr->save();
        $data['skip_verification'] = true;
        $data['user_id'] = $usr->id;
        if($account != null)
        {
            $account->fill($data);
            $account->save();
        }
        if(isset($data['email']))
        {
            $email = $usr->email;
            $data['url']['link'] = url('/');
            $data['url']['name'] = 'Go to CompanyExchange';
            Mail::queue('emails.templates.welcome', $data, function($message) use($email) {
                $message->from('listings@ng.cx', 'CompanyExchange');
                $message->to($email);
                $message->subject('Welcome to CompanyExchange');
            });
        }
        Auth::loginUsingId($usr->id);
    }

    public function loginWithLinkedin() {

        // get data from input
        $code = Input::get( 'code' );

        $linkedinService = OAuth::consumer( 'Linkedin' );


        if ( !empty( $code ) ) {

            // This was a callback request from linkedin, get the token
            $token = $linkedinService->requestAccessToken( $code );
            // Send a request with it. Please note that XML is the default format.
            $result = json_decode($linkedinService->request('/people/~?format=json'), true);

            // Show some of the resultant data
            echo 'Your linkedin first name is ' . $result['firstName'] . ' and your last name is ' . $result['lastName'];

            //Var_dump
            //display whole array().
            dd($result);

        }// if not ask for permission first
        else {
            // get linkedinService authorization
            $url = $linkedinService->getAuthorizationUri(array('state'=>'DCEEFWF45453sdffef424'));

            // return to linkedin login url
            return Redirect::to( (string)$url );
        }
    }    

    /**
	 * Logs out the curremntly authenticated user.
	 * GET /logout
	 *
	 * @return Response
	 */
    public function logout()
    {
        Auth::logout();
        Session::flash('message', 'You have been successfully logged out');
        return Redirect::to('/');
    }

    public function register()
    {
        return View::make('users.register');
    }

    public function myProfile()
    {
        return View::make('users.myprofile');
    }

    public function profile($usr)
    {
        return View::make('users.profile')->withUsr($usr);
    }

    public function dashboard()
    {        
        $user = Auth::user();
        if($user->role->name == 'seller' || $user->role->name == 'broker')
        {
            return Redirect::to('sell');
        }
        elseif($user->role->name == 'buyer')
        {
            return Redirect::to('/');
        }
        return View::make($user->role->name.'.dashboard');
    }

    public function account()
    {        
        $user = Auth::user();
        return View::make($user->role->name.'.account');
    }

    public function store()
    {
        $data = Input::all();
        if(isset($data['phone_number']))
        {
            $data['phone_number'] = str_replace(' ', '', $data['phone_number']);
        }
        $u = new User;
        $a = false;
        $role_id = Input::get('role_id');
        if($role_id == Config::get('constants.ROLE_BUYER'))
        {
            $a = new Buyer;
            $u->status = 2;
            $data['skip_verification'] = true;
        }
        elseif($role_id == Config::get('constants.ROLE_SELLER'))
        {
            $a = new Seller;
        }
        elseif($role_id == Config::get('constants.ROLE_BROKER'))
        {
            $a = new Broker;
        }
        else
        {
            //we don't know this role or attempt to register unlisted role
            unset($data['role_id']);
        }
        if(!isset($data['password']) || $data['password'] == "")
        {
            $pwd = Str::random(10);
            $data['password'] = $data['password_confirmation'] = $pwd;
        }
        if($u->validate($data))
        {
            if($a && $a->validate($data))
            {
                if(isset($pwd))
                {
                    Session::set('validate_password', true);
                }
                $data['password'] = Hash::make($data['password']);            
                $u->fill($data);
                $code = Str::random(10);
                $u->verification_code = $code;
                $data['verification_code'] = $code;
                $u->save();
                $data['user_id'] = $u->id;
                $a->fill($data);
                $a->save();
                $email = $u->email;
                if(isset($data['skip_verification']))
                {
                    $data['url']['link'] = url('/');
                    $data['url']['name'] = 'Go to CompanyExchange';
                    Mail::queue('emails.templates.welcome', $data, function($message) use($email) {
                        $message->from('listings@ng.cx', 'CompanyExchange');
                        $message->to($email);
                        $message->subject('Welcome to CompanyExchange');
                    });
                }
                else
                {
                    Mail::queue('emails.templates.progress', $data, function($message) use($email) {
                        $message->from('listings@ng.cx', 'CompanyExchange');
                        $message->to($email);
                        $message->subject('Welcome to CompanyExchange');
                    });
                }
                if($role_id == Config::get('constants.ROLE_BUYER'))
                {
                    Auth::loginUsingId($u->id);
                    return Redirect::to('search?q=')->withSuccess("Welcome $u->first_name. Use the form on the left to search for listed businesses or browse the most recent listings below");
                }
                return Redirect::to('login')->withSuccess('Registration successful. Please check email to activate your account');
            }
            Input::flash();
            return View::make('users.register')
                ->withErrors($a ? $a->getValidator() : []);
        }
        Input::flash();
        return View::make('users.register')
            ->withErrors($u->getValidator());
    }

    public function verify($user, $code)
    {
        if($user->verification_code == $code)
        {            
            if($user->status == 2)
            {
                return View::make('users.login')->withMessage('Account already verified. Please login to continue.');
            }
            $user->status = 2;
            $user->save();
            $email = $user->email;
            $data['url']['link'] = url('/sell');
            $data['url']['name'] = 'Create your First Listing';
            Mail::queue('emails.templates.welcome', $data, function($message) use($email) {
                $message->from('listings@ng.cx', 'CompanyExchange');
                $message->to($email);
                $message->subject('Welcome to CompanyExchange');
            });
            return Redirect::to('login')->withSuccess('Congratulations, your account has been verified successfully. You may now login.');
        }
        return View::make('users.login')->withMessage('Invalid code. Please contact admin if you continue to experience any problems');
    }

    public function update()
    {
        $data = Input::all();
        $u = Auth::user();
        $pupdated = false;
        if($u->validate($data, 'update'))
        {
            if(Input::get('password_confirmation') != "" && (Input::get('password') === Input::get('password_confirmation')))
            {
                $data['password'] = Hash::make(Input::get('password'));
                $pupdated = true;
            }
            else
            {
                unset($data['password']);
            }
            $u->update($data);
            $b = $u->buyer;
            if($b != null && $b->validate($data, 'update'))
            {
                $b->update($data);
            }
            if($pupdated)
            {
                Session::remove('validate_password');
                return Redirect::to('dashboard');
            }
            return View::make($u->role->name.'.account')->withSuccess(true);        
        }
        return View::make($u->role->name.'.account')->withErrors($u->getValidator());        
    }

    public function getUsers()
    {
        $q = Input::get('q');
        $skip = Input::get('page');
        if(!$skip)
        {
            $skip = 0;
        }

        $users = User::search($q)
            ->skip($skip)->take(5)->get();

        return Response::json($users);
    }
}
