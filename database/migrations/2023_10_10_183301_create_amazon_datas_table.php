<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_datas', function (Blueprint $table) {
            $table->id();
            $table->string('order_id',100)->nullable();
            $table->date('order_date')->nullable();
            $table->string('ship_to_state',100)->nullable();
            $table->string('vendor',100)->nullable();
            $table->string('customer_type',100)->nullable();
            $table->string('gst_percentage',100)->nullable();
            $table->string('payment_mode',100)->nullable();
            $table->string('total_sale',100)->nullable();
            $table->string('credit_note',100)->nullable();
            $table->string('debit_note',100)->nullable();
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
        Schema::dropIfExists('amazon_datas');
    }
};
