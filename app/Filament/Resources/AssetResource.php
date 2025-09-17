<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Inventory';

    protected static ?string $navigationLabel = 'Assets';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('serial_number')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('status')
                    ->options([
                        'in_stock' => 'In stock',
                        'assigned' => 'Assigned',
                        'retired' => 'Retired',
                        'lost' => 'Lost',
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('assigned_to_id')
                    ->relationship('assignedTo', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->label('Assignee')
                    ->hint('Optional'),
            ])->columns(2),

            Forms\Components\Section::make('Acquisition')->schema([
                Forms\Components\DatePicker::make('purchased_at')
                    ->native(false),
                Forms\Components\TextInput::make('cost')
                    ->numeric()
                    ->prefix('$')
                    ->rule('numeric'),
            ])->columns(2),

            Forms\Components\Textarea::make('notes')
                ->columnSpanFull()
                ->rows(4),
        ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->label('Serial')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label('Assignee')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'in_stock',
                        'warning' => 'assigned',
                        'gray' => 'retired',
                        'danger' => 'lost',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchased_at')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money('usd', locale: 'en_US')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'in_stock' => 'In stock',
                        'assigned' => 'Assigned',
                        'retired' => 'Retired',
                        'lost' => 'Lost',
                    ]),
                Tables\Filters\TernaryFilter::make('assigned_to_id')
                    ->label('Assigned?')
                    ->nullable()
                    ->boolean()
                    ->trueLabel('Assigned')
                    ->falseLabel('Unassigned'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers go here if you add any in the future.
        ];
    }

    /** Include soft-deleted rows when "Trashed" filter is used */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'view' => Pages\ViewAsset::route('/{record}'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
