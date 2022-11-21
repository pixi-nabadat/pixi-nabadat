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
        Schema::create('nabadat_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Reservation::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');//adding the reservation id
            $table->foreignIdFor(\App\Models\Center::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Device::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('num_nabadat');
            $table->double('nabada_price');
            $table->double('total_price');
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
        Schema::dropIfExists('nabadat_histories');
    }
};
