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
            $table->double('discount');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('min_buy')->nullable();
            $table->enum('coupon_for',['store','reservation'])->default('store');
            $table->unsignedInteger('allowed_usage')->default(1);
            $table->boolean('is_active')->default(\App\Enum\ActivationStatusEnum::ACTIVE);
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
