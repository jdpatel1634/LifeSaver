<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LifeSaver Blood Bank Management System</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

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
                <a href="/" class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span class="text-2xl font-bold text-gray-800">
                        Life<span class="text-red-600">Saver</span>
                    </span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-red-600 font-medium transition">Home</a>
                    <a href="{{ route('blood.request.form') }}" class="text-gray-700 hover:text-red-600 font-medium transition">Request Blood</a>
                    <a href="{{ route('donor.register.form') }}" class="text-gray-700 hover:text-red-600 font-medium transition">Register as Donor</a>
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
                        <a href="/login" class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition shadow-md">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white py-20">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium">
                        🩸 About LifeSaver
                    </div>

                    <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                        Connecting Donors <br/>
                        <span class="text-red-200">With Patients</span>
                    </h1>

                    <p class="text-xl text-red-100">
                        LifeSaver is a blood bank management system that organizes blood requests,
                        donor registration, blood inventory, testing, and safe blood issuing in one platform.
                    </p>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('blood.request.form') }}" class="px-8 py-4 bg-red-800 text-white font-bold rounded-lg hover:bg-red-900 transition border-2 border-white/20">
                            Request Blood
                        </a>

                        <a href="{{ route('donor.register.form') }}" class="px-8 py-4 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100 transition shadow-xl">
                            Register as Donor
                        </a>
                    </div>

                    <div class="flex items-center space-x-6 pt-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Organized Records</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Safe Blood Workflow</span>
                        </div>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-sm rounded-3xl transform rotate-6"></div>
                        <div class="relative bg-white/20 backdrop-blur-md rounded-3xl p-8 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="blood-type-badge text-center py-6 rounded-xl">
                                    <div class="text-3xl font-bold text-red-600">Patient</div>
                                    <p class="text-red-700 mt-2 font-medium">Requests Blood</p>
                                </div>

                                <div class="blood-type-badge text-center py-6 rounded-xl">
                                    <div class="text-3xl font-bold text-red-600">Donor</div>
                                    <p class="text-red-700 mt-2 font-medium">Registers Online</p>
                                </div>

                                <div class="blood-type-badge text-center py-6 rounded-xl">
                                    <div class="text-3xl font-bold text-red-600">Admin</div>
                                    <p class="text-red-700 mt-2 font-medium">Reviews Records</p>
                                </div>

                                <div class="blood-type-badge text-center py-6 rounded-xl">
                                    <div class="text-3xl font-bold text-red-600">Safe</div>
                                    <p class="text-red-700 mt-2 font-medium">Tested Units</p>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl p-6 space-y-3">
                                <h3 class="text-gray-800 font-bold text-lg">System Purpose</h3>
                                <p class="text-gray-600">
                                    LifeSaver reduces manual record keeping and helps admins manage the
                                    full blood management lifecycle from request to issue.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <!-- System Overview -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">What LifeSaver Does</h2>
            <p class="text-gray-600 text-lg">A complete blood management workflow for public users and administrators</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition card-hover border border-gray-100">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-3">Blood Requests</h3>
                <p class="text-gray-600 mb-4">
                    Patients can submit blood requests with hospital details, required blood group,
                    urgency level, units needed, and required date.
                </p>

                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center space-x-2">
                        <span class="text-green-500">✓</span>
                        <span>Patient account creation</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-green-500">✓</span>
                        <span>Pending request status</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition card-hover border border-gray-100">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-3">Donor Registration</h3>
                <p class="text-gray-600 mb-4">
                    Donors can register online, create an account, and wait for admin verification
                    before becoming active donors.
                </p>

                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center space-x-2">
                        <span class="text-green-500">✓</span>
                        <span>Donor profile records</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-green-500">✓</span>
                        <span>Admin verification</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition card-hover border border-gray-100">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-3">Admin Management</h3>
                <p class="text-gray-600 mb-4">
                    Admin users manage donors, patients, requests, blood units, serology tests,
                    reservations, camps, and blood issuing.
                </p>

                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center space-x-2">
                        <span class="text-green-500">✓</span>
                        <span>Inventory tracking</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="text-green-500">✓</span>
                        <span>Safe blood issuing</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


    <!-- Workflow Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">How The System Works</h2>
                <p class="text-gray-600 text-lg">From public request to safe blood delivery</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center space-y-2 card-hover bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100">
                    <div class="w-12 h-12 mx-auto bg-red-600 text-white rounded-full flex items-center justify-center text-xl font-bold">1</div>
                    <h3 class="text-xl font-bold text-gray-800">Request</h3>
                    <p class="text-gray-600">A patient submits a blood request through the public form.</p>
                </div>

                <div class="text-center space-y-2 card-hover bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100">
                    <div class="w-12 h-12 mx-auto bg-red-600 text-white rounded-full flex items-center justify-center text-xl font-bold">2</div>
                    <h3 class="text-xl font-bold text-gray-800">Review</h3>
                    <p class="text-gray-600">Admin reviews the request and checks available blood units.</p>
                </div>

                <div class="text-center space-y-2 card-hover bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100">
                    <div class="w-12 h-12 mx-auto bg-red-600 text-white rounded-full flex items-center justify-center text-xl font-bold">3</div>
                    <h3 class="text-xl font-bold text-gray-800">Test</h3>
                    <p class="text-gray-600">Blood units are checked using serology test records.</p>
                </div>

                <div class="text-center space-y-2 card-hover bg-gradient-to-br from-red-50 to-white p-6 rounded-xl border border-red-100">
                    <div class="w-12 h-12 mx-auto bg-red-600 text-white rounded-full flex items-center justify-center text-xl font-bold">4</div>
                    <h3 class="text-xl font-bold text-gray-800">Issue</h3>
                    <p class="text-gray-600">Safe and approved units are issued to patients.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Why LifeSaver Matters</h2>
                    <p class="text-gray-600 text-lg mb-8">
                        Manual blood bank records can lead to delays, errors, and difficulty tracking
                        safe blood units. LifeSaver provides a structured digital system that improves
                        organization and transparency.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Better Accuracy</h4>
                                <p class="text-gray-600 text-sm">Stores donor, patient, request, inventory, and issue records in one system.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Safer Blood Handling</h4>
                                <p class="text-gray-600 text-sm">Supports serology test tracking before blood units are issued.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 p-4 bg-red-50 rounded-xl">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Faster Admin Workflow</h4>
                                <p class="text-gray-600 text-sm">Admins can review requests, manage units, and issue blood from the admin panel.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-3xl p-8">
                    <div class="bg-white rounded-2xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Main Modules</h3>

                        <ul class="space-y-4">
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Blood Request Management</span>
                            </li>

                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Donor Registration and Verification</span>
                            </li>

                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Blood Inventory and Serology Testing</span>
                            </li>

                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Blood Reservation and Issue Tracking</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-red-600 to-red-800 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Save Lives?</h2>
            <p class="text-xl text-red-100 mb-8 max-w-2xl mx-auto">
                Join LifeSaver by requesting blood when needed or registering as a donor to help others.
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('donor.register.form') }}" class="px-8 py-4 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100 transition shadow-xl">
                    Register as Donor
                </a>

                <a href="{{ route('blood.request.form') }}" class="px-8 py-4 bg-red-700 text-white font-bold rounded-lg hover:bg-red-800 transition border-2 border-white/30">
                    Request Blood
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
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="text-xl font-bold text-white">LifeSaver</span>
                    </div>
                    <p class="text-sm text-gray-400">
                        Connecting donors with those in need. Every drop counts in saving lives.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-red-400 transition">About Us</a></li>
                        <li><a href="{{ route('blood.find') }}" class="hover:text-red-400 transition">Find Blood</a></li>
                        <li><a href="{{ route('donation.camps') }}" class="hover:text-red-400 transition">Donation Camps</a></li>
                        <li><a href="{{ route('faqs') }}" class="hover:text-red-400 transition">FAQs</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('eligibility.checker') }}" class="hover:text-red-400 transition">Eligibility Checker</a></li>
                        <li><a href="{{ route('donation.process') }}" class="hover:text-red-400 transition">Donation Process</a></li>
                        <li><a href="{{ route('health.guidelines') }}" class="hover:text-red-400 transition">Health Guidelines</a></li>
                        <li><a href="{{ route('privacy.policy') }}" class="hover:text-red-400 transition">Privacy Policy</a></li>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7H5v10a2 2 0 002 2z"></path>
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
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2026 LifeSaver Blood Bank Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
