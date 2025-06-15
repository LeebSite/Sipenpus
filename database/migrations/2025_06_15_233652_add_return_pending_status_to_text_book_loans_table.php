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
        Schema::table('text_book_loans', function (Blueprint $table) {
            // Ubah enum status untuk menambahkan 'return_pending'
            $table->enum('status', ['pending', 'active', 'return_pending', 'returned', 'rejected'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('text_book_loans', function (Blueprint $table) {
            // Kembalikan ke enum status yang lama
            $table->enum('status', ['pending', 'active', 'returned', 'rejected'])
                  ->default('pending')
                  ->change();
        });
    }
};
