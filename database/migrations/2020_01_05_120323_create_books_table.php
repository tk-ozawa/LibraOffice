<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title')->comment('書籍名');
			$table->string('ISBN');
			$table->integer('edition')->comment('版');
			$table->string('img_url')->comment('表紙画像URL');
			$table->integer('publisher_id')->comment('出版社ID')->unsigned();
			$table->integer('price')->comment('価格');
			$table->date('release_date')->comment('発売日');

			$table->foreign('publisher_id')->references('id')->on('publishers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('books');
	}
}
