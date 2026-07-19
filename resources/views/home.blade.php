<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Life Saver - Blood Bank Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #DC2626 0%, #991B1B 100%);
        }
        
        .blood-drop {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(220, 38, 38, 0.2);
        }
        
        .blood-type-badge {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span class="text-2xl font-bold text-gray-800">Life<span class="text-red-600">Saver</span></span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-red-600 font-medium transition">Home</a>
                    <a href="/request-blood" class="text-gray-700 hover:text-red-600 font-medium transition">Request Blood</a>
                    <a href="/register/donor" class="text-gray-700 hover:text-red-600 font-medium transition">Register as Donor</a>
                </div>
                <div class="flex items-center space-x-3">
                    @if(auth()->check())
                        @if(auth()->user()->isAdmin())
                            <a href="/admin" class="px-5 py-2 text-red-600 font-semibold hover:bg-red-50 rounded-lg transition">Admin Dashboard</a>
                        @elseif(auth()->user()->isDonor())
                            <a href="/donor/dashboard" class="px-5 py-2 text-red-600 font-semibold hover:bg-red-50 rounded-lg transition">Donor Dashboard</a>
                        @elseif(auth()->user()->isPatient())
                            <a href="/patient" class="px-5 py-2 text-red-600 font-semibold hover:bg-red-50 rounded-lg transition">Patient Dashboard</a>
                        @endif
                    @else
                        <a href="/login" class="px-5 py-2 text-red-600 font-semibold hover:bg-red-50 rounded-lg transition">Login</a>
                        <a href="/request-blood" class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition shadow-md">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg hero-pattern text-white py-20">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium">
                        🩸 Saving Lives Together
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                        Every Drop <br/>
                        <span class="text-red-200">Counts</span>
                    </h1>
                    <p class="text-xl text-red-100">
                        Join our mission to save lives through blood donation. Your single donation can save up to three lives.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('donor.register.form') }}" class="px-8 py-4 bg-red-800 text-white font-bold rounded-lg hover:bg-red-900 transition border-2 border-white/20">
                            Become a Donor
                        </a>
                    </div>
                    <div class="flex items-center space-x-6 pt-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Safe & Secure</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>24/7 Available</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-sm rounded-3xl transform rotate-6"></div>
                        <div class="relative bg-white/20 backdrop-blur-md rounded-3xl p-8 space-y-4">
                            <div class="grid grid-cols-4 gap-3">
                                <div class="blood-type-badge text-center py-4 rounded-xl">
                                    <div class="text-2xl font-bold text-red-600">A+</div>
                                </div>
                                <div class="blood-type-badge text-center py-4 rounded-xl">
                                    <div class="text-2xl font-bold text-red-600">B+</div>
                                </div>
                                <div class="blood-type-badge text-center py-4 rounded-xl">
                                    <div class="text-2xl font-bold text-red-600">O+</div>
                                </div>
                                <div class="blood-type-badge text-center py-4 rounded-xl">
                                    <div class="text-2xl font-bold text-red-600">AB+</div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-6 space-y-3">
                                <h3 class="text-gray-800 font-bold text-lg">Quick Blood Search</h3>
                                <form action="{{ route('blood.handleSearch') }}" method="POST" class="space-y-2">
                                    @csrf
                                    <select name="blood_group_id" class="w-full px-4 py-3 text-gray-800 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                                        <option value="">Select Blood Type</option>
                                        @foreach($bloodGroups as $group)
                                            <option value="{{ $group->id }}" {{ (isset($searchedBloodGroup) && $searchedBloodGroup->id == $group->id) ? 'selected' : '' }}>{{ $group->group_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                        Search Available Units
                                    </button>
                                </form>
                                @if(isset($searchedBloodGroup))
                                    <div class="mt-4 p-4 rounded-lg text-center {{ $availableUnitsCount > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        @if($availableUnitsCount > 0)
                                            <p class="font-semibold text-lg">{{ $availableUnitsCount }} units of {{ $searchedBloodGroup->group_name ?? 'selected blood group' }} available!</p>
                                            <p class="text-sm">Contact us for immediate transfusion.</p>
                                        @else
                                            <p class="font-semibold text-lg">No units of {{ $searchedBloodGroup->group_name ?? 'selected blood group' }} available.</p>
                                            <p class="text-sm">Consider submitting a blood request.</p>
                                            <a href="{{ route('blood.request.form') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800 text-sm font-semibold">Submit Request</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center space-y-2 card-hover bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100">
                    <svg class="w-12 h-12 mx-auto text-red-600 blood-drop" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <h3 class="text-4xl font-bold text-red-600">{{ $availableUnitsCount }}</h3>
                    <p class="text-gray-600 font-medium">Available Units</p>
                </div>
                <div class="text-center space-y-2 card-hover bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100">
                    <svg class="w-12 h-12 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-4xl font-bold text-red-600">{{ $latestCamps->count() }}</h3>
                    <p class="text-gray-600 font-medium">Upcoming Camps</p>
                </div>
                <div class="text-center space-y-2 card-hover bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100">
                    <svg class="w-12 h-12 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="text-4xl font-bold text-red-600">50+</h3>
                    <p class="text-gray-600 font-medium">Blood Banks</p>
                </div>
                <div class="text-center space-y-2 card-hover bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100">
                    <svg class="w-12 h-12 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-4xl font-bold text-red-600">15+</h3>
                    <p class="text-gray-600 font-medium">Camps This Month</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Types -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Types of Donation</h2>
                <p class="text-gray-600 text-lg">Choose the donation type that suits you best</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition card-hover border border-gray-100">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Whole Blood</h3>
                    <p class="text-gray-600 mb-4">The most common donation. Takes about 10-15 minutes and can save up to 3 lives.</p>
                    <ul class="space-y-2 text-sm text-gray-600 mb-6">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Duration: 10-15 minutes</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Donate every 8 weeks</span>
                        </li>
                    </ul>
                    <a href="#" class="text-red-600 font-semibold hover:text-red-700 flex items-center space-x-2">
                        <span>Learn More</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition card-hover border border-gray-100">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Platelet</h3>
                    <p class="text-gray-600 mb-4">Critical for cancer patients and trauma victims. Collected through apheresis process.</p>
                    <ul class="space-y-2 text-sm text-gray-600 mb-6">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Duration: 2-3 hours</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Donate every 2 weeks</span>
                        </li>
                    </ul>
                    <a href="#" class="text-red-600 font-semibold hover:text-red-700 flex items-center space-x-2">
                        <span>Learn More</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition card-hover border border-gray-100">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 00-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Plasma</h3>
                    <p class="text-gray-600 mb-4">Used for burn victims, trauma patients, and those with clotting disorders.</p>
                    <ul class="space-y-2 text-sm text-gray-600 mb-6">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Duration: 1-2 hours</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Donate every 4 weeks</span>
                        </li>
                    </ul>
                    <a href="#" class="text-red-600 font-semibold hover:text-red-700 flex items-center space-x-2">
                        <span>Learn More</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Eligibility -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Am I Eligible to Donate?</h2>
                    <p class="text-gray-600 text-lg mb-8">Most healthy adults can donate blood. Here are the basic requirements:</p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Age Requirement</h4>
                                <p class="text-gray-600 text-sm">At least 17 years old (16 with parental consent)</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Weight Requirement</h4>
                                <p class="text-gray-600 text-sm">Weigh at least 110 pounds (50 kg)</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Health Status</h4>
                                <p class="text-gray-600 text-sm">Be in good general health and feeling well</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold">4</div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Health Assessment</h4>
                                <p class="text-gray-600 text-sm">Pass physical and health history screening</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="inline-block mt-8 px-8 py-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition shadow-md">
                        Check Full Eligibility
                    </a>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-3xl p-8">
                    <div class="bg-white rounded-2xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Before You Donate</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Get a good night's sleep</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Eat a healthy meal</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Drink plenty of water</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Bring a valid ID</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Camps -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Upcoming Blood Donation Camps</h2>
                <p class="text-gray-600 text-lg">Find a camp near you and schedule your donation</p>
            </div>
            @if($latestCamps->isEmpty())
                <p class="text-center text-gray-600 text-lg">No upcoming camps found. Please check back later!</p>
            @else
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($latestCamps as $camp)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition card-hover border border-gray-100">
                            <div class="bg-gradient-to-r from-red-600 to-red-700 p-6 text-white">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">Upcoming</span>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold mb-1">{{ \Carbon\Carbon::parse($camp->camp_date)->format('M d, Y') }}</h3>
                                <p class="text-red-100">{{ \Carbon\Carbon::parse($camp->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($camp->end_time)->format('h:i A') }}</p>
                            </div>
                            <div class="p-6">
                                <h4 class="text-xl font-bold text-gray-800 mb-3">{{ $camp->name }}</h4>
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-gray-800 font-medium">{{ $camp->address }}, {{ $camp->city->name ?? '' }}, {{ $camp->state->name ?? '' }}</p>
                                            <p class="text-gray-500 text-sm">{{ Str::limit($camp->description, 50) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <div>
                                            <p class="text-gray-800 font-medium">{{ $camp->organizer }}</p>
                                            <p class="text-gray-500 text-sm">Organizer</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <span class="text-sm text-gray-500">Available: {{ $camp->bloodUnits->where('status', 'ready_for_issue')->where('serology_test_status', 'passed')->count() }} units</span>
                                    <a href="#" class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition text-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            {{-- <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center space-x-2 text-red-600 font-semibold hover:text-red-700">
                    <span>View All Camps</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div> --}}
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-red-600 to-red-800 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Save Lives?</h2>
            <p class="text-xl text-red-100 mb-8 max-w-2xl mx-auto">
                Join thousands of donors who are making a difference. Your donation could be the gift of life for someone in need.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('donor.register.form') }}" class="px-8 py-4 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100 transition shadow-xl">
                    Register as Donor
                </a>
                <a href="/" class="px-8 py-4 bg-red-700 text-white font-bold rounded-lg hover:bg-red-800 transition border-2 border-white/30">
                    Find Blood Near You
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="text-xl font-bold text-white">LifeSaver</span>
                    </div>
                    <p class="text-sm text-gray-400">Connecting donors with those in need. Every drop counts in saving lives.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-red-400 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Find Blood</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Donation Camps</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">FAQs</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-red-400 transition">Eligibility Checker</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Donation Process</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Health Guidelines</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>+1 234 567 8900</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>info@lifesaver.org</span>
                        </li>
                    </ul>
                    <div class="flex space-x-3 mt-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2025 LifeSaver Blood Bank Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>