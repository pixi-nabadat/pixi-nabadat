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
        Schema::create('reservation_history', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade')->onUpdate('cascade');//patient id
            $table->foreignIdFor(\App\Models\Reservation::class)->constrained()->onDelete('cascade')->onUpdate('cascade');//reservation id
            $table->enum('action', ['pending', 'confirmed', 'completed', 'expired'])->nullable();//action the center user done
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
        Schema::dropIfExists('reservations');
    }
};
