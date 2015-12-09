<?php namespace App\Models;

class Country extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['code', 'name', 'd_code'];
     
    public function listings()
    {
        return $this->hasMany('App\Models\Listing', 'country');
    }   
}
