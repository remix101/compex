<?php namespace App\Models;

use Illuminate\Support\Facades\Mail;

class Message extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
    protected $fillable = ['sender_id', 'recipient_id', 'message', 'listing_id', 'advert_id'];

    protected $rules = [
        'create' =>[
            'sender_id' => 'required|exists:users,id',
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|min:2',
        ],
        'update' =>[
        ]
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($message){
            if($message->receiver->email != null && $message->receiver->email != "")
            {
                $email = $message->receiver->email;
                $data['body'] = "You have a new message from {$message->sender->fullName}.<br>Please click the link below to go to your inbox/read message now<br>";
                $data['url']['title'] = 'View Message Now';
                $data['url']['link'] = url("inbox/$message->id");
                $data['title'] = 'You have a new message on CompanyExchange';
                Mail::queue('emails.templates.custom', $data, function($message) use($email){
                    $message->from('listings@ng.cx', 'CompanyExchange');

                    $message->to($email);
                    $message->subject('New Message on CompanyExchange');
                });
            }
        });
    }


    public function sender()
    {
        return $this->belongsTo('User', 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo('User', 'recipient_id');
    }

    public function recipient()
    {
        return $this->belongsTo('User', 'recipient_id');
    }

    public function listing()
    {
        return $this->belongsTo('App\Models\Listing', 'listing_id');
    }

    public function advert()
    {
        return $this->belongsTo('App\Models\Advert', 'advert_id');
    }

    public function scopeUnread($query)
    {
        return $query->whereRaw('unread = 1');
    }

    public function getLastReply()
    {
        $lastReply = $this->hasMany('App\Models\MessageReply', 'message_id')->desc('created_at')->first();
        if($lastReply == null)
        {
            $lastReply = $this;
        }
        return $lastReply->message;
    }

    public function getLastSender()
    {
        $lastReply = $this->hasMany('App\Models\MessageReply', 'message_id')->desc('created_at')->first();
        if($lastReply == null)
        {
            $lastReply = $this;
        }
        return $lastReply->sender;
    }

    public function replies()
    {
        return $this->hasMany('App\Models\MessageReply', 'message_id')->asc('created_at');
    }

    public function unreadReplies()
    {
        return $this->hasMany('App\Models\MessageReply', 'message_id')->unread()->asc('created_at');
    }   
}
