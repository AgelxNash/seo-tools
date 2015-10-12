<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordSeoTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('keyword_seo', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('seo_id')->unsigned()->index();
			$table->foreign('seo_id')->references('id')->on('seo')->onDelete('cascade');
			$table->integer('keyword_id')->unsigned()->index();
			$table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('cascade');
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
		Schema::drop('keyword_seo');
	}
}