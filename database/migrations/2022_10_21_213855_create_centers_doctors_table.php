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
        Schema::create('center_doctor', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Center::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('center_devices');
    }
};
