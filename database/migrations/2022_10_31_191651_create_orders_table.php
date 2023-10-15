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
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('payment_status',[\App\Enum\PaymentStatusEnum::PAID,\App\Enum\PaymentStatusEnum::UNPAID])->default(\App\Enum\PaymentStatusEnum::UNPAID);
            $table->enum('payment_method',[\App\Enum\PaymentMethodEnum::CASH,\App\Enum\PaymentMethodEnum::CREDIT])->nullable();
            $table->longText('address_info');
            $table->foreignIdFor(\App\Models\Address::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->double('shipping_fees')->default(0);
            $table->double('sub_total');
            $table->double('grand_total');
            $table->double('coupon_discount')->default(0);
            $table->double('points_discount')->comment('number of pounds that get from points')->default(0);
            $table->double('paymob_transaction_id')->nullable();
            $table->nullableMorphs('relatable');
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
};
