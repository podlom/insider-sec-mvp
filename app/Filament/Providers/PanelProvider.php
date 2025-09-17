<?php

namespace App\Filament\Providers;

use Filament\Panels\Panel;
use Filament\Panels\PanelServiceProvider;

class PanelProvider extends PanelServiceProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->path('admin')
            ->brandName('InsiderSec')
            ->breadcrumbs()
            ->sidebarCollapsible()
            ->middleware([
                'web',
                \App\Http\Middleware\SanctumOrSession::class,
            ])
            ->authMiddleware([
                \Illuminate\Auth\Middleware\Authenticate::class,
            ]);
    }
}
