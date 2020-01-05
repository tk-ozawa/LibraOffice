<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchases', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('book_id')->commnet('書籍ID')->unsigned();
			$table->integer('user_id')->commnet('購入ユーザーID')->unsigned();
			$table->integer('office_id')->comment('所持オフィスID')->unsigned();
			$table->date('purchase_date')->comment('購入日');
			$table->integer('status')->default(0)->comment('所持状態 0:未所持, 1:所持');
			$table->timestamps();

			$table->foreign('book_id')->references('id')->on('books');
			$table->foreign('user_id')->references('id')->on('users');
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
		Schema::dropIfExists('purchases');
	}
}
