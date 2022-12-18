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
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone'); //cast array accept multiple phones
            $table->foreignIdFor(\App\Models\Location::class);
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->boolean('is_active')->default(\App\Models\Center::ACTIVE);
            $table->tinyInteger('featured')->default(0)->nullable();
            $table->double('avg_wating_time')->nullable();
            $table->boolean('is_support_auto_service')->default(\App\Models\Center::NON_SUPPORT_AUTO_SERVICE);
            $table->string('google_map_url')->nullable();
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
        Schema::dropIfExists('centers');
    }
};
