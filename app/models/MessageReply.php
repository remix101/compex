<?php namespace App\Models;

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
}
