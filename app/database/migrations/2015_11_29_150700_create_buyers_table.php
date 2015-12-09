<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuyersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('buyers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('work_phone', 15);
			$table->string('phone_number', 15);
			$table->string('address', 120)->nullable();
			$table->string('state', 50)->nullable();
			$table->string('city', 50)->nullable();
			$table->integer('country')->unsigned()->nullable();
			$table->integer('user_id')->unsigned();
			$table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('country')->references('id')->on('countries')
                ->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('buyers');
	}

}
