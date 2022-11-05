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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('added_by');
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('description')->nullable();
            $table->double('unit_price');
            $table->double('purchase_price');
            $table->double('discount');
            $table->tinyInteger('discount_type');
            $table->date('discount_start_date');
            $table->date('discount_end_date');
            $table->tinyInteger('tax_type');
            $table->double('tax');
            $table->tinyInteger('featured')->nullable();
            $table->integer('num_points');
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
        Schema::dropIfExists('products');
    }
};
