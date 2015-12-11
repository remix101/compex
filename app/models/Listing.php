<?php namespace App\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class Listing extends BaseModel implements SluggableInterface
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
            'state' => 5,
            'description' => 6,
            'countries.name' => 5,
            'categories.name' => 5,
        ],
        'joins' => [
            'categories' => ['categories.id','listings.category'],
            'countries' => ['countries.id','listings.country'],
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
    protected $fillable = ['heading', 'state', 'city', 'country', 'ask_price', 'yearly_revenue', 'cash_flow', 'operation_cost', 'ask_price_exact', 'yearly_revenue_exact', 'cash_flow_exact', 'operation_cost_exact', 'slug', 'description', 'category', 'seller_id', 'broker_id', 'property_status', 'year_founded', 'assets_included', 'company_website', 'employee_no', 'relocatable', 'expansion_potential', 'assets_worth', 'reason'];

    /**
     * Model Validation Rules
     */
    protected $rules = [
        'create' => [
            'country' => 'required|exists:countries,id',
            'category' => 'required|exists:categories,id',
            'description' => 'required|min:5',
            'heading' => 'required|min:5',
            'broker_id' => 'exists:brokers,id',
            'seller_id' => 'exists:sellers,id',
        ],
        'update' => [
            'country' => 'exists:countries,id',
            'category' => 'exists:categories,id',
            'description' => 'min:5',
            'heading' => 'min:5',
        ],
    ];


    public function seller()
    {
        return $this->belongsTo('App\Models\Seller', 'seller_id');
    }

    public function broker()
    {
        return $this->belongsTo('App\Models\Broker', 'broker_id');
    }

    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\ListingPhoto', 'listing_id');
    }

    public function askPrice()
    {
        return $this->belongsTo('App\Models\PriceHelper', 'ask_price');
    }

    public function isLease()
    {
        return $this->property_status == Config::get('constants.PROPERTY_STATUS_LEASE');
    }

    public function isFreehold()
    {
        return $this->property_status == Config::get('constants.PROPERTY_STATUS_FREEHOLD');
    }

    public function isReal()
    {
        return $this->property_status == Config::get('constants.PROPERTY_STATUS_REAL');
    }

    public function isLeaseAndFreehold()
    {
        return $this->property_status == Config::get('constants.PROPERTY_STATUS_BOTH');
    }

    public function getYearlyRevenue()
    {
        return $this->belongsTo('App\Models\PriceHelper', 'yearly_revenue');
    }

    public function getSalesRevenueAttribute()
    {
        return $this->yearly_revenue ? $this->getYearlyRevenue->text : 
        ($this->yearly_revenue_exact ? price_to_string($this->yearly_revenue_exact) : 'Undisclosed');
    }

    public function cashFlow()
    {
        return $this->belongsTo('App\Models\PriceHelper', 'cash_flow');
    }

    public function getCashFlowTextAttribute()
    {
        return $this->cash_flow ? $this->cashFlow->text : 
        ($this->cash_flow_exact ? price_to_string($this->cash_flow_exact) : 'Undisclosed');
    }

    public function operationCost()
    {
        return $this->belongsTo('App\Models\PriceHelper', 'operation_cost');
    }

    public function getOperationCostTextAttribute()
    {
        return $this->operation_cost ? $this->operationCost->text : 
        ($this->operation_cost_exact ? price_to_string($this->operation_cost_exact) : 'Undisclosed');
    }

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Category', 'category');
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', '=', 1);
    }

    public function scopeApproved($query)
    {
        return $query->where('verified', '=', 1);
    }

    public function scopePending($query)
    {
        return $query->where('verified', '=', 0);
    }

    public function getAskingPriceAttribute()
    {
        return $this->ask_price ? $this->askPrice->text : 
        ($this->ask_price_exact ? price_to_string($this->ask_price_exact) : 'Undisclosed');
    }

    public function getAssetWorthAttribute()
    {
        return $this->assets_worth ? price_to_string($this->assets_worth) : 'Undisclosed';
    }

    public function getCategoryNameAttribute()
    {
        return $this->getCategory->name;
    }

    public function getCountryNameAttribute()
    {
        return $this->getCountry->name;
    }

    public function getUrlAttribute()
    {
        return url('listings/'.$this->slug);
    }

    public function getLocationAttribute()
    {
        return $this->state . ', ' . $this->countryName;
    }

    public function getUserAttribute()
    {
        if($this->seller != null)
        {
            return $this->seller->user;
        }
        if($this->broker != null)
        {
            return $this->broker->user;
        }
    }

    public function getStatusAttribute()
    {
        switch($this->property_status)
        {
            case \Config::get('constants.PROPERTY_STATUS_NA'):
                return 'N/A';
            case \Config::get('constants.PROPERTY_STATUS_FREEHOLD'):
                return 'Real Property';
            case \Config::get('constants.PROPERTY_STATUS_LEASE'):
                return 'On Lease';
            case \Config::get('constants.PROPERTY_STATUS_BOTH'):
                return 'Both';
        }
    }

    public function getThumbnailAttribute()
    {
        return $this->photos->count() > 0 ? $this->photos->first()->url : url('assets/img/thumb.jpg');
    }

}
