<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Blood Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-4xl">
        <a href="/" class="text-red-600 hover:text-red-700 font-medium transition">Back to Home</a>
        <h2 class="text-2xl font-bold text-center text-red-700 mb-6">Request Blood Donation</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">There were some errors with your submission.</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('blood.request.submit') }}" method="POST">
            @csrf

            <!-- Patient Information Section -->
            <fieldset class="border border-gray-300 p-6 rounded-md mb-8">
                <legend class="text-xl font-semibold text-gray-800 mb-4 px-2">Patient Information</legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" id="first_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" value="{{ old('first_name') }}" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" id="last_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" value="{{ old('last_name') }}" required>
                    </div>
                    <div>
                        <label for="mobile_number" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" value="{{ old('mobile_number') }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" value="{{ old('email') }}" required>
                    </div>
                    <div>
    <label for="password" class="block text-sm font-medium text-gray-700">
        Password <span class="text-red-500">*</span>
    </label>
    <input
        type="password"
        name="password"
        id="password"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500"
        required
    >
    @error('password')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
        Confirm Password <span class="text-red-500">*</span>
    </label>
    <input
        type="password"
        name="password_confirmation"
        id="password_confirmation"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500"
        required
    >
</div>
                    
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" id="gender" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" value="{{ old('date_of_birth') }}" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="address" id="address" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">{{ old('address') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="hospital_name" class="block text-sm font-medium text-gray-700">Hospital Name <span class="text-red-500">*</span></label>
                        <input type="text" name="hospital_name" id="hospital_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" value="{{ old('hospital_name') }}" required>
                    </div>
                </div>
            </fieldset>

            <!-- Blood Request Section -->
            <fieldset class="border border-gray-300 p-6 rounded-md mb-8">
                <legend class="text-xl font-semibold text-gray-800 mb-4 px-2">Blood Request Details</legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="blood_group_id" class="block text-sm font-medium text-gray-700">Blood Group Needed <span class="text-red-500">*</span></label>
                        <select name="blood_group_id" id="blood_group_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" required>
                            <option value="">Select Blood Group</option>
                            @foreach ($bloodGroups as $bloodGroup)
                                <option value="{{ $bloodGroup->id }}" {{ old('blood_group_id') == $bloodGroup->id ? 'selected' : '' }}>
                                    {{ $bloodGroup->group_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="units_requested" class="block text-sm font-medium text-gray-700">Units Requested (1 unit of blood is typically around 450–500 ml ) <span class="text-red-500">*</span></label>
                        <input type="number" name="units_requested" id="units_requested" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" value="{{ old('units_requested') }}" required>
                    </div>
                    <div>
                        <label for="urgency_level" class="block text-sm font-medium text-gray-700">Urgency Level <span class="text-red-500">*</span></label>
                        <select name="urgency_level" id="urgency_level" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" required>
                            <option value="">Select Urgency</option>
                            <option value="routine" {{ old('urgency_level') == 'routine' ? 'selected' : '' }}>Routine</option>
                            <option value="urgent" {{ old('urgency_level') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            <option value="emergency" {{ old('urgency_level') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                        </select>
                    </div>
                    <div>
                        <label for="required_by_date" class="block text-sm font-medium text-gray-700">Required By Date</label>
                        <input type="date" name="required_by_date" id="required_by_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" value="{{ old('required_by_date') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Additional Information</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500">{{ old('description') }}</textarea>
                    </div>
                </div>
            </fieldset>

            <div class="flex justify-center">
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Register Blood Request
                </button>
            </div>
        </form>
    </div>
</body>
</html>
