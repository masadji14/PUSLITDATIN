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
        Schema::table('data_pegawais', function (Blueprint $table) {
            $table->date('tmt_cpns')->nullable()->change();
            $table->date('tmt_pns')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_pegawais', function (Blueprint $table) {
            $table->date('tmt_cpns')->nullable(false)->change();
            $table->date('tmt_pns')->nullable(false)->change();
        });
    }
};
