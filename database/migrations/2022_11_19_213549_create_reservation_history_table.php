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
            $table->foreignIdFor(\App\Models\Reservation::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('status');
            $table->foreignIdFor(\App\Models\CancelReason::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('comment')->nullable();
            $table->foreignId('added_by')->nullable()->references('id')->on('users')->onDelete(null)->onUpdate('cascade');
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
        Schema::dropIfExists('reservation_history');
    }
};
