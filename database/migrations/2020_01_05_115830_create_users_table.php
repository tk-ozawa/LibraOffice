<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->comment('社員名');
			$table->string('email')->comment('メールアドレス');
			$table->string('password');
			$table->integer('office_id')->comment('所属オフィスID')->unsigned();
			$table->integer('auth')->comment('権限 0:幹部以上, 1:一般');
			$table->string('profile')->nullable()->comment('自己紹介');
			$table->date('birthday')->nullable()->commnet('生年月日');
			$table->integer('status')->default(1)->commnet('アカウント状態 0:無効, 1:有効');
			$table->timestamps();

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
		Schema::dropIfExists('users');
	}
}
