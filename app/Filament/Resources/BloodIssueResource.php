<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BloodIssueResource\Pages;
use App\Filament\Resources\BloodIssueResource\RelationManagers;
use App\Models\BloodIssue;
use App\Models\BloodRequest;
use App\Models\BloodUnit;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class BloodIssueResource extends Resource
{
    protected static ?string $model = BloodIssue::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square';

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && $user->isAdmin() && !$user->isSuperAdmin();
    }

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('blood_request_id')
                    ->label('Blood Request')
                    ->options(BloodRequest::all()->pluck('description', 'id'))
                    ->searchable()
                    ->nullable(),
                Select::make('patient_id')
                    ->label('Patient')
                    ->options(Patient::all()->pluck('first_name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('blood_unit_id')
                    ->label('Blood Unit')
                    ->options(BloodUnit::where('status', 'ready_for_issue')->pluck('unique_bag_id', 'id'))
                    ->searchable()
                    ->required()
                    ->hiddenOn('edit'),
                DateTimePicker::make('issue_date')
                    ->native(false)
                    ->required(),
                Select::make('issued_by_user_id')
                    ->label('Issued By')
                    ->options(User::where('role', 'admin')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('cross_match_status')
                    ->options([
                        'pending' => 'Pending',
                        'passed' => 'Passed',
                        'failed' => 'Failed',
                        'not_performed' => 'Not Performed',
                    ])
                    ->required(),
                Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'waived' => 'Waived',
                    ])
                    ->required(),
                TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Textarea::make('adjustment_details')
                    ->nullable()
                    ->columnSpan('full'),
                TextInput::make('receipt_number')
                    ->unique(ignoreRecord: true)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bloodRequest.id')
                    ->label('Request ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.first_name')
                    ->label('Patient Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bloodUnit.unique_bag_id')
                    ->label('Blood Unit ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('issue_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('issuedBy.name')
                    ->label('Issued By')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cross_match_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'passed' => 'success',
                        'failed' => 'danger',
                        'not_performed' => 'warning',
                    })
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'waived' => 'info',
                    })
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->money('usd')
                    ->sortable(),
                TextColumn::make('receipt_number')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_csv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function () {
                        return static::exportCsv();
                    }),
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

    /**
     * Export Blood Issues as CSV
     */
    public static function exportCsv()
    {
        $filename = 'blood_issues_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'ID',
            'Patient Name',
            'Blood Unit ID',
            'Issue Date',
            'Issued By',
            'Cross Match Status',
            'Payment Status',
            'Total Amount',
            'Receipt Number',
        ];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $bloodIssues = \App\Models\BloodIssue::with(['patient', 'bloodUnit', 'issuedBy'])->get();

            foreach ($bloodIssues as $issue) {
                fputcsv($file, [
                    $issue->id,
                    optional($issue->patient)->first_name ?? 'N/A',
                    optional($issue->bloodUnit)->unique_bag_id ?? 'N/A',
                    optional($issue->issue_date)?->format('Y-m-d H:i:s') ?? 'N/A',
                    optional($issue->issuedBy)->name ?? 'N/A',
                    $issue->cross_match_status ?? 'N/A',
                    $issue->payment_status ?? 'N/A',
                    $issue->total_amount ?? '0',
                    $issue->receipt_number ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
            'index' => Pages\ListBloodIssues::route('/'),
            'create' => Pages\CreateBloodIssue::route('/create'),
            'edit' => Pages\EditBloodIssue::route('/{record}/edit'),
        ];
    }
}
