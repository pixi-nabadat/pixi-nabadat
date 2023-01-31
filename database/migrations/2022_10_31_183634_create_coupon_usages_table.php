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
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Coupon::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('temp_user_id')->nullable();
            $table->integer('number_of_usage');
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
        Schema::dropIfExists('coupon_usages');
    }
};
