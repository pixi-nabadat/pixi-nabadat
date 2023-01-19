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
        Schema::create('schedule_fcms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content');
            $table->string('trigger');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('notification_via',['sms','fcm','mail'])->default('fcm');
            $table->boolean('is_active');
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
        Schema::dropIfExists('schedule_fcms');
    }
};
