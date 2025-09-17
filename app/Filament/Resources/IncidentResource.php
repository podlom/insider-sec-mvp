<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncidentResource\Pages;
use App\Models\Incident;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

    public static function form(Form $form): Form
    {
        return $form->schema([Forms\Components\TextInput::make('title')->required(), Forms\Components\Select::make('severity')->options(['low' => 'low', 'medium' => 'medium', 'high' => 'high', 'critical' => 'critical'])->required(), Forms\Components\Select::make('status')->options(['new' => 'new', 'triage' => 'triage', 'investigating' => 'investigating', 'contained' => 'contained', 'resolved' => 'resolved', 'false_positive' => 'false_positive'])->required(), Forms\Components\TextInput::make('estimated_loss')->numeric(), Forms\Components\DateTimePicker::make('detected_at')->required(), Forms\Components\DateTimePicker::make('contained_at'), Forms\Components\DateTimePicker::make('resolved_at'), Forms\Components\KeyValue::make('context')])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('title')->searchable(), Tables\Columns\TextColumn::make('severity')->badge(), Tables\Columns\TextColumn::make('status')->badge(), Tables\Columns\TextColumn::make('detected_at')->dateTime(), Tables\Columns\TextColumn::make('estimated_loss')->money('usd', true)])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncidents::route('/'),
            'create' => Pages\CreateIncident::route('/create'),
            'edit' => Pages\EditIncident::route('/{record}/edit'),
        ];
    }
}
