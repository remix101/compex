<?php namespace App\Models;

class Message extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['sender_id', 'recipient_id', 'message', 'listing_id', 'advert_id'];
 
    protected $rules = [
        'create' =>[
            'sender_id' => 'exists:users,id',
            'recipient_id' => 'exists:users,id',
            'message' => 'required|min:2',
        ],
        'update' =>[
        ]
    ];

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
