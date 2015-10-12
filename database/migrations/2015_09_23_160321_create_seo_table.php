<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seo', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('title')->nullable();
			$table->mediumText('description')->nullable();
			$table->integer('document_id');
			$table->string('document_type');
			$table->double('priority', 1, 1)->default('0')->unsigned();
			$table->string('h1')->nullable();
			$table->string('frequency')->nullable();
			$table->string('robots')->nullable();
			$table->string('state')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('seo');
	}

}