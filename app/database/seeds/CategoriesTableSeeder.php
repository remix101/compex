<?php

class CategoriesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('categories')->delete();
        //basic categories
        $categories = array();
        $categories[] = array("name" => "Agribusiness");
        $categories[] = array("name" => "Banking");
        $categories[] = array("name" => "Food & Beverage");
        $categories[] = array("name" => "Franchise Releases");
        $categories[] = array("name" => "Leisure");
        $categories[] = array("name" => "Manufacturing");
        $categories[] = array("name" => "Real Estate");
        $categories[] = array("name" => "Retail");
        $categories[] = array("name" => "Services");
        $categories[] = array("name" => "Tech & Media");
        $categories[] = array("name" => "Wholesale & Distribution");
        $categories[] = array("name" => "Oil & Gas"); 
        $categories[] = array("name" => "Hospitality - Hotel");
        $categories[] = array("name" => "Resturant & Bar");
        $categories[] = array("name" => "Waste Recycling");
        $categories[] = array("name" => "Education"); 
        $categories[] = array("name" => "Financial Service");
        $categories[] = array("name" => "Health services");
        $categories[] = array("name" => "Internet");
        $categories[] = array("name" => "Insurance");
        $categories[] = array("name" => "E-commerce");
        $categories[] = array("name" => "Import and Export");
        
        DB::table('categories')->insert($categories);
    }

}
