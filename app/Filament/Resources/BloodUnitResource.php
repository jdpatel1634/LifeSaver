<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BloodUnitResource\Pages;
use App\Models\BloodUnit;
use App\Models\Camp;
use App\Models\Donor;
use App\Models\BloodGroup;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter; // Import SelectFilter
use App\Filament\Resources\BloodUnitResource\RelationManagers\SerologyTestsRelationManager; // Import SerologyTestsRelationManager

class BloodUnitResource extends Resource
{
    protected static ?string $model = BloodUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && $user->isAdmin() && !$user->isSuperAdmin();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('donor_id')
                    ->label('Donor')
                    ->options(Donor::where('status', 'active')->get()->mapWithKeys(function ($donor) {
                        return [$donor->id => $donor->first_name . ' ' . $donor->last_name . ' (' . $donor->user->email . ')'];
                    }))
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('blood_group_id', Donor::find($state)?->blood_group_id)),
                TextInput::make('unique_bag_id')
                    ->label('Unique Bag ID')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                DatePicker::make('collection_date')
                    ->label('Collection Date')
                    ->required()
                    ->default(now()),
                Select::make('blood_group_id')
                    ->label('Blood Group')
                    ->options(BloodGroup::all()->pluck('group_name', 'id'))
                    ->disabled()
                    ->required()
                    ->dehydrated(),
                Select::make('component_type')
                    ->label('Component Type')
                    ->options([
                        'whole_blood' => 'Whole Blood',
                        'plasma' => 'Plasma',
                        'platelet' => 'Platelet',
                        'red_blood_cells' => 'Red Blood Cells',
                    ])
                    ->required(),
                TextInput::make('volume_ml')
                    ->label('Volume')
                    ->numeric()
                    ->suffix('ml'),
                Select::make('collection_camp_id')
                    ->label('Collection Location')
                    ->options(Camp::all()->pluck('name', 'id')->prepend('Main Blood Bank', ''))
                    ->nullable(),
                TextInput::make('storage_location')
                    ->label('Storage Location')
                    ->placeholder('e.g., Fridge B, Shelf 1'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unique_bag_id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('donor.first_name')
                    ->label('Donor Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bloodGroup.group_name')
                    ->label('Blood Group')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('collection_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('expiry_date')
                    ->date()
                    ->sortable()
                    ->color(fn (string $state): string => match (true) {
                        now()->greaterThan($state) => 'danger',
                        now()->addDays(7)->greaterThan($state) => 'warning',
                        default => 'success',
                    }),
                TextColumn::make('component_type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'collected' => 'info',
                        'test_awaited' => 'warning',
                        'ready_for_issue' => 'success',
                        'issued' => 'primary',
                        'expired' => 'danger',
                        'discarded' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('serology_test_status')
                    ->label('Serology Test Status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'passed' => 'success',
                        'failed' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('collectionCamp.name')
                    ->label('Collection Camp')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'collected' => 'Collected',
                        'test_awaited' => 'Test Awaited',
                        'ready_for_issue' => 'Ready for Issue',
                        'issued' => 'Issued',
                        'expired' => 'Expired',
                        'discarded' => 'Discarded',
                        'quarantined' => 'Quarantined',
                    ])
                    ->label('Status')
                    ->attribute('status'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_csv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        return static::exportCsv();
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

        /**
     * Export Blood Units as CSV
     */
    public static function exportCsv()
    {
        $filename = 'blood_units_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'ID',
            'Unique Bag ID',
            'Donor Name',
            'Blood Group',
            'Collection Date',
            'Expiry Date',
            'Component Type',
            'Volume (ml)',
            'Status',
            'Serology Test Status',
            'Collection Camp',
            'Storage Location',
        ];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $bloodUnits = \App\Models\BloodUnit::with(['donor', 'bloodGroup', 'collectionCamp'])->get();

            foreach ($bloodUnits as $unit) {
                fputcsv($file, [
                    $unit->id,
                    $unit->unique_bag_id,
                    optional($unit->donor)->first_name . ' ' . optional($unit->donor)->last_name,
                    optional($unit->bloodGroup)->group_name ?? 'N/A',
                    optional($unit->collection_date)?->format('Y-m-d') ?? '-',
                    optional($unit->expiry_date)?->format('Y-m-d') ?? '-',
                    ucfirst(str_replace('_', ' ', $unit->component_type)) ?? 'N/A',
                    $unit->volume_ml ?? '0',
                    ucfirst(str_replace('_', ' ', $unit->status ?? 'N/A')),
                    ucfirst(str_replace('_', ' ', $unit->serology_test_status ?? 'N/A')),
                    optional($unit->collectionCamp)->name ?? 'Main Blood Bank',
                    $unit->storage_location ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public static function getRelations(): array
    {
        return [
            SerologyTestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBloodUnits::route('/'),
            'create' => Pages\CreateBloodUnit::route('/create'),
            'view' => Pages\ViewBloodUnit::route('/{record}'),
            'edit' => Pages\EditBloodUnit::route('/{record}/edit'),
        ];
    }
}
