<x-filament-panels::page>

    {{-- 
        This Alpine.js component manages the state of the tabs.
        `activeTab` is initialized to 'personal_information', making the first tab active on page load.
    --}}
    <div x-data="{ activeTab: 'personal_information' }" class="space-y-6">

        {{-- The tab navigation container --}}
        <x-filament::tabs>
            {{-- Personal Information Tab --}}
            <x-filament::tabs.item
                icon="heroicon-o-user"
                x-on:click="activeTab = 'personal_information'"
                x-bind:active="activeTab === 'personal_information'"
            >
                Personal Information
            </x-filament::tabs.item>

            {{-- Change Password Tab --}}
            <x-filament::tabs.item
                icon="heroicon-o-key"
                x-on:click="activeTab = 'change_password'"
                x-bind:active="activeTab === 'change_password'"
            >
                Change Password
            </x-filament::tabs.item>
        </x-filament::tabs>

        {{-- Personal Information Form Panel --}}
        <div x-show="activeTab === 'personal_information'" role="tabpanel">
            <form wire:submit="savePersonalInformation">
                {{ $this->personalInformationForm }}

                <div class="mt-6">
                    <x-filament::button type="submit">
                        Save Changes
                    </x-filament::button>
                </div>
            </form>
        </div>

        {{-- Change Password Form Panel --}}
        <div x-show="activeTab === 'change_password'" role="tabpanel" style="display: none;">
            <form wire:submit="changePassword">
                {{ $this->passwordForm }}

                <div class="mt-6">
                    <x-filament::button type="submit">
                        Change Password
                    </x-filament::button>
                </div>
            </form>
        </div>

    </div>
    
    {{-- This is required for form actions and notifications to work correctly --}}
    <x-filament-actions::modals />

</x-filament-panels::page>
