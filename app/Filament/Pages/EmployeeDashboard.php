<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard Pegawai';
    
    protected static string $view = 'filament.pages.employee-dashboard';
    
    public function mount(): void
    {
        if (Auth::user()->role !== 'employee') {
            redirect()->to(Dashboard::getUrl());
        }
    }
}