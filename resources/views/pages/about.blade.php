<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LifeSaver</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2">
                <span class="text-red-600 text-2xl">❤</span>
                <span class="text-xl font-bold">
                    Life<span class="text-red-600">Saver</span>
                </span>
            </a>

            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="/" class="hover:text-red-600">Home</a>
                <a href="{{ route('blood.request.form') }}" class="hover:text-red-600">Request Blood</a>
                <a href="{{ route('donor.register.form') }}" class="hover:text-red-600">Register as Donor</a>
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="bg-red-700 text-white">
        <div class="max-w-6xl mx-auto px-6 py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">About LifeSaver</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto text-red-100">
                A digital blood bank management system designed to connect patients,
                donors, and administrators through one organized platform.
            </p>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-white rounded-xl shadow-sm p-8 border border-red-100">
                <div class="text-red-600 text-3xl mb-4">🩸</div>
                <h2 class="text-xl font-bold mb-3">Our Purpose</h2>
                <p class="text-gray-600 leading-7">
                    LifeSaver helps reduce manual blood bank record keeping by providing
                    a structured system for blood requests, donor registration, testing,
                    inventory, and issuing.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-8 border border-red-100">
                <div class="text-red-600 text-3xl mb-4">🤝</div>
                <h2 class="text-xl font-bold mb-3">Who We Serve</h2>
                <p class="text-gray-600 leading-7">
                    The system supports public users who request blood or register as donors,
                    and admin users who manage donors, patients, blood units, serology tests,
                    reservations, and blood issuing.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-8 border border-red-100">
                <div class="text-red-600 text-3xl mb-4">✅</div>
                <h2 class="text-xl font-bold mb-3">Safe Blood Workflow</h2>
                <p class="text-gray-600 leading-7">
                    Admins can record blood units, enter serology results, and issue only
                    tested and approved units to patient requests.
                </p>
            </div>

        </div>
    </section>

    <!-- Workflow Section -->
    <section class="bg-white py-16">
        <div class="max-w-5xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-10">How LifeSaver Works</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                <div class="p-6 bg-red-50 rounded-xl">
                    <div class="text-red-600 font-bold text-2xl mb-2">1</div>
                    <h3 class="font-semibold mb-2">Request</h3>
                    <p class="text-sm text-gray-600">Patients submit blood requests online.</p>
                </div>

                <div class="p-6 bg-red-50 rounded-xl">
                    <div class="text-red-600 font-bold text-2xl mb-2">2</div>
                    <h3 class="font-semibold mb-2">Register</h3>
                    <p class="text-sm text-gray-600">Donors register and wait for verification.</p>
                </div>

                <div class="p-6 bg-red-50 rounded-xl">
                    <div class="text-red-600 font-bold text-2xl mb-2">3</div>
                    <h3 class="font-semibold mb-2">Test</h3>
                    <p class="text-sm text-gray-600">Blood units are tested through serology records.</p>
                </div>

                <div class="p-6 bg-red-50 rounded-xl">
                    <div class="text-red-600 font-bold text-2xl mb-2">4</div>
                    <h3 class="font-semibold mb-2">Issue</h3>
                    <p class="text-sm text-gray-600">Safe blood units are issued to approved requests.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-red-700 text-white py-16">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Save Lives?</h2>
            <p class="text-red-100 mb-8">
                Start by requesting blood or registering as a donor.
            </p>

            <div class="flex justify-center gap-4 flex-wrap">
                <a href="{{ route('blood.request.form') }}"
                   class="bg-white text-red-700 px-6 py-3 rounded-md font-semibold hover:bg-red-50">
                    Request Blood
                </a>

                <a href="{{ route('donor.register.form') }}"
                   class="border border-white px-6 py-3 rounded-md font-semibold hover:bg-red-800">
                    Register as Donor
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-10">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-white text-xl font-bold mb-3">
                    ❤ Life<span class="text-red-500">Saver</span>
                </h3>
                <p class="text-sm text-gray-400">
                    Connecting donors with those in need. Every drop counts in saving lives.
                </p>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-white">About Us</a></li>
                    <li><a href="{{ route('blood.find') }}" class="hover:text-white">Find Blood</a></li>
                    <li><a href="{{ route('donation.camps') }}" class="hover:text-white">Donation Camps</a></li>
                    <li><a href="{{ route('faqs') }}" class="hover:text-white">FAQs</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-3">Resources</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('eligibility.checker') }}" class="hover:text-white">Eligibility Checker</a></li>
                    <li><a href="{{ route('donation.process') }}" class="hover:text-white">Donation Process</a></li>
                    <li><a href="{{ route('health.guidelines') }}" class="hover:text-white">Health Guidelines</a></li>
                    <li><a href="{{ route('privacy.policy') }}" class="hover:text-white">Privacy Policy</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-3">Contact Us</h4>
                <p class="text-sm text-gray-400">☎ +1 234 567 8900</p>
                <p class="text-sm text-gray-400">✉ info@lifesaver.org</p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-6 mt-8 pt-6 border-t border-gray-700 text-center text-sm text-gray-500">
            © 2026 LifeSaver Blood Bank Management System. All rights reserved.
        </div>
    </footer>

</body>
</html>
