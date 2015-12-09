<?php namespace App\Models;

class ListingMetum extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['category_id', 'name', 'option_type', 'option_data'];
    
    protected $table = 'listing_metas';
    
    public function data()
    {
        return $this->hasMany('App\Models\ListingMetaDatum', 'meta_id');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Models\ListingMetaCategory', 'category_id');
    }
    
}
