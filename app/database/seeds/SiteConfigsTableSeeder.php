<?php

use App\Models\SiteConfig;
use Illuminate\Database\Seeder;

class SiteConfigsTableSeeder extends Seeder {

    public function run()
    {
        SiteConfig::create([
            'name' => 'search_pages',
            'value' => 10,
        ]);
    }

}
