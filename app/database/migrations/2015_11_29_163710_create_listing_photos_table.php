<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListingPhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('listing_photos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('listing_id')->unsigned();
			$table->string('photo_url', 512);
			$table->string('photo_caption', 80)->nullable();
			$table->timestamps();
            $table->foreign('listing_id')->references('id')->on('listings')
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
		Schema::drop('listing_photos');
	}

}
