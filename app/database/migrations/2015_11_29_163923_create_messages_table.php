<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('sender_id')->unsigned();
			$table->integer('recipient_id')->unsigned();
			$table->string('message', 555);
            $table->boolean('unread')->default(1);
			$table->timestamp('last_reply')->nullable();
			$table->boolean('receiver_replied');
			$table->integer('listing_id')->unsigned()->nullable();
			$table->timestamps();
            $table->foreign('listing_id')->references('id')->on('listings')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('users')
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
		Schema::drop('messages');
	}

}
