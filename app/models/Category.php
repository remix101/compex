<?php namespace App\Models;

class Category extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['name', 'parent_id'];
    
    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }
    
    public function listings()
    {
        return $this->hasMany('App\Models\Listing', 'category');
    }
}
