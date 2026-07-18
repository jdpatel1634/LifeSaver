<x-filament-panels::page>
    <x-filament::card>
        {{-- <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
            {{ $this->getHeading() }}
        </h2> --}}

        <div class="mt-6 grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <div class="flex flex-col items-center justify-center p-6 bg-gray-100 rounded-lg dark:bg-gray-800">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Last Donation Date</p>
                <p class="text-xl font-bold text-primary-600 dark:text-primary-400 mt-2">{{ $this->getLastDonationDate() ?? 'N/A' }}</p>
            </div>

            <div class="flex flex-col items-center justify-center p-6 bg-gray-100 rounded-lg dark:bg-gray-800">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Next Eligible Donation Date</p>
                <p class="text-xl font-bold text-primary-600 dark:text-primary-400 mt-2">{{ $this->getNextEligibleDonationDate() }}</p>
            </div>

            <div class="flex flex-col items-center justify-center p-6 bg-gray-100 rounded-lg dark:bg-gray-800">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Donations</p>
                <p class="text-xl font-bold text-primary-600 dark:text-primary-400 mt-2">{{ $this->getTotalDonations() }}</p>
            </div>

            <div class="flex flex-col items-center justify-center p-6 bg-gray-100 rounded-lg dark:bg-gray-800">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Available Blood Units</p>
                <p class="text-xl font-bold text-primary-600 dark:text-primary-400 mt-2">{{ $this->getTotalAvailableBloodUnits() }}</p>
            </div>
        </div>
    </x-filament::card>

    <x-filament::card class="mt-6">
        <h3 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-2xl">Available Blood Units</h3>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Unique Bag ID</th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Blood Group</th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Collection Date</th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Expiry Date</th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Collected By (Donor)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                    @forelse($this->getAvailableBloodUnits() as $bloodUnit)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $bloodUnit->unique_bag_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $bloodUnit->bloodGroup->group_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $bloodUnit->collection_date->format('F j, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $bloodUnit->expiry_date->format('F j, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $bloodUnit->donor->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300" colspan="5">No blood units currently available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::card>
</x-filament-panels::page>
