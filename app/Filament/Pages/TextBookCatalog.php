<?php

namespace App\Filament\Pages;

use App\Models\TextBook;
use App\Models\TextBookLoan;
use App\Filament\Pages\Dashboard;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class TextBookCatalog extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Katalog Buku Cetak';
    protected static ?string $navigationGroup = 'Perpustakaan';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.text-book-catalog';
    
    public ?string $search = '';
    public ?string $selectedSubject = '';
    public ?string $selectedClass = '';
    public Collection $textBooks;
    public ?TextBook $selectedBook = null;
    public int $perPage = 12;
    
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

        $this->textBooks = $this->getTextBooks();
        $this->loan_date = now()->format('Y-m-d');
        $this->return_date = now()->addDays(7)->format('Y-m-d');
    }

    public function getTitle(): string
    {
        return 'Katalog Buku Cetak';
    }

    public function getHeading(): string
    {
        return 'Katalog Buku Cetak';
    }

    public function getSubheading(): ?string
    {
        return 'Pilih buku cetak yang ingin Anda pinjam untuk keperluan pembelajaran';
    }
    
    public function getTextBooks(): Collection
    {
        return TextBook::query()
            ->select(['id', 'judul', 'kode_buku', 'penulis', 'mata_pelajaran', 'kelas', 'stok', 'gambar'])
            ->when($this->search, fn (Builder $query) => $query->where(function ($query) {
                $query->where('judul', 'like', "%{$this->search}%")
                    ->orWhere('penulis', 'like', "%{$this->search}%")
                    ->orWhere('kode_buku', 'like', "%{$this->search}%");
            }))
            ->when($this->selectedSubject, fn (Builder $query) =>
                $query->where('mata_pelajaran', $this->selectedSubject)
            )
            ->when($this->selectedClass, fn (Builder $query) =>
                $query->where('kelas', $this->selectedClass)
            )
            ->where('stok', '>=', 0) // Tampilkan semua buku, termasuk yang stok 0
            ->orderBy('judul')
            ->take($this->perPage)
            ->get();
    }
    
    public function updatedSearch(): void
    {
        $this->perPage = 12; // Reset pagination
        $this->textBooks = $this->getTextBooks();
    }

    public function updatedSelectedSubject(): void
    {
        $this->perPage = 12; // Reset pagination
        $this->textBooks = $this->getTextBooks();
    }

    public function updatedSelectedClass(): void
    {
        $this->perPage = 12; // Reset pagination
        $this->textBooks = $this->getTextBooks();
    }
    
    public function selectBook(int $bookId): void
    {
        $this->selectedBook = TextBook::find($bookId);
        $this->mata_pelajaran = $this->selectedBook->mata_pelajaran;
        $this->kelas_keperluan = $this->selectedBook->kelas;
    }
    
    public function cancelSelection(): void
    {
        $this->selectedBook = null;
        $this->resetFormFields();
    }
    
    public function resetFormFields(): void
    {
        $this->mata_pelajaran = '';
        $this->guru_pengampu = '';
        $this->kelas_keperluan = '';
        $this->jumlah = 1;
        $this->loan_date = now()->format('Y-m-d');
        $this->return_date = now()->addDays(7)->format('Y-m-d');
        $this->notes = '';
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

            // Reset form dan selection
            $this->selectedBook = null;
            $this->resetFormFields();
            $this->textBooks = $this->getTextBooks();

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
    
    public function getSubjectsProperty(): array
    {
        return TextBook::distinct()
            ->select('mata_pelajaran')
            ->whereNotNull('mata_pelajaran')
            ->where('mata_pelajaran', '!=', '')
            ->orderBy('mata_pelajaran')
            ->pluck('mata_pelajaran')
            ->toArray();
    }

    public function getClassesProperty(): array
    {
        return TextBook::distinct()
            ->select('kelas')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->orderBy('kelas')
            ->pluck('kelas')
            ->toArray();
    }

    public function loadMore(): void
    {
        $this->perPage += 12;
        $this->textBooks = $this->getTextBooks();
    }

    public function hasMoreBooks(): bool
    {
        $totalBooks = TextBook::query()
            ->when($this->search, fn (Builder $query) => $query->where(function ($query) {
                $query->where('judul', 'like', "%{$this->search}%")
                    ->orWhere('penulis', 'like', "%{$this->search}%")
                    ->orWhere('kode_buku', 'like', "%{$this->search}%");
            }))
            ->when($this->selectedSubject, fn (Builder $query) =>
                $query->where('mata_pelajaran', $this->selectedSubject)
            )
            ->when($this->selectedClass, fn (Builder $query) =>
                $query->where('kelas', $this->selectedClass)
            )
            ->where('stok', '>=', 0)
            ->count();

        return $totalBooks > $this->textBooks->count();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->selectedSubject = '';
        $this->selectedClass = '';
        $this->perPage = 12;
        $this->textBooks = $this->getTextBooks();
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role === 'member';
    }
}


