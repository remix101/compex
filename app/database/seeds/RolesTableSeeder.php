<?php

class RolesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('roles')->delete();

		$roles = array(
			array('id' => 1, 'name' => 'admin'),
			array('id' => 2, 'name' => 'buyer'),
			array('id' => 3, 'name' => 'broker'),
			array('id' => 4, 'name' => 'seller'),
		);

		DB::table('roles')->insert($roles);
	}

}
