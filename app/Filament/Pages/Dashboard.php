<?php

namespace App\Filament\Pages;

use Filament\Panel;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'fas-house';

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->pages([]);
    }
}
