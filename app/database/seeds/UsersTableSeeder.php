<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		$users = array(
			array(
                'id' => 1,
                'first_name' => 'Site',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'role_id' => 1,
                'status' => 2,
                'password' => Hash::make('password'),
            ),
		);

		DB::table('users')->insert($users);
    }

}
