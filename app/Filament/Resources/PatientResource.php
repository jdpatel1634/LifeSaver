<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\BloodGroup;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Details')
                    ->schema([
                        TextInput::make('user.name')
                            ->label('Full Name')
                            ->required()
                            ->hiddenOn('edit')
                            ->maxLength(255),
                        TextInput::make('user.email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->hiddenOn('edit')
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->hiddenOn('edit')
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255),
                    ])->columns(2)
                    ->visible(fn (string $operation): bool => $operation === 'create' || $form->getRecord()->user === null),

                Forms\Components\Section::make('Patient Details')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('mobile_number')
                            ->tel()
                            ->maxLength(20),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ])
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->required()
                            ->native(false)
                            ->maxDate(now()),
                        TextInput::make('address')
                            ->columnSpan('full'),
                        TextInput::make('hospital_name')
                            ->required()
                            ->maxLength(255),
                      
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Patient Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->label('Mobile Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender'),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Date of Birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hospital_name')
                    ->label('Hospital Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_all_csv')
                    ->label('Export All CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $filename = 'patients_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
                        $filepath = storage_path('app/public/' . $filename);
    
                        $handle = fopen($filepath, 'w');
    
                        // CSV headers
                        fputcsv($handle, [
                            'Patient Name',
                            'Email',
                            'Mobile Number',
                            'Gender',
                            'Date of Birth',
                            'Hospital Name',
                            'Created At',
                        ]);
    
                        // Fetch all patients
                        $patients = \App\Models\Patient::with('user')->get();
    
                        foreach ($patients as $patient) {
                            fputcsv($handle, [
                                $patient->user?->name,
                                $patient->user?->email,
                                $patient->mobile_number,
                                ucfirst($patient->gender),
                                optional($patient->date_of_birth)->format('Y-m-d'),
                                $patient->hospital_name,
                                optional($patient->created_at)->format('Y-m-d H:i:s'),
                            ]);
                        }
    
                        fclose($handle);
    
                        // Return download response
                        return response()->download($filepath)->deleteFileAfterSend(true);
                    })
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            // 'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
