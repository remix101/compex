<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageRepliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('message_replies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('sender_id')->unsigned();
			$table->integer('recipient_id')->unsigned();
			$table->integer('message_id')->unsigned();
			$table->string('message', 555);
            $table->boolean('unread')->default(1);
			$table->string('attachment', 512)->nullable();
			$table->timestamps();
            $table->foreign('message_id')->references('id')->on('messages')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')
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
		Schema::drop('message_replies');
	}

}
