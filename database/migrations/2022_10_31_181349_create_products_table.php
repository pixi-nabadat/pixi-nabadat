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
            $table->integer('stock');
            $table->double('unit_price');
            $table->double('purchase_price');
            $table->double('discount');
            $table->enum('discount_type',['flat','percent'])->default('percent');
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
            $table->enum('tax_type',['flat','percent']);
            $table->double('tax')->default(0);
            $table->double('estimation')->default(0.0);
            $table->tinyInteger('featured')->default(0)->nullable();
            $table->boolean('is_active')->default(1)->nullable();
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
