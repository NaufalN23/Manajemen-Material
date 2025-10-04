<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('judul_laporan');
            $table->enum('jenis_laporan', ['stok', 'permintaan', 'pengembalian', 'riwayat']);
            $table->json('data_laporan');
            $table->date('periode_mulai');
            $table->date('periode_akhir');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};