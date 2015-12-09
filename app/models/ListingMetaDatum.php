<?php namespace App\Models;

class ListingMetaDatum extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['meta_id', 'value'];
    
    protected $table = 'listing_meta_data';
    
    public function meta()
    {
        return $this->belongsTo('App\Models\ListingMetum', 'meta_id');
    }
    
}
