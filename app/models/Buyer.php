<?php namespace App\Models;

class Buyer extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
    protected $fillable = ['work_phone', 'user_id', 'phone_number', 'address', 'state', 'city', 'country'];
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
    
    public function adverts()
    {
        return $this->hasMany('App\Models\Advert', 'buyer_id');
    }
    
    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }

}
