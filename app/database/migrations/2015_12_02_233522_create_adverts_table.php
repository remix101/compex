<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvertsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('adverts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('heading', 120);
			$table->string('description', 255);
			$table->string('slug', 200);
			$table->integer('buyer_id')->unsigned()->nullable();
			$table->integer('broker_id')->unsigned()->nullable();
			$table->integer('category')->unsigned()->nullable();
			$table->integer('country')->unsigned()->nullable();
			$table->integer('asking_price')->unsigned()->nullable();
			$table->timestamps();
            $table->foreign('buyer_id')->references('id')->on('buyers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('broker_id')->references('id')->on('brokers')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category')->references('id')->on('categories')
                ->onDelete('no action')->onUpdate('cascade');
            $table->foreign('country')->references('id')->on('countries')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('asking_price')->references('id')->on('price_helpers')
                ->onDelete('cascade')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('adverts');
	}

}
