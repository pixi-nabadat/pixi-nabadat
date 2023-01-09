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
        Schema::create('center_financials', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Center::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(\App\Models\Package::class)->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('num_palses');
            $table->double('center_dues');
            $table->double('app_dues');
            $table->double('regular_price');
            $table->double('discount');
            $table->boolean('status')->default(false);
            $table->date('date');
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
        Schema::dropIfExists('center_financials');
    }
};
