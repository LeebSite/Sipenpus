<?php

namespace App\Filament\Pages;

use App\Models\TextBook;
use App\Models\TextBookLoan;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\TextBookLoanForm;
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
    public int $perPage = 12;
    
    public function mount(): void
    {
        if (Auth::user()->role !== 'member') {
            redirect()->to(Dashboard::getUrl());
        }

        $this->textBooks = $this->getTextBooks();
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
    
    public function goToLoanForm(int $bookId): void
    {
        $book = TextBook::find($bookId);

        if (!$book) {
            Notification::make()
                ->title('Error')
                ->body('Buku tidak ditemukan')
                ->danger()
                ->send();
            return;
        }

        if ($book->stok <= 0) {
            Notification::make()
                ->title('Error')
                ->body('Stok buku tidak tersedia')
                ->danger()
                ->send();
            return;
        }

        // Redirect ke halaman form peminjaman dengan parameter book_id
        $this->redirect(TextBookLoanForm::getUrl() . '?book_id=' . $bookId);
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


