<?php namespace App\Models;

class ListingPhoto extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
    protected $fillable = ['listing_id', 'photo_url', 'photo_caption'];

    public static function boot()
    {
        parent::boot();
        //delete associated file
        static::deleting(function($photo){
            unlink(public_path('files/').$photo->photo_url);
        });
    }

    public function listing()
    {
        return $this->belongsTo('App\Models\Listing', 'listing_id');
    }

    public function getUrlAttribute()
    {
        return url('files/'.$this->photo_url);
    }
}
