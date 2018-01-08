<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('user_id')->comment('订单关联员工id');
            $table->string('name')->comment('收货人姓名');
            $table->string('address')->comment("收货地址");
            $table->string('phone')->comment('手机号码');
            $table->string('wechat')->comment('微信号');
            $table->string('price')->comment('订单价格');
            $table->tinyInteger('pay_status')->comment('支付状态');
            $table->tinyInteger('pay_method')->comment('0微信1支付宝2银行转账3信用卡');
            $table->string('source')->comment('订单来源');
            $table->string('remark')->comment('订单备注');
            $table->string('express')->comment('快递公司');
            $table->string('number')->comment('快递单号');
            $table->tinyInteger('express_status')->comment('快递状态');
            $table->integer('goods_id')->comment('主商品id');
            $table->string('add_goods')->comment('附加商品id 逗号分隔');
            $table->timestamps();
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
