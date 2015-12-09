<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListingMetasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('listing_metas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->string('name', 20);
			$table->string('description', 80)->nullable();
			$table->integer('option_type')->unsigned()->comment('0=Text,1=BigText,2=Dropdown,3=Radio,4=Checkbox')->default(0);
			$table->text('option_data')->nullable();
			$table->timestamps();
            $table->foreign('category_id')->references('id')->on('listing_meta_categories')
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
		Schema::drop('listing_metas');
	}

}
