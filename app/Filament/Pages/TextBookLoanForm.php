<?php

namespace App\Filament\Pages;

use App\Models\TextBook;
use App\Models\TextBookLoan;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\TextBookCatalog;
use App\Filament\Pages\MyTextBookLoans;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class TextBookLoanForm extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationLabel = 'Form Peminjaman Buku';
    protected static ?string $navigationGroup = 'Perpustakaan';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.text-book-loan-form';
    
    public ?TextBook $selectedBook = null;
    public ?int $bookId = null;
    
    // Form properties
    public ?string $mata_pelajaran = '';
    public ?string $guru_pengampu = '';
    public ?string $kelas_keperluan = '';
    public ?int $jumlah = 1;
    public $loan_date;
    public $return_date;
    public ?string $notes = '';
    
    public function mount(): void
    {
        if (Auth::user()->role !== 'member') {
            redirect()->to(Dashboard::getUrl());
        }
        
        // Get book ID from URL parameter
        $this->bookId = request()->get('book_id');
        
        if ($this->bookId) {
            $this->selectedBook = TextBook::find($this->bookId);
            
            if (!$this->selectedBook) {
                Notification::make()
                    ->title('Error')
                    ->body('Buku tidak ditemukan')
                    ->danger()
                    ->send();
                    
                $this->redirect(TextBookCatalog::getUrl());
            }
            
            if ($this->selectedBook->stok <= 0) {
                Notification::make()
                    ->title('Error')
                    ->body('Stok buku tidak tersedia')
                    ->danger()
                    ->send();
                    
                $this->redirect(TextBookCatalog::getUrl());
            }
            
            // Pre-fill form data
            $this->mata_pelajaran = $this->selectedBook->mata_pelajaran;
            $this->kelas_keperluan = $this->selectedBook->kelas;
        } else {
            $this->redirect(TextBookCatalog::getUrl());
        }
        
        $this->loan_date = now()->format('Y-m-d');
        $this->return_date = now()->addDays(7)->format('Y-m-d');
    }
    
    public function getTitle(): string
    {
        return 'Form Peminjaman Buku Cetak';
    }

    public function getHeading(): string
    {
        return 'Form Peminjaman Buku Cetak';
    }

    public function getSubheading(): ?string
    {
        return $this->selectedBook ? 'Lengkapi form berikut untuk mengajukan peminjaman buku: ' . $this->selectedBook->judul : null;
    }
    
    public function submitLoanRequest(): void
    {
        try {
            // Validasi dasar
            if (!$this->selectedBook) {
                Notification::make()
                    ->title('Error')
                    ->body('Tidak ada buku yang dipilih')
                    ->danger()
                    ->send();
                return;
            }

            // Validasi stok
            if ($this->selectedBook->stok <= 0) {
                Notification::make()
                    ->title('Error')
                    ->body('Stok buku tidak tersedia')
                    ->danger()
                    ->send();
                return;
            }

            // Validasi form
            $this->validate([
                'mata_pelajaran' => 'required|string|max:255',
                'guru_pengampu' => 'required|string|max:255',
                'kelas_keperluan' => 'required|string|max:255',
                'jumlah' => 'required|integer|min:1|max:' . $this->selectedBook->stok,
                'loan_date' => 'required|date|after_or_equal:today',
                'return_date' => 'required|date|after:loan_date',
                'notes' => 'nullable|string|max:1000',
            ], [
                'mata_pelajaran.required' => 'Mata pelajaran wajib diisi',
                'guru_pengampu.required' => 'Guru pengampu wajib diisi',
                'kelas_keperluan.required' => 'Kelas/keperluan wajib diisi',
                'jumlah.required' => 'Jumlah wajib diisi',
                'jumlah.min' => 'Jumlah minimal 1',
                'jumlah.max' => 'Jumlah melebihi stok yang tersedia',
                'loan_date.required' => 'Tanggal pinjam wajib diisi',
                'loan_date.after_or_equal' => 'Tanggal pinjam tidak boleh kurang dari hari ini',
                'return_date.required' => 'Tanggal kembali wajib diisi',
                'return_date.after' => 'Tanggal kembali harus setelah tanggal pinjam',
                'notes.max' => 'Catatan maksimal 1000 karakter',
            ]);

            // Cek apakah user sudah memiliki peminjaman aktif untuk buku yang sama
            $existingLoan = TextBookLoan::where('user_id', Auth::id())
                ->where('text_book_id', $this->selectedBook->id)
                ->whereIn('status', ['pending', 'active'])
                ->exists();

            if ($existingLoan) {
                Notification::make()
                    ->title('Error')
                    ->body('Anda sudah memiliki peminjaman aktif untuk buku ini')
                    ->danger()
                    ->send();
                return;
            }

            // Buat peminjaman
            TextBookLoan::create([
                'user_id' => Auth::id(),
                'text_book_id' => $this->selectedBook->id,
                'mata_pelajaran' => $this->mata_pelajaran,
                'guru_pengampu' => $this->guru_pengampu,
                'kelas_keperluan' => $this->kelas_keperluan,
                'jumlah' => $this->jumlah,
                'loan_date' => $this->loan_date,
                'return_date' => $this->return_date,
                'status' => 'pending',
                'notes' => $this->notes,
            ]);

            // Tampilkan notifikasi sukses
            Notification::make()
                ->title('Berhasil!')
                ->body('Permintaan peminjaman berhasil dibuat dan menunggu persetujuan admin')
                ->success()
                ->send();

            // Redirect ke halaman peminjaman saya
            $this->redirect(MyTextBookLoans::getUrl());

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors akan ditampilkan otomatis oleh Livewire
            throw $e;
        } catch (\Exception $e) {
            // Handle unexpected errors
            Notification::make()
                ->title('Error')
                ->body('Terjadi kesalahan saat memproses permintaan: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
    
    public function backToCatalog(): void
    {
        $this->redirect(TextBookCatalog::getUrl());
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hide from navigation since it's accessed via URL parameter
    }
}
