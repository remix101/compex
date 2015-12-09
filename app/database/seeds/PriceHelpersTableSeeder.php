<?php

class PriceHelpersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('price_helpers')->delete();
        $prices = [];

        $prices[] = array(
            'min_price' => 100000,
            'max_price' => null,
        );

        $prices[] = array(
            'min_price' => 100000,
            'max_price' => 250000,
        );

        $prices[] = array(
            'min_price' => 250000,
            'max_price' => 500000,
        );

        $prices[] = array(
            'min_price' => 500000,
            'max_price' => 2000000,
        );

        $prices[] = array(
            'min_price' => null,
            'max_price' => 2000000,
        );

        $prices[] = array(
            'min_price' => null,
            'max_price' => null,
        );

        DB::table('price_helpers')->insert($prices);
    }

}
