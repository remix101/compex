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

class BrokersController extends BaseController {

    /**
	 * Display a listing of the resource.
	 * GET /brokers
	 *
	 * @return Response
	 */
    public function index()
    {
        $q = Input::get('q');

        if(trim($q) != '')
        {
            $results = Broker::paginate(10);
        }
        else
        {
            $results = Broker::search($q, 2)->paginate(10);
        }
        if (Request::ajax())
        {
            return Response::json(View::make('search.brokers')->withResults($results)->render());
        }
        return View::make('search.brokers')->withResults($results);
    }

    /**
	 * Show the form for creating a new resource.
	 * GET /brokers/create
	 *
	 * @return Response
	 */
    public function create()
    {
        return View::make('broker.create')->withRole(Config::get('constants.ROLE_BROKER'));
    }

    /**
	 * Store a newly created resource in storage.
	 * POST /brokers/create
	 *
	 * @return Response
	 */
    public function store()
    {
        $data = Input::all();
        if(isset($data['work_phone']))
        {
            $data['work_phone'] = str_replace(' ', '', $data['work_phone']);
        }
        $u = new User;
        $a = false;
        $role_id = Input::get('role_id');
        if($role_id == Config::get('constants.ROLE_BUYER'))
        {
            $a = new Buyer;
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
            return View::make('broker.create')
                ->withErrors($a ? $a->getValidator() : []);
        }
        Input::flash();
        return View::make('broker.create')
            ->withErrors($u->getValidator());    

    }

    /**
	 * Display the specified resource.
	 * GET /brokers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function show($id)
    {
        //
    }

    /**
	 * Show the form for editing the specified resource.
	 * GET /brokers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id)
    {
        //
    }

    /**
	 * Update the specified resource in storage.
	 * PUT /brokers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($id)
    {
        //
    }

    /**
	 * Remove the specified resource from storage.
	 * DELETE /brokers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id)
    {
        //
    }

}