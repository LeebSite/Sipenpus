<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TextBook;

class TextBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $textBooks = [
            [
                'judul' => 'Matematika Kelas X',
                'kode_buku' => 'MTK-X-001',
                'mata_pelajaran' => 'Matematika',
                'kelas' => 'X',
                'penulis' => 'Dr. Ahmad Susanto',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2023,
                'stok' => 25,
                'deskripsi' => 'Buku paket matematika untuk kelas X semester 1 dan 2. Dilengkapi dengan contoh soal dan latihan.',
                'gambar' => null, // Akan menggunakan default image
            ],
            [
                'judul' => 'Bahasa Indonesia Kelas XI',
                'kode_buku' => 'BIN-XI-001',
                'mata_pelajaran' => 'Bahasa Indonesia',
                'kelas' => 'XI',
                'penulis' => 'Prof. Siti Nurhaliza',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2023,
                'stok' => 30,
                'deskripsi' => 'Buku paket Bahasa Indonesia untuk kelas XI. Materi lengkap sesuai kurikulum merdeka.',
                'gambar' => null,
            ],
            [
                'judul' => 'Fisika Kelas XII',
                'kode_buku' => 'FIS-XII-001',
                'mata_pelajaran' => 'Fisika',
                'kelas' => 'XII',
                'penulis' => 'Dr. Bambang Riyanto',
                'penerbit' => 'Yudhistira',
                'tahun_terbit' => 2023,
                'stok' => 20,
                'deskripsi' => 'Buku paket fisika untuk kelas XII. Dilengkapi dengan eksperimen dan praktikum.',
                'gambar' => null,
            ],
            [
                'judul' => 'Kimia Kelas XI',
                'kode_buku' => 'KIM-XI-001',
                'mata_pelajaran' => 'Kimia',
                'kelas' => 'XI',
                'penulis' => 'Dr. Rina Sari',
                'penerbit' => 'Tiga Serangkai',
                'tahun_terbit' => 2023,
                'stok' => 22,
                'deskripsi' => 'Buku paket kimia untuk kelas XI. Materi lengkap dengan tabel periodik.',
                'gambar' => null,
            ],
            [
                'judul' => 'Biologi Kelas X',
                'kode_buku' => 'BIO-X-001',
                'mata_pelajaran' => 'Biologi',
                'kelas' => 'X',
                'penulis' => 'Prof. Dewi Sartika',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2023,
                'stok' => 28,
                'deskripsi' => 'Buku paket biologi untuk kelas X. Dilengkapi dengan gambar ilustrasi yang menarik.',
                'gambar' => null,
            ],
            [
                'judul' => 'Sejarah Indonesia Kelas XI',
                'kode_buku' => 'SEJ-XI-001',
                'mata_pelajaran' => 'Sejarah',
                'kelas' => 'XI',
                'penulis' => 'Dr. Hasan Basri',
                'penerbit' => 'Balai Pustaka',
                'tahun_terbit' => 2023,
                'stok' => 15,
                'deskripsi' => 'Buku paket sejarah Indonesia untuk kelas XI. Materi lengkap dari masa prasejarah hingga modern.',
                'gambar' => null,
            ],
        ];

        foreach ($textBooks as $book) {
            TextBook::firstOrCreate(
                ['kode_buku' => $book['kode_buku']],
                $book
            );
        }
    }
}
