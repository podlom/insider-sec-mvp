<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ControlTestResource\Pages;
use App\Models\ControlTest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ControlTestResource extends Resource
{
    protected static ?string $model = ControlTest::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form->schema([Forms\Components\TextInput::make('control_id')->required(), Forms\Components\DatePicker::make('tested_on')->required(), Forms\Components\Toggle::make('passed')->default(false), Forms\Components\Textarea::make('notes')])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('control_id')->label('Control'), Tables\Columns\TextColumn::make('tested_on')->date(), Tables\Columns\IconColumn::make('passed')->boolean()])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListControlTests::route('/'),
            'create' => Pages\CreateControlTest::route('/create'),
            'edit' => Pages\EditControlTest::route('/{record}/edit'),
        ];
    }
}
