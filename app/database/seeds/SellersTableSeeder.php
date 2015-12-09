<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SellersTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        $users = [];
        $sellers = [];

        foreach(range(2, 20) as $index)
        {
            $users[] = array(
                'id' => $index,
                'first_name' => $faker->firstname,
                'last_name' => $faker->lastname,
                'email' => $faker->email,
                'role_id' => 1,
                'password' => Hash::make('password'),
            );
            
            $sellers[] = array(
                'id' => $index - 1,
                'user_id' => $index,
                'country' => intval(mt_rand(1, 40)),
                'address' => $faker->address,
            );
        }

        DB::table('users')->insert($users);
        DB::table('sellers')->insert($sellers);
    }

}
