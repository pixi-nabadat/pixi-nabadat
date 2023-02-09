<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\PaymentMethodEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('phones')->nullable(); //cast array accept multiple phones
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->tinyInteger('featured')->default(0)->nullable();
            $table->double('avg_waiting_time')->nullable();
            $table->boolean('is_support_auto_service')->default(\App\Models\Center::NON_SUPPORT_AUTO_SERVICE);
            $table->string('google_map_url')->nullable();
            $table->double('rate')->default(0.0);
            $table->double('pulse_price');
            $table->double('app_discount');
            $table->string('support_payments')->default(PaymentMethodEnum::CASH);
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
        Schema::dropIfExists('centers');
    }
};
