<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alcs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->tinyInteger('auth')->default(1)->comment('0无权限1新增员工2编辑修改3全部都有');
            $table->tinyInteger('order')->default(1)->comment('0无权限1新增修改');
            $table->string('cate')->default('0')->comment('0无权限1分类管理2新增进货3商品管理4销售统计');
            $table->tinyInteger('view_name')->default(0)->comment('0不显示姓名1可显示姓名');
            $table->tinyInteger('view_address')->default(0)->comment('0不显示收货地址1可显示收货地址');
            $table->tinyInteger('view_phone')->default(0)->comment('0不显示手机号码1可显示手机号码');
            $table->tinyInteger('view_wechat')->default(0)->comment('0不显示微信号1可显示微信号');
            $table->tinyInteger('view_price')->default(0)->comment('0不显示订单价格1可显示订单价格');
            $table->tinyInteger('view_pay_status')->default(0)->comment('0不显示支付状态1可显示支付状态');
            $table->tinyInteger('view_pay_method')->default(0)->comment('0不显示支付方式1可显示支付方式');
            $table->tinyInteger('view_source')->default(0)->comment('0不显示订单来源1可显示订单来源');
            $table->tinyInteger('view_remark')->default(0)->comment('0不显示订单备注1可显示订单备注');
            $table->tinyInteger('view_express')->default(0)->comment('0不显示快递公司1可显示快递公司');
            $table->tinyInteger('view_number')->default(0)->comment('0不显示快递单号1可显示快递单号');
            $table->tinyInteger('view_express_status')->default(0)->comment('0不显示快递状态1可显示快递状态');
            $table->tinyInteger('view_express_date')->default(0)->comment('0不显示快递时间1可显示快递时间');
            $table->tinyInteger('view_goods_id')->default(1)->comment('0不显示主商品1可显示主商品');
            $table->string('view_add_goods')->comment('0不显示附加商品1可显示附加商品');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('alcs');
    }
}
