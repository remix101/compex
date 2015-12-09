<?php namespace App\Models;

class PriceHelper extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
    protected $fillable = ['min_price', 'max_price'];

    public function getTextAttribute()
    {
        return $this->min_price != null ? (
            $this->max_price != null ? 
            price_to_string($this->min_price) . ' - ' . price_to_string($this->max_price) : 'Less than '. price_to_string($this->min_price)) : 
        ($this->max_price != null ? 'Over ' . price_to_string($this->max_price) : 'undisclosed');
    }

}
