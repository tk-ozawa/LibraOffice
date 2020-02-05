<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reactions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('timeline_id')->comment('タイムラインID')->unsigned();
			$table->integer('user_id')->comment('お気に入りしたユーザーID')->unsigned();
			$table->integer('status')->default(1)->comment('0:無効, 1:有効');
			$table->timestamps();

			$table->foreign('timeline_id')->references('id')->on('timeline');
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
		Schema::dropIfExists('reactions');
	}
}
