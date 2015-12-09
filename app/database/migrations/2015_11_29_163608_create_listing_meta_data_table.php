<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListingMetaDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('listing_meta_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('meta_id')->unsigned();
			$table->string('value', 255);
			$table->timestamps();
            $table->foreign('meta_id')->references('id')->on('listing_metas')
                ->onUpdate('cascade')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('listing_meta_data');
	}

}
