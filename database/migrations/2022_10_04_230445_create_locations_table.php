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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 191);
            $table->text('title');
            $table->string('iso_code_3', 3)->nullable();
            $table->string('iso_code_2', 3)->nullable();
            $table->foreignIdFor(\App\Models\Currency::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->nestedSet();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
