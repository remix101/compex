<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBusinessNameToBrokersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('brokers', function(Blueprint $table)
		{
			$table->string('business_name', 120)->nullable();
		});
		Schema::table('sellers', function(Blueprint $table)
		{
			$table->string('business_name', 120)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('brokers', function(Blueprint $table)
		{
			$table->dropColumn('business_name');
		});
		Schema::table('sellers', function(Blueprint $table)
		{
			$table->dropColumn('business_name');
		});
	}

}
