<?php namespace App\Models;

class MenuItem extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['title', 'link', 'menu_id', 'sort_id'];
    
    public function menu()
    {
        return $this->belongsTo('Menu', 'menu_id');
    }
    
}
