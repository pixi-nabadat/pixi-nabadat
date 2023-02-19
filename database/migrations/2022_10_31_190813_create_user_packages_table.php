<?php

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
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
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Center::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Package::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('num_nabadat');
            $table->double('price');
            $table->double('discount_percentage')->default(0);
            $table->enum('payment_method',[PaymentMethodEnum::CASH,PaymentMethodEnum::CREDIT]);
            $table->enum('payment_status',[PaymentStatusEnum::PAID,PaymentStatusEnum::UNPAID]);
            $table->enum('status',[\App\Enum\UserPackageStatusEnum::PENDING,\App\Enum\UserPackageStatusEnum::READYFORUSE,\App\Enum\UserPackageStatusEnum::ONGOING,\App\Enum\UserPackageStatusEnum::COMPLETED]);
            $table->integer('used')->default(0);
            $table->integer('remain')->default(0);
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
        Schema::dropIfExists('user_packages');
    }
};
