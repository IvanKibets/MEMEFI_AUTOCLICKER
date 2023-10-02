<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserMemberSimpananWajib extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_member_simpanan_wajib', function (Blueprint $table) {
            $table->id();
            $table->integer('user_member_id')->nullable();
            $table->smallInteger('tahun')->nullable();
            $table->integer('januari')->nullable();
            $table->integer('februari')->nullable();
            $table->integer('maret')->nullable();
            $table->integer('april')->nullable();
            $table->integer('mei')->nullable();
            $table->integer('juni')->nullable();
            $table->integer('juli')->nullable();
            $table->integer('agustus')->nullable();
            $table->integer('september')->nullable();
            $table->integer('oktober')->nullable();
            $table->integer('november')->nullable();
            $table->integer('desember')->nullable();
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
        Schema::dropIfExists('user_member_simpanan_wajib');
    }
}
