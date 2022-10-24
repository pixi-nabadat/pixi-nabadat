<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection(env('DB_CONNECTION', 'mysql'))->hasTable('currencies')) {
            Schema::create('currencies', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('name')->unique();
                $table->string('code', 50)->unique();
                $table->string('symbol', 5)->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('currencies');
    }
}
