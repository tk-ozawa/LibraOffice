<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCategoriesRelationshipsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_categories_relationships', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('book_id')->unsigned();
			$table->integer('category_id')->unsigned();

			$table->foreign('book_id')->references('id')->on('books');
			$table->foreign('category_id')->references('id')->on('categories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('book_categories_relationships');
	}
}
