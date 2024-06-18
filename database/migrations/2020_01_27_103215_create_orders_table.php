<?php

use App\Utils\Constants\AppConst;
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
            $table->bigIncrements('id');
            $table->string('order_taker_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->string('product')->nullable();
            $table->string('quantity')->nullable();
            $table->string('price')->nullable();
            $table->string('currency')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('email')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('city')->nullable();
            $table->string('open_by')->nullable();
            $table->enum('status',array_values(AppConst::$status))->default('Latest');
            $table->softDeletes();
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
