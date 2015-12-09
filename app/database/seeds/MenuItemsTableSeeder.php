<?php

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('menu_items')->truncate();
        
        MenuItem::create([
            'menu_id' => 1,
            'title' => 'Support',
            'link' => url('support'),
        ]);
        MenuItem::create([
            'menu_id' => 1,
            'title' => 'Frequently Asked Questions',
            'link' => url('faq'),
        ]);
    }

}
