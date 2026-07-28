<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BloodRequestResource\Pages;
use App\Filament\Resources\BloodRequestResource\RelationManagers;
use App\Factories\BloodCompatibilityFactory;
use App\Models\BloodGroup;
use App\Models\BloodRequest;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Models\BloodUnit;
use App\Models\ReservedUnit;
use App\Models\BloodIssue;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Actions\Action;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\Action as TableAction;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\HtmlString;

class BloodRequestResource extends Resource
{
    protected static ?string $model = BloodRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRecord(?string $id = null): ?\Illuminate\Database\Eloquent\Model
    {
        return static::getModel()::find($id);
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && $user->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Blood Request Details')
                    ->description('Details of the patient\'s blood request.')
                    ->schema([
                        Select::make('patient_id')
                            ->label('Patient')
                            ->options(Patient::all()->pluck('first_name', 'id'))
                            ->searchable()
                            ->required()
                            ->columnSpan(1),
                        Select::make('blood_group_id')
                            ->label('Blood Group')
                            ->options(BloodGroup::all()->pluck('group_name', 'id'))
                            ->searchable()
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('units_requested')
                            ->numeric()
                            ->suffix('units')
                            ->required()
                            ->columnSpan(1),
                        Select::make('urgency_level')
                            ->options([
                                'routine' => 'Routine',
                                'urgent' => 'Urgent',
                                'emergency' => 'Emergency',
                            ])
                            ->required()
                            ->columnSpan(1),
                        DatePicker::make('request_date')
                            ->native(false)
                            ->required()
                            ->columnSpan(1),
                        DatePicker::make('required_by_date')
                            ->native(false)
                            ->nullable()
                            ->columnSpan(1),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'fulfilled' => 'Fulfilled',
                                'rejected' => 'Rejected',
                                'canceled' => 'Canceled',
                            ])
                            ->required()
                            ->columnSpan(1),
                        Textarea::make('description')
                            ->nullable()
                            ->columnSpan('full'),
                        Textarea::make('rejection_reason')
                            ->nullable()
                            ->columnSpan('full'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.first_name')
                    ->label('Patient Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bloodGroup.group_name')
                    ->label('Blood Group')
                    ->searchable()
                    ->sortable(),
                 TextColumn::make('compatible_donor_groups')
    ->label('Compatible Donors')
    ->getStateUsing(function (BloodRequest $record): string {
        $bloodGroup = $record->bloodGroup?->group_name;

        if (! $bloodGroup) {
            return 'Not available';
        }

        $compatibleGroups = BloodCompatibilityFactory::compatibleDonorGroups($bloodGroup);

        return empty($compatibleGroups)
            ? 'No match found'
            : implode(', ', $compatibleGroups);
    })
    ->wrap(),
                
                TextColumn::make('units_requested')
                    ->label('Units')
                    ->sortable(),
                TextColumn::make('urgency_level')
                    ->label('Urgency')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'routine' => 'gray',
                        'urgent' => 'warning',
                        'emergency' => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('request_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('required_by_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'fulfilled' => 'info',
                        'rejected' => 'danger',
                        'canceled' => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'fulfilled' => 'Fulfilled',
                        'rejected' => 'Rejected',
                        'canceled' => 'Canceled',
                    ])
                    ->label('Filter by Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->action(function (BloodRequest $record) {
                        $record->status = 'approved';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->hidden(fn (BloodRequest $record): bool => $record->status !== 'pending'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportCsv')
                    ->label('Export as CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function () {
                        $filename = 'blood_requests_' . now()->format('Y_m_d_His') . '.csv';
    
                        $bloodRequests = \App\Models\BloodRequest::with(['patient', 'bloodGroup'])->get();
    
                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => "attachment; filename=\"$filename\"",
                        ];
    
                        $columns = [
                            'Patient Name',
                            'Blood Group',
                            'Units Requested',
                            'Urgency Level',
                            'Status',
                            'Request Date',
                            'Required By Date',
                            'Description',
                        ];
    
                        $callback = function () use ($bloodRequests, $columns) {
                            $file = fopen('php://output', 'w');
                            fputcsv($file, $columns);
    
                            foreach ($bloodRequests as $request) {
                                fputcsv($file, [
                                    $request->patient?->first_name,
                                    $request->bloodGroup?->group_name,
                                    $request->units_requested,
                                    ucfirst($request->urgency_level),
                                    ucfirst($request->status),
                                    optional($request->request_date)->format('Y-m-d'),
                                    optional($request->required_by_date)->format('Y-m-d'),
                                    $request->description,
                                ]);
                            }
    
                            fclose($file);
                        };
    
                        return Response::stream($callback, 200, $headers);
                    }),
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
            // RelationManagers\AvailableBloodUnitsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBloodRequests::route('/'),
            'create' => Pages\CreateBloodRequest::route('/create'),
            'edit' => Pages\EditBloodRequest::route('/{record}/edit'),
        ];
    }
}
