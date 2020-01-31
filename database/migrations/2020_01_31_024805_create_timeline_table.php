<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelineTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timeline', function (Blueprint $table) {
			$table->increments('id');
			$table->string('content')->comment('行った処理の内容');
			$table->integer('user_id')->comment('ユーザーID')->unsigned();
			$table->integer('purchase_id')->comment('所持書籍ID')->unsigned();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('purchase_id')->references('id')->on('purchases');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('timeline');
	}
}
