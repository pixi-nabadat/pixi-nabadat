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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('coupon_code');
            $table->double('discount');
            $table->double('sub_total');
            $table->double('net_total');
            $table->double('grand_total');
            $table->double('tax');
            $table->double('shipping_cost');
            $table->foreignIdFor(\App\Models\Address::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('carts');
    }
};
