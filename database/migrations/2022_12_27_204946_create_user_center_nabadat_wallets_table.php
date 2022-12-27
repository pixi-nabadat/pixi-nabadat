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
        Schema::create('user_center_nabadat_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Center::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onUpdate('cascade')->onUpdate('cascade');
            $table->float('total_pulses')->default(0);
            $table->float('used_pulses')->default(0);
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid');
            $table->string('payment_type')->default('cash');
            $table->unique(['center_id','user_id'],'user_center_wallet');
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
        Schema::dropIfExists('user_center_nabadat_wallets');
    }
};
