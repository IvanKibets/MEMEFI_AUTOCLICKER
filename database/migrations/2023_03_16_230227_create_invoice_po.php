<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_po', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice',200)->nullable();
            // $table->bigInteger('amount')->nullable();
            $table->integer('total_item')->nullable();
            $table->date('payment_date')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
        Schema::create('invoice_po_item', function (Blueprint $table) {
            $table->id();
            $table->integer('po_id')->nullable();
            $table->integer('invoice_po_id')->nullable();
            $table->text('file')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->boolean('metode_pembayaran')->nullable();
            $table->boolean('status')->default(0)->nullable();
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
        Schema::dropIfExists('invoice_po');
    }
}
