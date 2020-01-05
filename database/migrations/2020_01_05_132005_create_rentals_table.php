<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rentals', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('purchase_id')->comment('所持書籍ID')->unsigned();
			$table->integer('user_id')->comment('貸出ユーザーID')->unsigned();
			$table->integer('status')->default(0)->comment('貸出状態 0:貸出中, 1:返却済');
			$table->timestamps();

			$table->foreign('purchase_id')->references('id')->on('purchases');
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('rentals');
	}
}
