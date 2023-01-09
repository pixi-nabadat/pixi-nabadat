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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('address');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('governerate_id');
            $table->unsignedInteger('city_id');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('phone');
            $table->string('postal_code');
            $table->boolean('is_default')->default(1);
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
        Schema::dropIfExists('addresses');
    }
};
