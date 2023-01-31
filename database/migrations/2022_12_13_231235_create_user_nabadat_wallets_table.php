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
        Schema::create('user_nabadat_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->float('total_pulses')->default(0);
            $table->float('used_amount')->default(0);
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
        Schema::dropIfExists('nabadat_wallets');
    }
};
