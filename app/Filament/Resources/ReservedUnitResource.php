<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservedUnitResource\Pages;
use App\Filament\Resources\ReservedUnitResource\RelationManagers;
use App\Models\ReservedUnit;
use App\Models\BloodUnit;
use App\Models\Patient;
use App\Models\User;
use App\Models\BloodRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;

class ReservedUnitResource extends Resource
{
    protected static ?string $model = ReservedUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && $user->isAdmin() && !$user->isSuperAdmin();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('blood_unit_id')
                    ->label('Blood Unit')
                    ->options(BloodUnit::where('status', 'ready_for_issue')->pluck('unique_bag_id', 'id'))
                    ->searchable()
                    ->required()
                    ->hiddenOn('edit'),
                Select::make('patient_id')
                    ->label('Patient')
                    ->options(Patient::all()->pluck('first_name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('blood_request_id')
                    ->label('Blood Request')
                    ->options(BloodRequest::where('status', 'approved')->pluck('id', 'id'))
                    ->searchable()
                    ->nullable(),
                Select::make('reserved_by_user_id')
                    ->label('Reserved By')
                    ->options(User::where('role', 'admin')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                DateTimePicker::make('reservation_date')
                    ->native(false)
                    ->required()
                    ->default(now()),
                DateTimePicker::make('expiration_date')
                    ->native(false)
                    ->required()
                    ->default(now()->addHours(24)),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'fulfilled' => 'Fulfilled',
                        'expired' => 'Expired',
                        'canceled' => 'Canceled',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bloodUnit.unique_bag_id')
                    ->label('Blood Unit ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.first_name')
                    ->label('Patient Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bloodRequest.description')
                    ->label('Request ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reservedBy.name')
                    ->label('Reserved By')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reservation_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('expiration_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'fulfilled' => 'info',
                        'expired' => 'danger',
                        'canceled' => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservedUnits::route('/'),
            'create' => Pages\CreateReservedUnit::route('/create'),
            'edit' => Pages\EditReservedUnit::route('/{record}/edit'),
        ];
    }
}
