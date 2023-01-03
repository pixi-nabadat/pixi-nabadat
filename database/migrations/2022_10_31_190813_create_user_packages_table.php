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
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Center::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Package::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('num_nabadat');
            $table->double('price');
            $table->double('discount_percentage');
            $table->integer('payment_method');
            $table->integer('payment_status');
            $table->integer('usage_status');
            $table->integer('used');
            $table->integer('remaining');
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
        Schema::dropIfExists('user_packages');
    }
};
