<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BuyersTableSeeder extends Seeder {

	public function run()
	{
        $faker = Faker::create();
        $users = [];
        $buyers = [];

        foreach(range(21, 40) as $index)
        {
            $users[] = array(
                'id' => $index,
                'first_name' => $faker->firstname,
                'last_name' => $faker->lastname,
                'email' => $faker->email,
                'role_id' => 1,
                'password' => Hash::make('password'),
            );
            
            $buyers[] = array(
                'id' => $index - 20,
                'country' => intval(mt_rand(1, 40)),
                'user_id' => $index,
                'address' => $faker->address,
            );
        }

        DB::table('users')->insert($users);
        DB::table('buyers')->insert($buyers);
	}

}
