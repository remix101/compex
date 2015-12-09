<?php namespace App\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class Article extends BaseModel implements SluggableInterface
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'title' => 10,
            'html' => 6,
            'roles.name' => 5,
        ],
        'joins' => [
            'roles' => ['roles.id','articles.category_id'],
        ],
    ];

    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];
    
    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['title', 'slug', 'html', 'published', 'user_id', 'category_id', 'featured_img'];
    
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Models\Role', 'category_id');
    }
    
    public function getFeaturedImageAttribute()
    {
        return $this->featured_img ? url('files/'.$this->featured_img) : url('assets/img/thumb.jpg');
    }
    
}
