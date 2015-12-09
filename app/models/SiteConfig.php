<?php namespace App\Models;

class SiteConfig extends BaseModel {

    /**
    * The properties of this model that can be filled automatically
    */
	protected $fillable = ['name', 'value'];
    
    public function scopeByName($query, $configName)
    {
        return $query->where('name', '=', $configName);
    }
    
    public static function getValueByName($configName)
    {
        $config = SiteConfig::byName($configName)->first();
        return $config != null ? $config->value : null;
    }
    
}
