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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Center::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('day_of_week');
            $table->string('day_text');
            $table->time('from');
            $table->time('to');
            $table->boolean('is_active')->default(true);
            $table->unique(['day_of_week','center_id']);
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
        Schema::dropIfExists('appointments');
    }
};
