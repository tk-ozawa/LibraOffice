<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('request_user_id')->comment('依頼者ID')->unsigned();
			$table->integer('approval_user_id')->comment('承諾者ID')->unsigned();
			$table->integer('book_id')->comment('書籍ID')->unsigned();
			$table->integer('office_id')->comment('オフィスID')->unsigned();
			$table->timestamps();

			$table->foreign('request_user_id')->references('id')->on('users');
			$table->foreign('approval_user_id')->references('id')->on('users');
			$table->foreign('book_id')->references('id')->on('books');
			$table->foreign('office_id')->references('id')->on('offices');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('orders');
	}
}
