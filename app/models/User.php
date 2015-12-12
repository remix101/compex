<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends App\Models\BaseModel implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait, SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'first_name' => 10,
            'last_name' => 10,
        ],
        'selects' => [
            'first_name',
            'last_name',
            'email',
            'roles.name as role',
            'users.id as id',
        ],
        'joins' => [
            'roles' => ['roles.id', 'users.role_id'],
        ]
    ];
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'users';
    
    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }

    /**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    protected $hidden = array('password', 'remember_token');

    /**
    * The properties of this model that can be filled automatically
    */
    protected $fillable = ['title', 'first_name', 'last_name', 'email', 'password', 'remember_token', 'role_id'];

    /**
     * Model Validation Rules
     */
    protected $rules = [
        'create' => [
            'email' => 'required|email|unique:users',
            'first_name' => 'min:2|required',
            'password' => 'confirmed',
            'last_name' => 'min:3',
        ],
        'update' => [

        ],
    ];

    public function is($role_id)
    {
        return $this->role_id  == $role_id;
    }

    public function isBuyer()
    {
        return $this->role_id  == intval(Config::get('constants.ROLE_BUYER'));
    }

    public function isSeller()
    {
        return $this->role_id  == intval(Config::get('constants.ROLE_SELLER'));
    }

    public function isBroker()
    {
        return $this->role_id  == intval(Config::get('constants.ROLE_BROKER'));
    }

    public function isAdmin()
    {
        return $this->role_id  == intval(Config::get('constants.ROLE_ADMIN'));
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function seller()
    {
        return $this->hasOne('App\Models\Seller', 'user_id');
    }

    public function buyer()
    {
        return $this->hasOne('App\Models\Buyer', 'user_id');
    }

    public function broker()
    {
        return $this->hasOne('App\Models\Broker', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'recipient_id')->desc('last_reply');
    }

    public function allMessages()
    {
        return $this->hasMany('App\Models\Message', 'recipient_id')->orWhere('sender_id', $this->id)->desc('last_reply');        
    }

    public function unreadMessages()
    {
        return $this->hasMany('App\Models\Message', 'recipient_id')
            ->whereRaw('unread = 1 OR (sender_id = ? and receiver_replied = 1)', [$this->id])
            ->desc('last_reply');
    }

    public function sentMessages()
    {
        return $this->hasMany('App\Models\Message', 'sender_id')->desc('last_reply');
    }
    
    public function getProfileAttribute()
    {
        if($this->isBuyer())
        {
            return $this->buyer;
        }
        elseif($this->isSeller())
        {
            return $this->seller;
        }
        elseif($this->isBroker())
        {
            return $this->broker;
        }
        return null;
    }
    
    public function getListingsAttribute()
    {
        if($this->isSeller())
        {
            return $this->seller ? $this->seller->listings() : null;
        }
        elseif($this->isBroker())
        {
            return $this->broker ? $this->broker->listings() : null;
        }
        return $this->null;
    }
    
    public function getAdvertsAttribute()
    {
        if($this->isBuyer())
        {
            return $this->buyer ? $this->buyer->adverts() : null;
        }
        elseif($this->isBroker())
        {
            return $this->broker ? $this->broker->adverts() : null;
        }
        return $this->null;
    }
    
    public function getUserStatusAttribute()
    {
        switch($this->status)
        {
            case \Config::get('constants.USER_STATUS_PENDING'):
                return 'Verification Pending';
            case \Config::get('constants.USER_STATUS_VERIFIED'):
                return 'Verified';
            case \Config::get('constants.USER_STATUS_BANNED'):
                return 'Banned';
        }
    }

    public function getPhoto()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=160';
    }

}
