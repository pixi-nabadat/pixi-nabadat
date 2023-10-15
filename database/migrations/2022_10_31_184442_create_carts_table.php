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
            $table->foreignIdFor(\App\Models\User::class)->nullable()->unique()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->on('coupons')->references('id')->onDelete('set null')->onUpdate('cascade');
            $table->double('coupon_discount')->default(0.0);
            $table->double('sub_total')->default(0.0);
            $table->double('net_total')->default(0.0);
            $table->double('grand_total')->default(0.0);
            $table->double('shipping_cost')->default(0.0);
            $table->string('temp_user_id')->unique();
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
