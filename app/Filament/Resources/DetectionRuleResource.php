<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetectionRuleResource\Pages;
use App\Models\DetectionRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DetectionRuleResource extends Resource
{
    protected static ?string $model = DetectionRule::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';

    public static function form(Form $form): Form
    {
        return $form->schema([Forms\Components\TextInput::make('name')->required(), Forms\Components\Textarea::make('description'), Forms\Components\Toggle::make('enabled')->default(true), Forms\Components\Select::make('severity')->options(['low' => 'low', 'medium' => 'medium', 'high' => 'high', 'critical' => 'critical'])->required()->default('medium'), Forms\Components\TextInput::make('weight')->numeric()->required()->default(10), Forms\Components\Textarea::make('conditions')->helperText('JSON: {logic:"all|any", rules:[{field,op,value}]}')->required()])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('name')->searchable(), Tables\Columns\IconColumn::make('enabled')->boolean(), Tables\Columns\TextColumn::make('severity')->badge(), Tables\Columns\TextColumn::make('weight')])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDetectionRules::route('/'),
            'create' => Pages\CreateDetectionRule::route('/create'),
            'edit' => Pages\EditDetectionRule::route('/{record}/edit'),
        ];
    }
}
