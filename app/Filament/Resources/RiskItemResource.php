<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiskItemResource\Pages;
use App\Models\RiskItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RiskItemResource extends Resource
{
    protected static ?string $model = RiskItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    public static function form(Form $form): Form
    {
        return $form->schema([Forms\Components\TextInput::make('title')->required(), Forms\Components\Select::make('category')->options(['insider'=>'insider','availability'=>'availability','integrity'=>'integrity','confidentiality'=>'confidentiality','compliance'=>'compliance','supply_chain'=>'supply_chain'])->required(), Forms\Components\TextInput::make('likelihood')->numeric()->minValue(1)->maxValue(5)->required(), Forms\Components\TextInput::make('impact')->numeric()->minValue(1)->maxValue(5)->required(), Forms\Components\TextInput::make('rating')->numeric()->helperText('Auto = likelihood*impact'), Forms\Components\Textarea::make('treatment'), Forms\Components\Select::make('status')->options(['identified'=>'identified','accepted'=>'accepted','mitigating'=>'mitigating','transferred'=>'transferred','closed'=>'closed'])->required()])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('title')->searchable(), Tables\Columns\TextColumn::make('category')->badge(), Tables\Columns\TextColumn::make('rating'), Tables\Columns\TextColumn::make('status')->badge()])->defaultSort('created_at','desc');
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiskItems::route('/'),
            'create' => Pages\CreateRiskItem::route('/create'),
            'edit' => Pages\EditRiskItem::route('/{record}/edit'),
        ];
    }
}
