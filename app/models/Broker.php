<?php namespace App\Models;

use Nicolaslopezj\Searchable\SearchableTrait;

class Broker extends BaseModel
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'business_name' => 10,
            'users.last_name' => 10,
            'users.first_name' => 9,
            'address' => 5,
        ],
        'joins' => [
            'users' => ['users.id','brokers.user_id'],
        ],
    ];
    
    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['work_phone', 'user_id', 'phone_number', 'address', 'state', 'city', 'country', 'business_name'];
    
    /*** 
     * 
     */
    protected $table = 'brokers';
    
    /**
     * Model Validation Rules
     */
    protected $rules = [
        'create' => [
            'country' => 'exists:countries,id',
            'work_phone' => 'regex:/^\+[1-9]{1}[0-9]{3,14}$/',
            'phone_number' => 'regex:/^\+[1-9]{1}[0-9]{3,14}$/'
        ],
        'update' => [
            'work_phone' => 'regex:/^\+[1-9]{1}[0-9]{3,14}$/',
            'phone_number' => 'regex:/^\+[1-9]{1}[0-9]{3,14}$/'
        ],
    ];
    
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }   

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }
    
    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }

    public function listings()
    {
        return $this->hasMany('App\Models\Listing', 'broker_id');
    }

    public function adverts()
    {
        return $this->hasMany('App\Models\Advert', 'broker_id');
    }

}
