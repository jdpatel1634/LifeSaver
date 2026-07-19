<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampResource\Pages;
use App\Filament\Resources\CampResource\RelationManagers;
use App\Models\Camp;
use App\Models\City;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CampResource extends Resource
{
    protected static ?string $model = Camp::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && $user->isSuperAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('camp_date')
                    ->required(),
                TimePicker::make('start_time'),
                TimePicker::make('end_time'),
                Textarea::make('address')
                    ->maxLength(65535)
                    ->columnSpan('full'),
                Select::make('state_id')
                    ->relationship('state', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('city_id', null)),
                Select::make('city_id')
                    ->options(fn (Forms\Get $get): array => City::query()
                        ->where('state_id', $get('state_id'))
                        ->pluck('name', 'id')
                        ->toArray())
                    ->required(),
                TextInput::make('organizer')
                    ->maxLength(255),
                Textarea::make('facilities_available')
                    ->maxLength(65535)
                    ->columnSpan('full'),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpan('full'),
                Select::make('status')
                    ->options([
                        'upcoming' => 'Upcoming',
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('upcoming'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('camp_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('state.name')
                    ->label('State')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city.name')
                    ->label('City')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StaffRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCamps::route('/'),
            'create' => Pages\CreateCamp::route('/create'),
            'edit' => Pages\EditCamp::route('/{record}/edit'),
        ];
    }
}
