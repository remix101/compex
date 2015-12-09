<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('listings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('heading', 120);
			$table->string('state', 50)->nullable();
			$table->string('city', 50)->nullable();
			$table->integer('country')->unsigned();
			$table->integer('ask_price')->unsigned()->nullable();
			$table->decimal('ask_price_exact', 14,2)->unsigned()->nullable();
			$table->integer('yearly_revenue')->unsigned()->nullable();
			$table->decimal('yearly_revenue_exact', 14, 2)->unsigned()->nullable();
			$table->integer('cash_flow')->unsigned()->nullable();
			$table->decimal('cash_flow_exact', 14, 2)->unsigned()->nullable();
			$table->integer('operation_cost')->unsigned()->nullable();
			$table->decimal('operation_cost_exact', 14, 2)->unsigned()->nullable();
			$table->string('slug', 50);
			$table->text('description');
			$table->integer('category')->unsigned()->nullable();
			$table->integer('seller_id')->unsigned()->nullable();            
			$table->integer('broker_id')->unsigned()->nullable();            
			$table->boolean('verified')->nullable();
			$table->integer('property_status')->unsigned()->comment('0=N/A,1=Freehold,2=Lease,3=Both')->nullable();
			$table->integer('year_founded')->unsigned()->nullable();
			$table->boolean('assets_included')->nullable();
			$table->string('company_website', 80)->nullable();
			$table->string('expansion_potential', 500)->nullable();
			$table->string('reason', 500)->nullable();
			$table->integer('employee_no')->unsigned()->nullable();
			$table->decimal('assets_worth', 14, 2)->unsigned()->nullable();
			$table->boolean('relocatable')->nullable();
			$table->bigInteger('views')->unsigned();
			$table->timestamps();
			$table->index('slug');
			$table->index('ask_price');
			$table->index('ask_price_exact');
            $table->foreign('seller_id')->references('id')->on('sellers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('broker_id')->references('id')->on('brokers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('country')->references('id')->on('countries')
                ->onUpdate('cascade');
            $table->foreign('category')->references('id')->on('categories')
                ->onUpdate('cascade');
            $table->foreign('ask_price')->references('id')->on('price_helpers')
                ->onUpdate('cascade');
            $table->foreign('yearly_revenue')->references('id')->on('price_helpers')
                ->onUpdate('cascade');
            $table->foreign('cash_flow')->references('id')->on('price_helpers')
                ->onUpdate('cascade');
            $table->foreign('operation_cost')->references('id')->on('price_helpers')
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
		Schema::drop('listings');
	}

}
