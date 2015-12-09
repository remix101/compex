<?php

use App\Models\Buyer;
use App\Models\Broker;
use App\Models\Seller;
use App\Models\Role;
use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\ListingMetum;
use App\Models\Message;
use App\Models\MessageReply;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class MessagesController extends BaseController {

    /**
	 * Display a listing of the resource.
	 * GET /messages
	 *
	 * @return Response
	 */
    public function index()
    {
        $user = Auth::user();
        $messages = $user->allMessages()->paginate(15);
        $data['unread_count'] = $user->unreadMessages()->count();
        return View::make($user->role->name.'.messages.inbox')->with(compact('data', 'messages'));
    }

    /**
	 * Show the form for creating a new resource.
	 * GET /inbox/compose
	 *
	 * @return Response
	 */
    public function create()
    {
        return View::make(Auth::user()->role->name.'.messages.create');
    }

    /**
	 * Show the form for creating a new resource.
	 * GET /inbox/compose
	 *
	 * @return Response
	 */
    public function createForUser($user)
    {
        return View::make(Auth::user()->role->name.'.messages.create')->withUsr($user);
    }

    /**
	 * Store a newly created resource in storage.
	 * POST /inbox/reply/{message}
	 *
	 * @param  Message  $message
	 * @return Response
	 */
    public function reply($message)
    {
        //when creating a reply,
        //last_reply and unread of original message should be updated
        $data = Input::all();
        $uid = Auth::user()->id;
        $data['sender_id'] = $uid;
        $data['message_id'] = $message->id;
        //simply set the recipient as the other party
        $data['recipient_id'] = $message->sender_id === $uid ? $message->recipient_id : $message->sender_id;
        $reply = new MessageReply;
        if($reply->validate($data))
        {
            $reply->fill($data);
            $reply->save();
            $message->last_reply = $reply->created_at;
            $message->receiver_replied = 1;
            $message->save();
            return Redirect::to("inbox/{$message->id}");
        }
        return View::make(Auth::user()->role->name.".messages.read")
            ->withMessage($message)
            ->withErrors($reply->getValidator());
    }

    /**
	 * Store a newly created resource in storage.
	 * POST /messages
	 *
	 * @return Response
	 */
    public function store()
    {
        $data = Input::all();

        if(!Auth::check() && isset($data['email']))
        {
            $result = $this->registerBuyer($data);
            if(is_array($result))
            {
                return View::make('users.fastcomposer')->withErrors($result); 
            }
        }

        if(Auth::check())
        {

            $data['sender_id'] = Auth::user()->id;

            $msg = new Message;
            if($msg->validate($data))
            {
                $msg->fill($data);
                $msg->last_reply = Carbon::now()->toDateTimeString();
                $msg->save();
                if(Request::ajax())
                {
                    return Response::json($msg);
                }
                return Redirect::intended("inbox/{$msg->id}");
            }
            if(Request::ajax())
            {
                return Response::json($msg->getValidator, 400);
            }
            return View::make(Auth::user()->role->name.'.messages.create')->withErrors($msg->getValidator());
        }
    }

    private function registerBuyer($data)
    {
        if(isset($data['phone_number']))
        {
            $data['phone_number'] = str_replace(' ', '', $data['phone_number']);
        }
        $u = new User;
        $data['role_id'] = Config::get('constants.ROLE_BUYER');
        $a = new Buyer;
        $u->status = 2;
        $data['skip_verification'] = true;
        if(!isset($data['password']) || $data['password'] == "")
        {
            $pwd = Str::random(10);
            $data['password'] = $data['password_confirmation'] = $pwd;
        }
        if($u->validate($data))
        {
            if($a->validate($data))
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
                Auth::loginUsingId($u->id);
                return true;
            }
            Input::flash();
            return $a->getValidator();
        }
        Input::flash();
        return $u->getValidator();
    }

    /**
	 * Display the specified resource.
	 * GET /inbox/{message}
	 *
	 * @param  Message  $message
	 * @return Response
	 */
    public function read($id)
    {
        $message = Message::find($id);
        if($message == null)
        {
            return Redirect::to('inbox');
        }
        $user = Auth::user();
        if($message->recipient_id == $user->id && $message->last_reply <= $message->created_at)
        {
            $message->unread = 0;
            $message->save();
        }
        elseif($message->sender_id == $user->id && $message->receiver_replied == 1)
        {
            $message->receiver_replied = 0;
            $message->save();
        }
        foreach($message->unreadReplies as $reply)
        {
            if($reply->recipient_id == $user->id)
            {
                $reply->unread = 0;
                $reply->save();
            }
        }
        return View::make($user->role->name.'.messages.read')->withMessage($message);
    }

    /*
     * Remove the specified resource from storage.
	 * DELETE /inbox/delete/{message}
	 *
	 * @param  Message $message
	 * @return Response
	 */
    public function destroy($message, $ajax = true)
    {
        //check if is owner of message
        $message->delete();
        if($ajax)
        {
            return Response::json('success', 200);
        }
        Session::set('msg', 'Conversation deleted successfully.');
        return Redirect::to('inbox');
    }

}