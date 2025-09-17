<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ControlResource\Pages;
use App\Models\Control;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ControlResource extends Resource
{
    protected static ?string $model = Control::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    public static function form(Form $form): Form
    {
        return $form->schema([Forms\Components\TextInput::make('name')->required(), Forms\Components\Select::make('family')->options(['access'=>'access','audit'=>'audit','config'=>'config','ir'=>'ir','protect'=>'protect','detect'=>'detect','recover'=>'recover'])->required(), Forms\Components\Textarea::make('objective'), Forms\Components\Toggle::make('active')->default(true)])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('name')->searchable(), Tables\Columns\TextColumn::make('family')->badge(), Tables\Columns\IconColumn::make('active')->boolean()])->defaultSort('created_at','desc');
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListControls::route('/'),
            'create' => Pages\CreateControl::route('/create'),
            'edit' => Pages\EditControl::route('/{record}/edit'),
        ];
    }
}
