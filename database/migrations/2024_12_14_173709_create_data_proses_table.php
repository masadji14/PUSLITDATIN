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
            $table->foreignId('data_pegawai_id')->constrained('data_pegawais')->cascadeOnDelete();
            $table->date('tanggal_CPNS');
            $table->date('tanggal_PNS');
            $table->date('pensiun');
            $table->date('KGB');
            $table->date('KP');
            $table->date('tanggal_ulangtahun');
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
