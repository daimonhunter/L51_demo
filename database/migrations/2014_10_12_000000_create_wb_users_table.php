<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWbUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wb_users', function(Blueprint $table)
		{
			$table->increments('uid');
            $table->string('nickname')->comment = '昵称';
			$table->char('mobile',11)->unique()->comment = '手机号';
			$table->string('password', 60)->comment = '密码';
            $table->tinyInteger('type',FALSE,TRUE)->comment = '用户类型,1:普通用户;2:投资人;etc..';
            $table->tinyInteger('status',FALSE,TRUE)->comment = '用户状态';
			$table->rememberToken();
            $table->unsignedInteger('create_at');   //创建时间
            $table->unsignedInteger('update_at');   //更新时间
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
