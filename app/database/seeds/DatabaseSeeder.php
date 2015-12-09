<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CountriesTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('PriceHelpersTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('BuyersTableSeeder');
		$this->call('SellersTableSeeder');
		$this->call('BrokersTableSeeder');
		$this->call('SiteConfigsTableSeeder');
		$this->call('MenusTableSeeder');
		$this->call('MenuItemsTableSeeder');
	}

}
