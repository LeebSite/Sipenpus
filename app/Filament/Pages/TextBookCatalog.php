<?php

namespace App\Filament\Pages;

use App\Models\TextBook;
use App\Models\TextBookLoan;
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
    protected static ?string $navigationLabel = 'Peminjaman Buku Cetak';
    protected static ?string $navigationGroup = 'Perpustakaan';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.text-book-catalog';
    
    public ?string $search = '';
    public ?string $selectedSubject = '';
    public ?string $selectedClass = '';
    public Collection $textBooks;
    public ?TextBook $selectedBook = null;
    
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
        $this->textBooks = $this->getTextBooks();
        $this->loan_date = now()->format('Y-m-d');
        $this->return_date = now()->addDays(7)->format('Y-m-d');
    }
    
    public function getTextBooks(): Collection
    {
        return TextBook::query()
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
            ->where('stok', '>', 0)
            ->get();
    }
    
    public function updatedSearch(): void
    {
        $this->textBooks = $this->getTextBooks();
    }
    
    public function updatedSelectedSubject(): void
    {
        $this->textBooks = $this->getTextBooks();
    }
    
    public function updatedSelectedClass(): void
    {
        $this->textBooks = $this->getTextBooks();
    }
    
    public function selectBook(int $bookId): void
    {
        $this->selectedBook = TextBook::find($bookId);
        $this->mata_pelajaran = $this->selectedBook->mata_pelajaran;
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
        // Validasi
        $this->validate([
            'mata_pelajaran' => 'required|string|max:255',
            'guru_pengampu' => 'required|string|max:255',
            'kelas_keperluan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1|max:' . $this->selectedBook->stok,
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after:loan_date',
        ]);
        
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
            'status' => 'pending', // Default status adalah pending
            'notes' => $this->notes,
        ]);
        
        // Tampilkan notifikasi
        Notification::make()
            ->title('Permintaan peminjaman berhasil dibuat')
            ->success()
            ->send();
            
        // Reset form dan selection
        $this->selectedBook = null;
        $this->resetFormFields();
        $this->textBooks = $this->getTextBooks();
    }
    
    public function getSubjectsProperty(): array
    {
        return TextBook::distinct()
            ->pluck('mata_pelajaran')
            ->filter()
            ->toArray();
    }
    
    public function getClassesProperty(): array
    {
        return TextBook::distinct()
            ->pluck('kelas')
            ->filter()
            ->toArray();
    }
}