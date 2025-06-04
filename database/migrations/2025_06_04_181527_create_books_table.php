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
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('kode_buku')->unique();
        $table->string('isbn')->nullable();
        $table->string('judul');
        $table->string('penulis');
        $table->string('penerbit');
        $table->date('tanggal_terbit');
        $table->integer('jumlah_halaman');
        $table->string('kategori');
        $table->string('deskripsi')->nullable();
        $table->enum('status', ['available', 'unavailable'])->default('available');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
