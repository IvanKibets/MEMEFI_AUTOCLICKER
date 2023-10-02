<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDailyCash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_cash', function (Blueprint $table) {
            $table->id();
            $table->date('cash_date')->nullable();
            $table->integer('cash_transaction_pos')->nullable();
            $table->integer('cash_start')->nullable();
            $table->integer('cash_end')->nullable();
            $table->integer('daily_cash')->nullable();
            $table->integer('ct_vs_dc')->nullable();
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
        Schema::dropIfExists('daily_cash');
    }
}
