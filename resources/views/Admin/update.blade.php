<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Management - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .nav-item.active .w-10 {
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-item.active i {
            color: white;
        }

        body {
            min-height: 100vh;
            background: white;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(72, 187, 120, 0.4);
        }
        .btn-danger {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 101, 101, 0.4);
        }
        .profile-photo {
            transition: all 0.3s ease;
        }
        .profile-photo:hover {
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #833ec8ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="flex bg-blue-50 min-h-screen select-none">
    <!-- Hamburger Button -->
    <button id="hamburger" class="fixed top-4 left-4 z-50 md:hidden bg-gradient-to-r from-blue-600 to-blue-700 text-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    @php
        $navItems = [
            [
                'label' => 'Dashboard',
                'icon' => 'fa-chart-simple',
                'bg' => 'bg-blue-100',
                'hover' => 'hover:bg-blue-50',
                'text' => 'text-blue-600',
                'onclick' => "window.location.href='/admin/dashboard'",
            ],
            [
                'label' => 'Guides',
                'icon' => 'fa-user-tie',
                'bg' => 'bg-green-100',
                'hover' => 'hover:bg-green-50',
                'text' => 'text-green-600',
                'onclick' => "window.location.href='/admin/dashboard'",
                'active' => true,
            ],
            [
                'label' => 'Items',
                'icon' => 'fa-gifts',
                'bg' => 'bg-purple-100',
                'hover' => 'hover:bg-purple-50',
                'text' => 'text-purple-600',
                'onclick' => "window.location.href='/admin/dashboard'",
            ],
            [
                'label' => 'Redemption Requests',
                'icon' => 'fa-clipboard-check',
                'bg' => 'bg-orange-100',
                'hover' => 'hover:bg-orange-50',
                'text' => 'text-orange-600',
                'onclick' => "window.location.href='/admin/dashboard'",
            ],
        ];
    @endphp

    <aside id="sidebar" class="w-72 bg-white/95 backdrop-blur-lg shadow-2xl flex flex-col justify-between fixed h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40 border-r border-blue-100">
        <button id="closeSidebar" class="absolute top-4 right-4 md:hidden text-gray-500 hover:text-gray-700 transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="p-6 flex flex-col border-b border-blue-100">
            <div class="mb-2">
                <img src="/storage/appImages/logo.png" alt="Logo" class="w-40 h-auto">
                <h1 class="text-sm mt-2 text-gray-600"><i class="fas fa-user-shield mr-2"></i>Admin Panel</h1>
            </div>
        </div>

        <div class="flex-1 p-6">
            <nav class="space-y-2">
                @foreach ($navItems as $item)
                    <button onclick="{{ $item['onclick'] }}" class="nav-item {{ $item['active'] ?? false ? 'active' : '' }} flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 {{ $item['hover'] }} hover:shadow-sm">
                        <div class="w-10 h-10 {{ $item['bg'] }} rounded-lg flex items-center justify-center mr-3">
                            <i class="fa-solid {{ $item['icon'] }} {{ $item['text'] }}"></i>
                        </div>
                        <span class="font-medium">{{ $item['label'] }}</span>
                    </button>
                @endforeach
            </nav>
        </div>

        <div class="p-6 border-t border-blue-100">
            {{-- <div class="space-y-3">
                <button onclick="localStorage.removeItem('admin_token'); window.location.href='/admin/login'" class="w-full flex items-center px-4 py-3 text-left rounded-xl transition-all duration-200 bg-red-100 hover:bg-red-200 hover:shadow-sm">
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center mr-3">
                        <i class="fa-solid fa-sign-out-alt text-red-600"></i>
                    </div>
                    <span class="font-medium text-red-600">Logout</span>
                </button>
            </div> --}}
            <div class="space-y-3">
                <button 
                    onclick="localStorage.removeItem('admin_token'); window.location.href='{{ url('admin/login') }}'" 
                    class="w-full flex items-center px-4 py-3 text-left rounded-xl transition-all duration-200 bg-red-100 hover:bg-red-200 hover:shadow-sm"
                >
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center mr-3">
                        <i class="fa-solid fa-sign-out-alt text-red-600"></i>
                    </div>
                    <span class="font-medium text-red-600">Logout</span>
                </button>
            </div>
            
            <p class="mt-4 text-xs text-center text-gray-400">
                &copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd.<br>All rights reserved.
            </p>
        </div>
    </aside>

    <div id="overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden md:hidden"></div>

    <main id="mainContent" class="flex-1 md:ml-72 p-6 transition-all duration-300">
        <!-- Header Section -->
        <div class="animate-fade-in">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20 mb-8">
                {{-- <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-bold gradient-text mb-2">Edit Guide Profile</h2>
                        <p class="text-gray-600">Manage and edit individual guide profiles here</p>
                    </div>
                    <a href="/admin/dashboard" class="group bg-white/90 backdrop-blur-md border border-white/30 hover:bg-white text-gray-700 hover:text-gray-900 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fa-solid fa-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
                        <span class="font-semibold">Back to Dashboard</span>
                    </a>
                </div> --}}
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-bold gradient-text mb-2">Edit Guide Profile</h2>
                        <p class="text-gray-600">Manage and edit individual guide profiles here</p>
                    </div>
                    <a href="{{ url('/admin/dashboard') }}"
                       class="group bg-white/90 backdrop-blur-md border border-white/30 hover:bg-white text-gray-700 hover:text-gray-900 rounded-2xl px-6 py-3 flex items-center gap-3 shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fa-solid fa-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
                        <span class="font-semibold">Back to Dashboard</span>
                    </a>
                </div>
                
            </div>

            <!-- Guide Info Section -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20 mb-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    
                    <!-- Profile Photo -->
                    <div id="profilePhotoPreview"
                        class="w-40 h-40 rounded-full bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 flex items-center justify-center text-gray-400 text-6xl overflow-hidden shadow-xl border-4 border-white profile-photo">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <!-- Guide Info + Stats -->
                    <div class="flex-1 w-full">
                        <div class="text-center md:text-left mb-8">
                            <h1 id="guideName" class="text-4xl font-bold gradient-text mb-2">
                                Loading Guide...
                            </h1>
                            <p id="guideId" class="text-gray-600 text-lg font-medium"></p>
                        </div>

                        <!-- Redemption Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow-md">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <i class="fa-solid fa-clock text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs text-blue-600 font-semibold uppercase tracking-wide">Last Redeemed</span>
                                        <div id="redeemedAtDetail" class="text-gray-800 font-bold text-base">Loading...</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-md">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                        <i class="fa-solid fa-star text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs text-green-600 font-semibold uppercase tracking-wide">Current Points</span>
                                        <div id="pointsDetail" class="text-gray-800 font-bold text-base">Loading...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
                <!-- Left Section - Profile Edit -->
                <div class="xl:col-span-2">
                    <div class="glass-card rounded-3xl shadow-2xl p-10 border border-white/20">
                        <div class="text-center mb-8">
                            <h3 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                                <i class="fa-solid fa-edit mr-3"></i>Edit Profile Information
                            </h3>
                            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-500 mx-auto rounded-full"></div>
                        </div>
                        
                        <form id="updateGuideForm" enctype="multipart/form-data" class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-bold text-lg">
                                        <i class="fa-solid fa-user mr-2 text-blue-500"></i>Full Name
                                    </label>
                                    <input type="text" name="full_name" id="full_name" 
                                        class="input-field w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg bg-white shadow-inner" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-bold text-lg">
                                        <i class="fa-solid fa-phone mr-2 text-green-500"></i>Mobile Number
                                    </label>
                                    <input type="text" name="mobile_number" id="mobile_number" 
                                        class="input-field w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-400 focus:border-green-400 text-lg bg-white shadow-inner" required>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-bold text-lg">
                                        <i class="fa-solid fa-calendar mr-2 text-purple-500"></i>Date of Birth
                                    </label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" 
                                        class="input-field w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 text-lg bg-white shadow-inner">
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-bold text-lg">
                                        <i class="fa-solid fa-envelope mr-2 text-red-500"></i>Email Address
                                    </label>
                                    <input type="email" name="email" id="email" 
                                        class="input-field w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-400 focus:border-red-400 text-lg bg-white shadow-inner">
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-bold text-lg">
                                        <i class="fa-brands fa-whatsapp mr-2 text-green-500"></i>WhatsApp Number
                                    </label>
                                    <input type="text" name="whatsapp_number" id="whatsapp_number" 
                                        class="input-field w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-400 focus:border-green-400 text-lg bg-white shadow-inner">
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-bold text-lg">
                                        <i class="fa-solid fa-camera mr-2 text-indigo-500"></i>Profile Photo
                                    </label>
                                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" 
                                        class="input-field w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 text-lg bg-white shadow-inner file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                            </div>
                            
                            <div id="error" class="text-red-600 text-center font-semibold text-lg bg-red-50 rounded-2xl p-4 hidden"></div>
                            
                            <div class="flex flex-col md:flex-row gap-6 pt-6">
                                <button type="submit" 
                                        class="btn-primary flex-1 text-white py-4 px-8 rounded-2xl font-bold text-xl shadow-2xl flex items-center justify-center gap-3 transition-all duration-300">
                                    <i class="fa-solid fa-save text-xl"></i>
                                    Update Guide Profile
                                </button>
                                <button type="button" id="removeGuideBtn" 
                                        class="btn-danger flex-1 text-white py-4 px-8 rounded-2xl font-bold text-xl shadow-2xl flex items-center justify-center gap-3 transition-all duration-300">
                                    <i class="fa-solid fa-trash text-xl"></i>
                                    Remove Guide
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="space-y-10">
                    <!-- Add Visit Section -->
                    <div class="glass-card rounded-3xl shadow-2xl p-8 border border-white/20">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-4">
                                <i class="fa-solid fa-plus-circle mr-3"></i>Add New Visit
                            </h3>
                            <div class="w-20 h-1 bg-gradient-to-r from-green-500 to-emerald-500 mx-auto rounded-full"></div>
                        </div>
                        
                        <form id="addVisitForm" class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-gray-700 font-bold text-lg">
                                    <i class="fa-solid fa-calendar-day mr-2 text-green-500"></i>Visit Date
                                </label>
                                <input type="date" name="visit_date" id="visit_date" 
                                    class="input-field w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-green-400 focus:border-green-400 text-lg bg-white shadow-inner" required>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-gray-700 font-bold text-lg">
                                    <i class="fa-solid fa-users mr-2 text-blue-500"></i>Tourist Count
                                </label>
                                <input type="number" name="pax_count" id="pax_count" 
                                    class="input-field w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg bg-white shadow-inner" min="1" required>
                            </div>
                            
                            <div id="visitError" class="text-red-600 text-center font-semibold text-lg bg-red-50 rounded-2xl p-4 hidden"></div>
                            
                            <button type="submit" 
                                    class="btn-success w-full text-white py-4 px-8 rounded-2xl font-bold text-xl shadow-2xl flex items-center justify-center gap-3 transition-all duration-300">
                                <i class="fa-solid fa-plus text-xl"></i>
                                Add Visit Record
                            </button>
                        </form>
                    </div>

                    <!-- Redemption Info Section -->
                    <div class="glass-card rounded-3xl shadow-2xl p-8 border border-white/20">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                                <i class="fa-solid fa-gift mr-3"></i>Redemption Information
                            </h3>
                            <div class="w-20 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
                        </div>
                        
                        <div class="space-y-6">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <i class="fa-solid fa-clock text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm text-blue-600 font-semibold uppercase tracking-wide">Last Redeemed</span>
                                        <div id="redeemedAtDetail" class="text-gray-800 font-bold text-lg">Loading...</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                        <i class="fa-solid fa-star text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm text-green-600 font-semibold uppercase tracking-wide">Current Points</span>
                                        <div id="pointsDetail" class="text-gray-800 font-bold text-lg">Loading...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Left Section - Profile Edit -->
                <div class="xl:col-span-2">
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                        <div class="text-left mb-8">
                            <h2 class="text-2xl font-bold text-gray-800">
                                Edit Profile Information
                            </h2>
                        </div>
                        <form id="updateGuideForm" enctype="multipart/form-data" class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-semibold text-sm uppercase tracking-wider">Full Name</label>
                                    <input type="text" name="full_name" id="full_name" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm bg-white shadow-sm" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-semibold text-sm uppercase tracking-wider">Mobile Number</label>
                                    <input type="text" name="mobile_number" id="mobile_number" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-green-400 text-sm bg-white shadow-sm" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-semibold text-sm uppercase tracking-wider">Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 text-sm bg-white shadow-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-semibold text-sm uppercase tracking-wider">Email Address</label>
                                    <input type="email" name="email" id="email" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-400 focus:border-red-400 text-sm bg-white shadow-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-semibold text-sm uppercase tracking-wider">WhatsApp Number</label>
                                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-green-400 text-sm bg-white shadow-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-semibold text-sm uppercase tracking-wider">Profile Photo</label>
                                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 text-sm bg-white shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                            </div>
                            <div id="error" class="text-red-600 text-center font-semibold text-sm bg-red-50 rounded-xl p-4 hidden"></div>
                            <div class="flex flex-col md:flex-row gap-4 pt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white w-full py-3 px-6 rounded-xl font-medium text-sm shadow-md flex items-center justify-center gap-2 transition-all duration-300">
                                    <i class="fa-solid fa-save"></i>Update Guide Profile
                                </button>
                                <button type="button" id="removeGuideBtn" class="bg-red-600 hover:bg-red-700 text-white w-full py-3 px-6 rounded-xl font-medium text-sm shadow-md flex items-center justify-center gap-2 transition-all duration-300">
                                    <i class="fa-solid fa-trash"></i>Remove Guide
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="space-y-10">
                    <!-- Add Visit Section -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20">
                        <div class="text-left mb-8">
                            <h2 class="text-2xl font-bold text-gray-800">
                                Add New Visit
                            </h2>
                        </div>
                        <form id="addVisitForm" class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-gray-700 font-semibold text-sm uppercase tracking-wider">Visit Date</label>
                                <input type="date" name="visit_date" id="visit_date" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-green-400 text-sm bg-white shadow-sm" required>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-gray-700 font-semibold text-sm uppercase tracking-wider">Tourist Count</label>
                                <input type="number" name="pax_count" id="pax_count" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm bg-white shadow-sm" min="1" required>
                            </div>
                            <div id="visitError" class="text-red-600 text-center font-semibold text-sm bg-red-50 rounded-xl p-4 hidden"></div>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white w-full py-3 px-6 rounded-xl font-medium text-sm shadow-md flex items-center justify-center gap-2 transition-all duration-300">
                                <i class="fa-solid fa-plus"></i>Add Visit Record
                            </button>
                        </form>
                    </div>

                    <!-- Redemption Info Section -->
                    {{-- <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/20 p-8">
                        <div class="text-center mb-8">
                            <h3 class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                                <i class="fa-solid fa-gift mr-3"></i>Redemption Information
                            </h3>
                            <div class="w-20 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <i class="fa-solid fa-clock text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs text-blue-600 font-semibold uppercase tracking-wide">Last Redeemed</span>
                                        <div id="redeemedAtDetail" class="text-gray-800 font-bold text-base">Loading...</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                        <i class="fa-solid fa-star text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs text-green-600 font-semibold uppercase tracking-wide">Current Points</span>
                                        <div id="pointsDetail" class="text-gray-800 font-bold text-base">Loading...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </main>
<script>
    // Get guide ID from URL (e.g., /admin/guides/1/edit)
    const urlParts = window.location.pathname.split('/');
    const guideId = urlParts[urlParts.length - 2] || urlParts.pop();
    const token = localStorage.getItem('admin_token');
    const errorDiv = document.getElementById('error');

    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const overlay = document.getElementById('overlay');

        function setInitialState() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        setInitialState();

        function toggleSidebar() {
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }
        }

        function closeSidebarFn() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        hamburger.addEventListener('click', toggleSidebar);
        closeSidebar.addEventListener('click', closeSidebarFn);
        overlay.addEventListener('click', closeSidebarFn);

        const navButtons = sidebar.querySelectorAll('button');
        navButtons.forEach(button => {
            button.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    closeSidebarFn();
                }
            });
        });

        window.addEventListener('resize', () => {
            setInitialState();
        });
    });

    // Fetch guide details
    async function fetchGuide() {
        if (!token) {
            errorDiv.textContent = 'You must be logged in as admin.';
            return;
        }
        try {
            const response = await fetch(`/api/admin/guides/${guideId}`, {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const guide = await response.json();
            if (!response.ok) {
                errorDiv.textContent = guide.message || 'Failed to fetch guide.';
                return;
            }
            fillGuideForm(guide.guide);
        } catch (err) {
            errorDiv.textContent = 'Network error';
        }
    }

    function fillGuideForm(guide) {
        document.getElementById('guideName').textContent = guide.full_name || 'Guide Details';
        document.getElementById('guideId').textContent = guide.id ? `Guide ID: ${guide.id}` : '';
        document.getElementById('full_name').value = guide.full_name || '';
        document.getElementById('mobile_number').value = guide.mobile_number || '';
        document.getElementById('date_of_birth').value = guide.date_of_birth || '';
        document.getElementById('email').value = guide.email || '';
        document.getElementById('whatsapp_number').value = guide.whatsapp_number || '';
        if (guide.profile_photo) {
            document.getElementById('profilePhotoPreview').innerHTML =
                `<img src="/storage/${guide.profile_photo}" alt="Profile" class="w-full h-full rounded-3xl object-cover">`;
        } else {
            document.getElementById('profilePhotoPreview').innerHTML = `<i class="fa-solid fa-user text-6xl text-gray-400"></i>`;
        }
    }

    // Update all profile fields
    document.getElementById('updateGuideForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const errorDiv = document.getElementById('error');
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        errorDiv.textContent = '';
        errorDiv.classList.add('hidden');
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Updating...';
        submitBtn.disabled = true;
        
        const form = e.target;
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        
        try {
            const response = await fetch(`/api/admin/guides/${guideId}`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await response.json();
            if (!response.ok) {
                errorDiv.textContent = data.message || 'Failed to update guide';
                errorDiv.classList.remove('hidden');
            } else {
                // Show success message
                errorDiv.textContent = 'Guide updated successfully!';
                errorDiv.className = 'text-green-600 text-center font-semibold text-lg bg-green-50 rounded-2xl p-4';
                fetchGuide();
                setTimeout(() => {
                    errorDiv.classList.add('hidden');
                }, 3000);
            }
        } catch (err) {
            errorDiv.textContent = 'Network error occurred';
            errorDiv.classList.remove('hidden');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });

    document.getElementById('removeGuideBtn').addEventListener('click', async function() {
        if (!confirm('Are you sure you want to remove this guide?')) return;
        errorDiv.textContent = '';
        try {
            const response = await fetch(`/api/admin/guides/${guideId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (!response.ok) {
                errorDiv.textContent = data.message || 'Failed to remove guide';
            } else {
                alert('Guide removed successfully!');
                window.location.href = '/admin/dashboard';
            }
        } catch (err) {
            errorDiv.textContent = 'Network error';
        }
    });

    // Add Visit Form
    document.getElementById('addVisitForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const visitErrorDiv = document.getElementById('visitError');
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        visitErrorDiv.textContent = '';
        visitErrorDiv.classList.add('hidden');
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Adding Visit...';
        submitBtn.disabled = true;
        
        const visit_date = document.getElementById('visit_date').value;
        const pax_count = document.getElementById('pax_count').value;
        
        try {
            const response = await fetch('/api/admin/visits', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    guide_id: guideId,
                    visit_date: visit_date,
                    pax_count: pax_count
                })
            });
            const data = await response.json();
            if (!response.ok) {
                visitErrorDiv.textContent = data.message || 'Failed to add visit';
                visitErrorDiv.classList.remove('hidden');
            } else {
                // Show success message
                visitErrorDiv.textContent = 'Visit added successfully!';
                visitErrorDiv.className = 'text-green-600 text-center font-semibold text-lg bg-green-50 rounded-2xl p-4';
                document.getElementById('addVisitForm').reset();
                fetchRedemption();
                setTimeout(() => {
                    visitErrorDiv.classList.add('hidden');
                }, 3000);
            }
        } catch (err) {
            visitErrorDiv.textContent = 'Network error occurred';
            visitErrorDiv.classList.remove('hidden');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });

    // Redemption Info
    async function fetchRedemption() {
        try {
            const response = await fetch(`/api/admin/guides/${guideId}/redemption`, {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (!response.ok) {
                document.getElementById('redeemedAtDetail').textContent = '-';
                document.getElementById('pointsDetail').textContent = '-';
                return;
            }
            document.getElementById('redeemedAtDetail').textContent = data.redemption?.redeemed_at || '-';
            document.getElementById('pointsDetail').textContent = data.redemption?.points ?? '-';
        } catch (err) {
            document.getElementById('redeemedAtDetail').textContent = '-';
            document.getElementById('pointsDetail').textContent = '-';
        }
    }

    fetchGuide();
    fetchRedemption();

    // Optional: Show preview of new profile photo before upload
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                document.getElementById('profilePhotoPreview').innerHTML =
                    `<img src="${evt.target.result}" alt="Profile" class="w-full h-full rounded-3xl object-cover">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html>
