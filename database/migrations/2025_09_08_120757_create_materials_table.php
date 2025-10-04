<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('kode_material')->unique();
            $table->string('nama_material');
            $table->text('deskripsi')->nullable();
            $table->string('satuan');
            $table->integer('stok')->default(0);
            $table->integer('minimum_stok')->default(0);
            $table->decimal('harga', 15, 2)->default(0);
            $table->string('lokasi_penyimpanan')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
};