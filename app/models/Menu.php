<?php namespace App\Models;

class Menu extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['name', 'sort_id'];
    
    public function items()
    {
        return $this->hasMany('App\Models\MenuItem', 'menu_id');
    }
    
}
