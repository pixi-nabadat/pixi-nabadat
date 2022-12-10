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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->integer('payment_status')->default(1);
            $table->integer('payment_type')->default(1);
            $table->string('address_info');
            $table->foreignIdFor(\App\Models\Address::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->double('shipping_fees');
            $table->double('sub_total');
            $table->double('grand_total');
            $table->double('coupon_discount');
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
};
