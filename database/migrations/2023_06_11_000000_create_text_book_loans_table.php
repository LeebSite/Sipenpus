<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('text_book_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('text_book_id')->constrained()->onDelete('cascade');
            $table->string('mata_pelajaran');
            $table->string('guru_pengampu');
            $table->string('kelas_keperluan');
            $table->integer('jumlah');
            $table->date('loan_date');
            $table->date('return_date');
            $table->enum('status', ['pending', 'active', 'returned', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('text_book_loans');
    }
};