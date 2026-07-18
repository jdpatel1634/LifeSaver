<?php

namespace App\Filament\Resources\BloodRequestResource\Widgets;

use App\Models\BloodUnit;
use App\Models\ReservedUnit;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AvailableBloodUnits extends BaseWidget
{
    public ?Model $record = null;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Available Blood Units to Fulfill this Request';

    public function table(Table $table): Table
    {
        return $table
            // The query now uses $this->record, which is the correct BloodRequest model
            ->query(
                BloodUnit::query()
                    ->where('blood_group_id', $this->record->blood_group_id)
                    ->where('status', 'ready_for_issue')
                    ->whereDate('expiry_date', '>', Carbon::now())
            )
            ->columns([
                TextColumn::make('unique_bag_id')->label('Unique Bag ID'),
                TextColumn::make('component_type')->label('Component Type'),
                TextColumn::make('expiry_date')->label('Expiry Date')->date(),
                TextColumn::make('volume_ml')->label('Volume (ml)'),
            ])
            ->actions([
                TableAction::make('reserve')
                    ->label('Reserve')
                    ->icon('heroicon-o-bookmark')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (BloodUnit $record) { // This $record is the BloodUnit
                        DB::transaction(function () use ($record) {
                            // Use $this->record to get the owner BloodRequest
                            ReservedUnit::create([
                                'blood_unit_id' => $record->id,
                                'patient_id' => $this->record->patient_id,
                                'blood_request_id' => $this->record->id,
                                'reserved_by_user_id' => auth()->id(),
                                'reservation_date' => now(),
                                'expiration_date' => now()->addHours(24),
                                'status' => 'active',
                            ]);

                            $record->status = 'quarantined';
                            $record->save();

                            Notification::make()
                                ->title('Blood Unit Reserved Successfully')
                                ->success()
                                ->send();

                            $this->dispatch('refreshWidgets');
                        });
                    })
                    // This logic can be simplified or removed as the table query already handles this
                    // But it's good for disabling the button immediately
                    ->disabled(fn(BloodUnit $record) => $record->status !== 'ready_for_issue'),
            ]);
    }
}