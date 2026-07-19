@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <!-- Hero Section -->
        <div class="relative bg-red-600 text-white py-20">
            <div class="container mx-auto text-center">
                <h1 class="text-5xl font-bold mb-4">Give Blood, Save Lives</h1>
                <p class="text-xl mb-8">Your donation can make a difference. Find nearby blood donation camps or request blood units in need.</p>
                <div class="space-x-4">
                    <a href="{{ route('donor.register.form') }}" class="bg-white text-red-600 px-6 py-3 rounded-full text-lg font-semibold hover:bg-gray-200">Become a Donor</a>
                    <a href="{{ route('blood.request.form') }}" class="bg-red-700 px-6 py-3 rounded-full text-lg font-semibold hover:bg-red-800">Request Blood</a>
                </div>
            </div>
        </div>

        <!-- Available Blood Units Section -->
        <div class="py-16 bg-white">
            <div class="container mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Currently Available Blood Units</h2>
                <p class="text-6xl font-extrabold text-red-600">{{ $availableUnitsCount }}</p>
                <p class="text-xl text-gray-600 mt-4">units ready for immediate transfusion across all blood groups.</p>
                <a href="{{ route('blood.search') }}" class="mt-8 inline-block bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-700">Find Blood Now</a>
            </div>
        </div>

        <!-- Latest Camps Section -->
        <div class="py-16 bg-gray-100">
            <div class="container mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 text-center mb-10">Upcoming Blood Donation Camps</h2>
                @if($latestCamps->isEmpty())
                    <p class="text-center text-gray-600 text-lg">No upcoming camps found. Please check back later!</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($latestCamps as $camp)
                            <div class="bg-white rounded-lg shadow-lg p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $camp->name }}</h3>
                                <p class="text-gray-600 mb-1"><i class="fas fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::parse($camp->camp_date)->format('M d, Y') }}</p>
                                <p class="text-gray-600 mb-1"><i class="fas fa-clock mr-2"></i>{{ \Carbon\Carbon::parse($camp->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($camp->end_time)->format('h:i A') }}</p>
                                <p class="text-gray-600 mb-4"><i class="fas fa-map-marker-alt mr-2"></i>{{ $camp->address }}, {{ $camp->city->name ?? '' }}, {{ $camp->state->name ?? '' }}</p>
                                <p class="text-gray-700 text-sm mb-4">{{ Str::limit($camp->description, 100) }}</p>
                                <a href="#" class="text-red-600 font-semibold hover:text-red-700">View Details <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="bg-red-600 text-white py-16 text-center">
            <div class="container mx-auto">
                <h2 class="text-3xl font-bold mb-4">Join Our Mission to Save Lives</h2>
                <p class="text-lg mb-8">Every donation counts. Be a hero today!</p>
                <a href="{{ route('donor.register.form') }}" class="bg-white text-red-600 px-8 py-3 rounded-full text-lg font-semibold hover:bg-gray-200">Register as Donor</a>
            </div>
        </div>
    </div>
@endsection
