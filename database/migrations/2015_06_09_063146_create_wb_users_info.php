<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWbUsersInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wb_users_info', function(Blueprint $table)
		{
			$table->unsignedInteger('id');
            $table->string('email')->unique()->comment = '邮箱';      //如果不是必填,转移到用户信息表
            $table->tinyInteger('gender',FALSE,TRUE)->comment = '性别';
            $table->string('avatar')->comment = '头像';
            $table->tinyInteger('real_name_auth',FALSE,TRUE)->comment = '是否经过实名认证';
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
		Schema::drop('wb_users_info');
	}

}
