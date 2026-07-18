<?php

namespace App\Filament\Resources\BloodRequestResource\Widgets;

use App\Models\BloodIssue;
use App\Models\BloodUnit;
use App\Models\ReservedUnit;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FulfilledBloodUnits extends BaseWidget
{
    public ?Model $record = null; // This will be the BloodRequest

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Reserved / Issued Units for this Request')
            // This query is key: it finds units via reservations OR direct issues linked to this request
            ->query(
                BloodUnit::query()
                    ->whereHas('reservedUnit', fn($q) => $q->where('blood_request_id', $this->record->id))
                    ->orWhereHas('bloodIssue', fn($q) => $q->where('blood_request_id', $this->record->id))
            )
            ->columns([
                TextColumn::make('unique_bag_id')->label('Unique Bag ID'),
                TextColumn::make('status')
                    ->label('Current Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'quarantined' => 'warning',
                        'issued' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('reservedUnit.expiration_date')
                    ->label('Reservation Expires')
                    ->dateTime()
                    ->visible(fn(?BloodUnit $record) => $record?->status === 'quarantined'),
                TextColumn::make('bloodIssue.issue_date')
                    ->label('Date Issued')
                    ->dateTime()
                    ->visible(fn(?BloodUnit $record) => $record?->status === 'issued'),
            ])
            ->actions([
                TableAction::make('issue_blood')
                    ->label('Issue Blood')
                    ->icon('heroicon-o-hand-raised')
                    ->color('success')
                    // This action is ONLY visible for units that are reserved for this request
                    ->visible(fn(?BloodUnit $record) => $record?->status === 'quarantined')
                    ->action(function (array $data, BloodUnit $record) { // $record is the BloodUnit
                        // Check for cross-match failure
                        if ($data['cross_match_status'] === 'failed') {
                            Notification::make()->title('Cross-match Failed')->danger()->send();
                            return;
                        }

                        DB::transaction(function () use ($data, $record) {
                            $bloodRequest = $this->record;
                            $reservedUnit = $record->reservedUnit;

                            // 1. Create BloodIssue record
                            BloodIssue::create([
                                'blood_request_id' => $bloodRequest->id,
                                'patient_id' => $bloodRequest->patient_id,
                                'blood_unit_id' => $record->id,
                                'issue_date' => now(),
                                'issued_by_user_id' => auth()->id(),
                                'cross_match_status' => $data['cross_match_status'],
                                'payment_status' => $data['payment_status'],
                                'total_amount' => $data['total_amount'],
                                'adjustment_details' => $data['adjustment_details'],
                            ]);

                            // 2. Update BloodUnit status
                            $record->status = 'issued';
                            $record->save();

                            // 3. Update ReservedUnit status
                            if ($reservedUnit) {
                                $reservedUnit->status = 'fulfilled';
                                $reservedUnit->save();
                            }

                            // 4. Update BloodRequest status
                            $bloodRequest->status = 'fulfilled';
                            $bloodRequest->save();

                            Notification::make()->title('Blood Issued Successfully')->success()->send();
                        });

                        // Emit event to refresh both widgets
                        $this->dispatch('refreshWidgets');
                    })
                    ->form([
                        Select::make('cross_match_status')
                            ->options(['passed' => 'Passed', 'failed' => 'Failed', 'not_performed' => 'Not Performed'])
                            ->required(),
                        Select::make('payment_status')
                            ->options(['pending' => 'Pending', 'paid' => 'Paid', 'waived' => 'Waived'])
                            ->required(),
                        TextInput::make('total_amount')->numeric()->required()->prefix('$'),
                        Textarea::make('adjustment_details'),
                    ]),
            ]);
    }
}