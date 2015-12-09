<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder {

    public function run()
    {
        Menu::create([
            'id' => 1,
            'name' => 'Advice & Features',
            'link' => '#',
        ]);
    }

}
