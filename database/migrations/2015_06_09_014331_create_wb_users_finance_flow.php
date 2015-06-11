<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWbUsersFinanceFlow extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wb_users_finance_flow', function (Blueprint $table) {
            $table->increments('id');
            $table->char('flow_id',25)->unique()->comment = '流水号';
            $table->unsignedInteger('uid')->comment = '用户UID';
            $table->char('order_id',25)->comment = '订单号';
            $table->char('trade_no',50)->comment = '支付平台交易号';
            $table->decimal('amount', 10, 6)->comment = '交易金额';
            $table->tinyInteger('pay_channel',FALSE,TRUE)->comment = '支付渠道:支付宝;微信等';
            $table->tinyInteger('type',FALSE,TRUE)->comment = '交易类型,1:充值;2:提现';
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
        //
    }

}
