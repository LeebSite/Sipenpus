<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';

    protected static string $view = 'filament.pages.dashboard';
    
    public function mount(): void
    {
        $user = Auth::user();
        
        if ($user->role === 'employee') {
            redirect()->to(EmployeeDashboard::getUrl());
        } elseif ($user->role === 'member') {
            redirect()->to(MemberDashboard::getUrl());
        }
        
        // Admin tetap di dashboard default
    }
}