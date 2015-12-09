<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 50);
			$table->string('last_name', 50);
			$table->string('title', 8)->default('Mr.');
			$table->string('verification_code', 10)->nullable();
			$table->string('email', 50);
			$table->string('password', 64);
			$table->integer('role_id')->unsigned();
			$table->integer('status')->unsigned()->default(1)->comment('1=Pending,2=Verified,3=Banned');
			$table->string('remember_token', 100)->nullable();
			$table->timestamp('last_login');
			$table->timestamps();
			$table->softDeletes();
			$table->unique('email');
			$table->index('first_name');
			$table->index('last_name');
            $table->foreign('role_id')->references('id')->on('roles')
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
		Schema::drop('users');
	}

}
