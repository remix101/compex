<?php namespace App\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class Advert extends BaseModel implements SluggableInterface
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'heading' => 10,
            'description' => 6,
            'countries.name' => 5,
            'categories.name' => 5,
        ],
        'joins' => [
            'categories' => ['categories.id','adverts.category'],
            'countries' => ['countries.id','adverts.country'],
        ],
    ];

    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'heading',
        'save_to'    => 'slug',
    ];

    /**
    * The properties of this model that can be filled automatically
    */
    protected $fillable = ['description', 'broker_id', 'buyer_id', 'category', 'heading', 'country', 'asking_price'];

    public function buyer()
    {
        return $this->belongsTo('App\Models\Buyer', 'buyer_id');
    }

    public function broker()
    {
        return $this->belongsTo('App\Models\Broker', 'broker_id');
    }

    public function askingPrice()
    {
        return $this->belongsTo('App\Models\PriceHelper', 'asking_price');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category');
    }

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Category', 'category');
    }

    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }

    public function getCategoryNameAttribute()
    {
        return $this->getCategory->name;
    }
    
    public function getCountryNameAttribute()
    {
        return $this->getCountry->name;
    }
    
    public function getUserAttribute()
    {
        if($this->buyer != null)
        {
            return $this->buyer->user;
        }
        if($this->broker != null)
        {
            return $this->broker->user;
        }
    }

}
