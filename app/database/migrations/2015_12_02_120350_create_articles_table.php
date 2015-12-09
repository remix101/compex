<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 200);
			$table->string('slug', 255);
			$table->string('featured_img', 255);
			$table->text('html');
			$table->integer('user_id')->unsigned();
			$table->integer('views')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->boolean('published')->default(0);
			$table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('no action')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('roles')
                ->onDelete('no action')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}
