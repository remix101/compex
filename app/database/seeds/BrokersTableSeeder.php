<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BrokersTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        $users = [];
        $brokers = [];

        foreach(range(41, 60) as $index)
        {
            $users[] = array(
                'id' => $index,
                'first_name' => $faker->firstname,
                'last_name' => $faker->lastname,
                'email' => $faker->email,
                'role_id' => 1,
                'password' => Hash::make('password'),
            );

            $brokers[] = array(
                'id' => $index - 40,
                'country' => intval(mt_rand(1, 40)),
                'user_id' => $index,
                'address' => $faker->address,
            );
        }

        DB::table('users')->insert($users);
        DB::table('brokers')->insert($brokers);
    }

}
