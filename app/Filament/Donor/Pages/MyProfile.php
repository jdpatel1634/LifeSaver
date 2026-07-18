<?php

namespace App\Filament\Donor\Pages;

use App\Models\City;
use App\Models\Donor;
use App\Models\State;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static string $view = 'filament.donor.pages.my-profile';
    protected static ?string $title = 'My Profile';
    protected static ?string $slug = 'my-profile';

    public ?array $personalInformationData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->personalInformationForm->fill(
            auth()->user()->donor->attributesToArray()
        );

        $this->passwordForm->fill();
    }

    public function personalInformationForm(Form $form):
    Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->description('Manage and update your personal details.')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('last_name')
                            ->required()
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('email') // From User model
                            ->label('Email Address')
                            ->default(auth()->user()->email)
                            ->email()
                            ->disabled()
                            ->dehydrated(false),
                        DatePicker::make('date_of_birth')
                            ->required()
                            ->disabled()
                            ->dehydrated(false),
                        Select::make('blood_group_id')
                            ->relationship('bloodGroup', 'group_name')
                            ->required()
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('enrollment_number')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('mobile_number')
                            ->tel()
                            ->required(),
                        Textarea::make('address')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('state_id')
                            ->options(State::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                        Select::make('city_id')
                            ->options(fn (callable $get): array => City::where('state_id', $get('state_id'))
                                ->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->required()
                            ->hidden(fn (callable $get): bool => ! $get('state_id')),
                    ])->columns(2)
            ])
            ->statePath('personalInformationData')
            ->model(auth()->user()->donor);
    }

    public function passwordForm(Form $form):
    Form
    {
        return $form
            ->schema([
                Section::make('Change Password')
                    ->description('Update your password for enhanced security.')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->required()
                            ->currentPassword(),
                        TextInput::make('new_password')
                            ->label('New Password')
                            ->password()
                            ->required()
                            ->rule(Password::default()->min(8))
                            ->confirmed(),
                        TextInput::make('new_password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->required(),
                    ])
            ])
            ->statePath('passwordData');
    }

    public function savePersonalInformation(): void
    {
        $donor = auth()->user()->donor;
        $data = $this->personalInformationForm->getState();

        $donor->update($data);

        Notification::make()
            ->title('Personal information updated successfully!')
            ->success()
            ->send();
    }

    public function changePassword(): void
    {
        $data = $this->passwordForm->getState();
        $user = auth()->user();

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);
        
        if (request()->hasSession()) {
            request()->session()->put([
                'password_hash_' . auth()->getDefaultDriver() => $user->getAuthPassword(),
            ]);
        }

        $this->passwordForm->fill(); 

        Notification::make()
            ->title('Password changed successfully!')
            ->success()
            ->send();
    }

    protected function getForms(): array
    {
        return [
            'personalInformationForm',
            'passwordForm',
        ];
    }
}
