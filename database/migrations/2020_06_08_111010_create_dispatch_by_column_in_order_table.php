<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispatchByColumnInOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('dispatch_by')->nullable();
            $table->string('dispatch_to')->nullable();
            $table->string('cn')->nullable();
            $table->string('dispatch_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('dispatch_by');
            $table->dropColumn('dispatch_to');
            $table->dropColumn('cn');
            $table->dropColumn('dispatch_status');
        });
    }
}
