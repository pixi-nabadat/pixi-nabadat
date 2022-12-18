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
        if (!Schema::connection(env('DB_CONNECTION', 'mysql'))->hasTable('locations')) {
            Schema::create('locations', function (Blueprint $table) {
                $table->id();
                $table->string('slug', 191)->nullable();
                $table->text('title');
                $table->float('shipping_cost')->default(0);
                $table->foreignIdFor(\App\Models\Currency::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
                $table->tinyInteger('is_active')->default(1);
                $table->timestamps();
                $table->nestedSet();
            });
        }
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
