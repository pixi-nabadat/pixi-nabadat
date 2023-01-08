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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('code')->unique();
            $table->enum('discount_type',['flat','percent'])->default('percent');
            $table->double('discount');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('coupon_limit');
            $table->enum('coupon_type', ['product', 'reservation'])->default('store');
            $table->double('min_buy')->nullable();
            $table->unsignedInteger('allowed_usage')->default(1);
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
        Schema::dropIfExists('coupons');
    }
};
