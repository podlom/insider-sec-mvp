<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SecurityEventResource\Pages;
use App\Models\SecurityEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SecurityEventResource extends Resource
{
    protected static ?string $model = SecurityEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function form(Form $form): Form
    {
        return $form->schema([Forms\Components\TextInput::make('source')->required(), Forms\Components\TextInput::make('event_type')->required(), Forms\Components\DateTimePicker::make('occurred_at')->required(), Forms\Components\KeyValue::make('payload')])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('source')->searchable(), Tables\Columns\TextColumn::make('event_type')->badge(), Tables\Columns\TextColumn::make('occurred_at')->dateTime()->sortable(), Tables\Columns\TextColumn::make('employee.email')->label('Employee'), Tables\Columns\TextColumn::make('asset.name')->label('Asset')])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSecurityEvents::route('/'),
            'create' => Pages\CreateSecurityEvent::route('/create'),
            'edit' => Pages\EditSecurityEvent::route('/{record}/edit'),
        ];
    }
}
