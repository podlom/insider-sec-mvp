<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;
    protected static ?string $navigationIcon = 'heroicon-o-server';
    public static function form(Form $form): Form
    {
        return $form->schema([Forms\Components\TextInput::make('name')->required(), Forms\Components\Select::make('type')->options(['db'=>'db','repo'=>'repo','saas'=>'saas','file_share'=>'file_share','endpoint'=>'endpoint'])->required(), Forms\Components\TextInput::make('sensitivity')->numeric()->minValue(1)->maxValue(5)->default(3), Forms\Components\TextInput::make('owner_department')])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('name')->searchable(), Tables\Columns\TextColumn::make('type')->badge(), Tables\Columns\TextColumn::make('sensitivity'), Tables\Columns\TextColumn::make('owner_department')->label('Owner')])->defaultSort('created_at','desc');
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
