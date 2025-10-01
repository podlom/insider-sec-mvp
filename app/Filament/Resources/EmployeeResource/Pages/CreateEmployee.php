<?php

declare(strict_types=1);

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    /**
     * If your employees table uses a string UUID primary key,
     * set it here on create (or do this in the model boot()).
     */
    /*    protected function mutateFormDataBeforeCreate(array $data): array
        {
            $data['id'] = $data['id'] ?? (string) Str::uuid();
            return $data;
        } */
}
