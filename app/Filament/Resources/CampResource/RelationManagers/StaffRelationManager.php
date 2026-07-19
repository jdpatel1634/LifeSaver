<?php

namespace App\Filament\Resources\CampResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StaffRelationManager extends RelationManager
{
    protected static string $relationship = 'staff';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('role_in_camp')
                    ->required()
                    ->maxLength(255)
                    ->label('Role in Camp'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Staff Member')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pivot.role_in_camp')
                    ->label('Role in Camp')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getForm()->schema([
                            Select::make('recordId')
                                ->options(\App\Models\User::pluck('name', 'id'))
                                ->label('Staff Member')
                                ->required()
                                ->searchable()
                                ->preload(),
                            TextInput::make('role_in_camp')
                                ->required()
                                ->maxLength(255)
                                ->label('Role in Camp'),
                        ])
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
