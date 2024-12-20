<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_proses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_pegawai_id');
            $table->foreign('data_pegawai_id')->references('id')->on('data_pegawais')->onDelete('cascade');
            $table->date('tanggal_CPNS')->nullable();
            $table->date('tanggal_PNS')->nullable();
            $table->date('pensiun');
            $table->date('KGB');
            $table->date('KP');
            $table->date('tanggal_lahir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_proses');
    }
};
