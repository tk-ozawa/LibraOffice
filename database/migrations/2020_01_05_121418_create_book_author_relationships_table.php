<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookAuthorRelationshipsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_author_relationships', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('book_id')->unsigned();
			$table->integer('author_id')->unsigned();

			$table->foreign('book_id')->references('id')->on('books');
			$table->foreign('author_id')->references('id')->on('authors');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('book_author_relationships');
	}
}
