<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAsset extends ViewRecord
{
    protected static string $resource = AssetResource::class;

    // Optional page actions (e.g., show Edit button)
    protected function getHeaderActions(): array
    {
        return [
            // \Filament\Actions\EditAction::make(),
        ];
    }
}
