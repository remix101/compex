<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSearchQueriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('search_queries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('search_term', 200);
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('results_count')->unsigned();
			$table->timestamps();
            $table->index('user_id');
            $table->index('search_term');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('search_queries');
	}

}
