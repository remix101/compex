<?php namespace App\Models;

class SearchQuery extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['search_term', 'results_count', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
    
}
