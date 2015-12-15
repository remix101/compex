<?php namespace App\Models;

use Illuminate\Support\Facades\Mail;

class MessageReply extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
    protected $fillable = ['recipient_id', 'sender_id', 'message_id', 'message', 'attachment'];

    protected $rules = [
        'create' =>[
            'sender_id' => 'required|exists:users,id',
            'recipient_id' => 'required|exists:users,id',
            'message_id' => 'required|exists:messages,id',
            'message' => 'required|min:2',
        ],
        'update' =>[
        ]
    ];
    
    public static function boot()
    {
        parent::boot();

        static::creating(function($reply){
            if($reply->receiver->email != null && $reply->receiver->email != "")
            {
                $email = $reply->receiver->email;
                $data['body'] = "{$reply->sender->fullName} has just replied to your message on CompanyExchange.<br>Click the link below to view message now<br>";
                $data['url']['title'] = 'View Message';
                $data['url']['link'] = url("inbox/$reply->message_id");
                $data['title'] = 'You have a new reply on CompanyExchange';
                Mail::queue('emails.templates.custom', $data, function($message) use($email){
                    $message->from('listings@ng.cx', 'CompanyExchange');

                    $message->to($email);
                    $message->subject('New Message Reply on CompanyExchange');
                });
            }
        });
    }


    public function message()
    {
        return $this->belongsTo('App\Models\Message', 'message_id');
    }

    public function sender()
    {
        return $this->belongsTo('User', 'sender_id');
    }

    public function receiver()
    {

        return $this->belongsTo('User', 'recipient_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('unread', '=', 1);
    }
    
    public function scopeUserUnread($query, $uid = false)
    {
        $uid = ($uid == false && \Auth::check()) ? \Auth::user()->id : $uid;
        return $query->whereRaw("recipient_id = $uid AND unread = 1");
    }
}
