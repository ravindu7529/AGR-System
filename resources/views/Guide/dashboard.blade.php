<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Dashboard</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
        }
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        /* Match admin panel active style */
        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .nav-item.active .w-10,
        .nav-item.active .w-8 {
            background: rgba(255, 255, 255, 0.2) !important;
        }

        .nav-item.active i {
            color: white !important;
        }
        .item-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            opacity: 0;
        }
        .nav-item:hover .submenu {
            max-height: 200px;
            opacity: 1;
        }
        .submenu-item {
            transform: translateX(-10px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }
        .nav-item:hover .submenu-item {
            transform: translateX(0);
            opacity: 1;
        }

        .section {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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

    <button id="hamburger" class="fixed top-6 left-6 z-50 lg:hidden bg-white/90 backdrop-blur-sm p-3 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-white/20">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <!-- Mobile Hamburger Button -->

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-white/95 backdrop-blur-lg shadow-2xl flex flex-col justify-between fixed h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40 border-r border-blue-100">
        <!-- Close button for mobile -->
        <button id="closeSidebar" class="absolute top-6 right-6 lg:hidden text-gray-500 hover:text-gray-700 p-2 rounded-xl hover:bg-white/50 transition-all duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="p-6 flex flex-col items-center">
            <!-- Logo -->
            <div class="mb-10 p-6">
                <img src="{{ asset('appImages/logo.png') }}" alt="Logo" class="w-24 h-auto">
            </div>

            <!-- Navigation -->
            <nav class="flex flex-col w-full space-y-2">
                <!-- Profile with Submenu -->
                <div class="nav-item relative">
                    <button onclick="showSection('profile')" id="profileBtn" class="nav-item flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-blue-50 hover:shadow-sm">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fa-solid fa-user text-blue-600"></i>
                        </div>
                        <span class="flex-1 font-medium">Profile</span>
                        <i class="fa-solid fa-chevron-right text-sm opacity-50 transition-transform duration-200"></i>
                    </button>
                    <!-- Submenu -->
                    <div class="submenu ml-6">
                        <button onclick="showSection('profileUpdate')" class="submenu-item nav-item flex items-center w-full px-4 py-3 rounded-xl transition-all duration-200 hover:bg-indigo-50 hover:shadow-sm text-sm">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fa-solid fa-edit text-indigo-600 text-sm"></i>
                            </div>
                            <span class='font-medium'>Update Profile</span>
                        </button>
                    </div>
                </div>

                <!-- Redeem Items -->
                <button onclick="showSection('redemption')" id="redemptionBtn" class="nav-item flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-purple-50 hover:shadow-sm">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fa-solid fa-gift text-purple-600"></i>
                    </div>
                    <span class='font-medium'>Redeem Items</span>
                </button>

                <!-- Redeem Cash -->
                <button onclick="showSection('redeemCash')" id="redeemCashBtn" class="nav-item flex items-center w-full px-4 py-3 text-left rounded-xl transition-all duration-200 hover:bg-green-50 hover:shadow-sm">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fa-solid fa-money-bill-wave text-green-600"></i>
                    </div>
                    <span class='font-medium'>Redeem Cash</span>
                </button>
            </nav>
        </div>

        <!-- Footer -->
        <div class="p-6 border-t border-blue-100">
            <div class="space-y-3">
                <button onclick="logout()" class="w-full flex items-center px-4 py-3 text-left rounded-xl transition-all duration-200 bg-red-100 hover:bg-red-200 hover:shadow-sm">
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






    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden lg:hidden"></div>

    <!-- Main content with responsive margin -->
    <main id="mainContent" class="flex-1 md:ml-72 p-6 transition-all duration-300">
            <div id="error" class="text-red-500 text-center text-sm"></div>

            <!-- Profile Section -->
            <div id="profileSection" class="section w-full hidden"></div>

            <!-- Redemption Section -->
            <div id="redemptionSection" class="section w-full hidden"></div>

            <!-- Profile Update Section -->
            <div id="profileUpdateSection" class="section w-full hidden"></div>

            <!-- Redeem Cash Section -->
            <div id="redeemCashSection" class="section w-full hidden"></div>
    </main>

    <script>
        // Section management
        function showSection(sectionName) {
            // Hide all sections
            document.getElementById('profileSection').classList.add('hidden');
            document.getElementById('redemptionSection').classList.add('hidden');
            document.getElementById('profileUpdateSection').classList.add('hidden');
            document.getElementById('redeemCashSection').classList.add('hidden');

            // Show selected section
            document.getElementById(sectionName + 'Section').classList.remove('hidden');

            // Update button states
            const buttons = document.querySelectorAll('.nav-item');
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Highlight active button based on section name
            let activeBtnId;
            if (sectionName === 'profile') {
                activeBtnId = 'profileBtn';
            } else if (sectionName === 'redemption') {
                activeBtnId = 'redemptionBtn';
            } else if (sectionName === 'redeemCash') {
                activeBtnId = 'redeemCashBtn';
            } else if (sectionName === 'profileUpdate') {
                // For profile update, we want to highlight the profile button since it's in the submenu
                activeBtnId = 'profileBtn';
            }

            const activeBtn = document.getElementById(activeBtnId);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }

            // Persist active section
            localStorage.setItem('guide_active_section', sectionName);

            // Close sidebar on mobile after navigation
            if (window.innerWidth < 1024) {
                closeSidebarFn();
            }
        }

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            const closeSidebar = document.getElementById('closeSidebar');
            const overlay = document.getElementById('overlay');

            // Set initial state based on screen size
            function setInitialState() {
                if (window.innerWidth >= 1024) {
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
                if (window.innerWidth < 1024) {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                    document.body.classList.toggle('overflow-hidden');
                }
            }

            window.closeSidebarFn = function() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            hamburger.addEventListener('click', toggleSidebar);
            closeSidebar.addEventListener('click', closeSidebarFn);
            overlay.addEventListener('click', closeSidebarFn);

            window.addEventListener('resize', setInitialState);

            // Set default active section from storage
            const savedSection = localStorage.getItem('guide_active_section') || 'profile';
            showSection(savedSection);
        });

        function logout() {
            if (!confirm('Are you sure you want to logout?')) return;
            localStorage.removeItem('guide_token');
            window.location.href = '/guide/login';
        }

        // Get guide ID from URL
        const urlParts = window.location.pathname.split('/');
        const guideId = urlParts[urlParts.length - 1];
        const token = localStorage.getItem('guide_token');
        if (!token) window.location.href = '/guide/login';

        // Fetch and render dashboard data
        document.addEventListener('DOMContentLoaded', fetchGuideDashboard);

        async function fetchGuideDashboard() {
            try {
                const response = await fetch(`/api/guide/${guideId}/dashboard`, {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (!response.ok) {
                    document.getElementById('error').textContent = data.message || 'Failed to fetch profile';
                    return;
                }
                renderProfileSection(data.guide);
                renderRedemptionSection(data.guide, data.redemption, data.items);
                renderProfileUpdateSection(data.guide);
                renderRedeemCashSection(data.guide, data.redemption); // Pass redemption data here
            } catch (error) {
                document.getElementById('error').textContent = 'Network error';
            }
        }

        function renderProfileSection(guide) {
            document.getElementById('profileSection').innerHTML = `
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20 mb-8">
                <div class="flex items-center gap-6">
                    <!-- Profile Photo -->
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 flex items-center justify-center text-gray-400 text-4xl overflow-hidden shadow-2xl border-4 border-white">
                        ${guide.profile_photo ?
                            `<img src="/storage/${guide.profile_photo}" class="w-full h-full object-cover rounded-full">` :
                            '<i class="fa-solid fa-user text-gray-400"></i>'
                        }
                    </div>

                    <!-- Greeting Text -->
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold gradient-text mb-1">Hello, ${guide.full_name}!</h2>
                        <p class="text-gray-600 text-base">Welcome to your guide dashboard</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Email -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-md">
                            <i class="p-10 fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Email</p>
                            <p class="text-sm font-semibold text-blue-700 break-all">${guide.email}</p>
                        </div>
                    </div>
                </div>

                <!-- Mobile -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-yellow-500 to-yellow-600 shadow-md">
                            <i class="p-10 fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Mobile</p>
                            <p class="text-sm font-semibold text-yellow-700">${guide.mobile_number}</p>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-green-500 to-green-600 shadow-md">
                            <i class="p-10 fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">WhatsApp</p>
                            <p class="text-sm font-semibold text-green-700">${guide.whatsapp_number || 'Not provided'}</p>
                        </div>
                    </div>
                </div>

                <!-- Date of Birth -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-md">
                            <i class="p-10 fa-solid fa-cake-candles"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Date of Birth</p>
                            <p class="text-sm font-semibold text-purple-700">${guide.date_of_birth || 'Not provided'}</p>
                        </div>
                    </div>
                </div>
            </div>

        `;
        }

        function renderRedemptionSection(guide, redemption, items) {
            const pointsRemaining = redemption ? redemption.points : guide.earned_points || 0;
            const reservedPoints = redemption ? redemption.reserved_points || 0 : 0;
            const availablePoints = (pointsRemaining - reservedPoints || 0);

            let itemsHtml = '';

            items.forEach(item => {
                itemsHtml += `
                <label for="item_${item.id}" class="block">
                    <div class="flex items-center justify-between p-5 bg-white/80 backdrop-blur-sm rounded-3xl border border-gray-200 transition-all duration-200 hover:border-purple-400 hover:shadow-xl group item-card cursor-pointer">
                        <!-- Left Section -->
                        <div class="flex items-center gap-4 flex-1">
                            <!-- Checkbox -->
                            <div class="relative">
                                <input
                                    type="checkbox"
                                    id="item_${item.id}"
                                    value="${item.id}"
                                    data-points="${item.points}"
                                    class="item-checkbox w-6 h-6 text-purple-600 border-2 border-gray-200 rounded-lg cursor-pointer focus:ring-purple-500 focus:ring-offset-2 transition-all z-10 relative"
                                >
                                <div class="absolute inset-0 rounded-lg bg-purple-500 opacity-0 group-hover:opacity-10 transition-opacity pointer-events-none"></div>
                            </div>

                            <!-- Item Info -->
                            <div>
                                <p class="text-sm text-gray-500 font-medium mb-1">Item</p>
                                <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-700 transition-colors">
                                    ${item.name}
                                </h3>
                            </div>
                        </div>

                        <!-- Points Badge -->
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white px-6 py-3 rounded-2xl font-bold text-lg shadow-lg ml-6 min-w-fit whitespace-nowrap group-hover:scale-105 transition-transform">
                            ${item.points} pts
                        </div>
                    </div>
                </label>
                `;
            });

            // REMOVE THE CASH REDEMPTION SECTION FROM HERE
            document.getElementById('redemptionSection').innerHTML = `
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20 mb-8">
                    <div class="flex items-center gap-6">
                        <!-- Greeting Text -->
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold gradient-text mb-1">Redeem Items</h2>
                            <p class="text-gray-600 text-base">Redeem Your Points for Items</p>
                        </div>
                    </div>
                </div>
                <!-- Points Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Total Points -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-md">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium mb-1">Total Points</p>
                                <p class="text-2xl font-bold text-blue-700">${pointsRemaining}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Available Points -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-green-500 to-green-600 shadow-md">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium mb-1">Available Points</p>
                                <p class="text-2xl font-bold text-green-700">${availablePoints}</p>
                                <p class="text-xs text-green-500 mt-1">Ready to redeem</p>
                            </div>
                        </div>
                    </div>

                    <!-- Reserved Points -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-yellow-500 to-orange-500 shadow-md">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium mb-1">Reserved Points</p>
                                <p class="text-2xl font-bold text-yellow-700">${reservedPoints}</p>
                                <p class="text-xs text-orange-500 mt-1">Pending approval</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20 space-y-10">
                    <!-- Points Summary Card -->
                    <div class="bg-white rounded-3xl p-6 text-center border border-gray-200 shadow-inner">
                        <p class="text-base text-gray-600 font-medium mb-2">Selected Points Total</p>
                        <div id="totalPoints" class="text-5xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            0
                        </div>
                        <div id="redeemStatus" class="text-sm mt-3 text-gray-500"></div>
                    </div>

                    <!-- Section Title -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-800">Available Items</h2>
                    </div>

                    <!-- Redemption Form -->
                    <form id="redemptionForm" class="space-y-8">
                        <!-- Items Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            ${itemsHtml}
                        </div>

                        <!-- Info Note -->
                        <div class="text-center px-4">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Choose items to redeem with your points. You must leave at least
                                <span class="font-semibold text-gray-800">10 points</span>.
                            </p>
                            <p class="text-sm text-orange-600 mt-2 font-medium">
                                ${reservedPoints} points are currently reserved for pending requests.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button
                                type="submit"
                                id="redeemBtn"
                                disabled
                                class="w-full py-4 px-6 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-pink-700 text-white font-semibold text-base rounded-2xl shadow-md hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane text-lg"></i>
                                <span>Submit Item Redemption Request</span>
                            </button>
                        </div>
                    </form>
                </div>
            `;

            // Add the item redemption form logic
            setTimeout(() => {
                const checkboxes = document.querySelectorAll('.item-checkbox');
                const totalPointsEl = document.getElementById('totalPoints');
                const redeemBtn = document.getElementById('redeemBtn');
                const redeemStatus = document.getElementById('redeemStatus');
                const minPointsToLeave = 10;

                function updateTotal() {
                    let total = 0;

                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            total += parseInt(cb.dataset.points);
                        }
                    });

                    totalPointsEl.textContent = total;

                    if (total > 0 && (availablePoints - total) >= minPointsToLeave) {
                        redeemBtn.disabled = false;
                        redeemStatus.textContent = '';
                    } else if (total > 0 && (availablePoints - total) < minPointsToLeave) {
                        redeemBtn.disabled = true;
                        redeemStatus.innerHTML = `<span class="text-red-600">You must leave at least ${minPointsToLeave} points. You can redeem up to ${availablePoints - minPointsToLeave} points worth of items.</span>`;
                    } else {
                        redeemBtn.disabled = true;
                        redeemStatus.textContent = '';
                    }
                }

                // Checkbox event handlers
                checkboxes.forEach(checkbox => {
                    // Handle direct clicks on checkbox
                    checkbox.addEventListener('click', function(e) {
                        e.stopPropagation();
                        // Ensure the checkbox state is updated properly
                        setTimeout(() => {
                            updateTotal();
                        }, 10);
                    });

                    // Handle change events
                    checkbox.addEventListener('change', function(e) {
                        updateTotal();
                    });

                    // Reset checkbox state
                    checkbox.checked = false;
                });

                updateTotal();

                // Item redemption form submission
                document.getElementById('redemptionForm').addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const selectedItems = [];
                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            selectedItems.push(cb.value);
                        }
                    });

                    if (selectedItems.length === 0) {
                        redeemStatus.innerHTML = '<span class="text-red-600">Please select at least one item</span>';
                        return;
                    }

                    redeemBtn.disabled = true;
                    redeemBtn.textContent = 'Processing...';

                    try {
                        const response = await fetch(`/api/guides/${guideId}/redeem`, {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                item_ids: selectedItems
                            })
                        });

                        const data = await response.json();

                        if (response.ok) {
                            alert('Item redemption request submitted successfully! Please wait for admin approval.');
                            // Reset form and refresh
                            checkboxes.forEach(cb => cb.checked = false);
                            updateTotal();
                            fetchGuideDashboard(); // Refresh dashboard data
                        } else {
                            redeemStatus.innerHTML = `<span class="text-red-600">${data.message}</span>`;
                        }
                    } catch (error) {
                        console.error('Redemption error:', error);
                        redeemStatus.innerHTML = '<span class="text-red-600">Network error. Please try again.</span>';
                    } finally {
                        redeemBtn.disabled = false;
                        redeemBtn.textContent = 'Submit Item Redemption Request';
                    }
                });
            }, 300);
        }

        // Add the toggleCheckbox function
        function toggleCheckbox(itemId) {
            const checkbox = document.getElementById(itemId);
            if (checkbox && !checkbox.disabled) {
                checkbox.checked = !checkbox.checked;
                // Trigger change event to update totals
                checkbox.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }

        function renderProfileUpdateSection(guide) {
            document.getElementById('profileUpdateSection').innerHTML = `
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20 space-y-10">
            <!-- Heading -->
            <div class="text-center space-y-2">
                <h2 class="text-2xl font-bold text-gray-800 flex justify-center items-center gap-3">
                    <i class="fa-solid fa-edit text-indigo-600 text-xl"></i> Update Profile
                </h2>
                <div class="w-20 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full"></div>
                <p class="text-sm text-gray-600">Keep your profile information up to date</p>
            </div>

            <!-- Form Container -->
            <div class="max-w-3xl mx-auto space-y-10">
                <!-- Profile Photo -->
                <div class="flex flex-col items-center gap-4">
                    <div class="relative group">
                        <img id="profilePhotoPreview" src="/storage/${guide.profile_photo || ''}"
                            class="w-36 h-36 rounded-full object-cover border-4 border-gray-200 shadow-lg group-hover:shadow-xl transition-all duration-300"
                            alt="Profile">
                        <label class="absolute bottom-2 right-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full p-3 cursor-pointer shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-110">
                            <input type="file" id="profile_photo" accept="image/*" class="hidden">
                            <i class="fa-solid fa-camera text-base"></i>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 text-center">Click the camera icon to change your profile photo</p>
                </div>

                <!-- Input Fields -->
                <div class="space-y-6">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fa-solid fa-user text-indigo-600 mr-1"></i> Full Name
                        </label>
                        <input type="text" id="full_name"
                            class="w-full px-5 py-3 border border-gray-300 rounded-xl text-base focus:border-indigo-500 focus:ring-0 transition-all shadow-sm"
                            value="${guide.full_name}" placeholder="Enter your full name">
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-envelope text-gray-400 mr-1"></i> Email Address
                            </label>
                            <input type="email"
                                class="w-full px-5 py-3 border border-gray-200 bg-gray-50 text-gray-500 rounded-xl text-sm cursor-not-allowed"
                                value="${guide.email}" disabled>
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <i class="fa-solid fa-lock text-xs"></i> Email cannot be changed
                            </p>
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-phone text-gray-400 mr-1"></i> Mobile Number
                            </label>
                            <input type="text"
                                class="w-full px-5 py-3 border border-gray-200 bg-gray-50 text-gray-500 rounded-xl text-sm cursor-not-allowed"
                                value="${guide.mobile_number}" disabled>
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <i class="fa-solid fa-shield-alt text-xs"></i> Contact admin to update
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col items-center gap-5 pt-4">
                    <button id="updateProfileBtn"
                            class="group relative w-full lg:w-auto bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-4 px-10 rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                        <span id="updateBtnText" class="flex items-center gap-2">
                            <i class="fa-solid fa-save text-base"></i> Update Profile
                        </span>
                        <svg id="updateSpinner" class="hidden animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                    </button>
                    <div id="updateStatus" class="text-sm text-gray-600 text-center"></div>
                </div>
            </div>
        </div>

        `;

            // Profile photo preview
            const profilePhotoInput = document.getElementById('profile_photo');
            const profilePhotoPreview = document.getElementById('profilePhotoPreview');
            profilePhotoInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        profilePhotoPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            document.getElementById('updateProfileBtn').addEventListener('click', async function () {
                const updateStatus = document.getElementById('updateStatus');
                const updateBtnText = document.getElementById('updateBtnText');
                const updateSpinner = document.getElementById('updateSpinner');

                updateStatus.textContent = '';
                updateBtnText.textContent = 'Updating...';
                updateSpinner.classList.remove('hidden');

                const name = document.getElementById('full_name').value;
                const photoFile = profilePhotoInput.files[0];

                const formData = new FormData();
                formData.append('full_name', name);
                if (photoFile) formData.append('profile_photo', photoFile);
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

                    const result = await response.json();
                    updateBtnText.textContent = 'Update';
                    updateSpinner.classList.add('hidden');

                    if (!response.ok) {
                        updateStatus.innerHTML = `<span class="text-red-600">${result.message || 'Failed to update profile.'}</span>`;
                        return;
                    }
                    updateStatus.innerHTML = `<span class="text-green-600 font-semibold">Profile updated successfully!</span>`;
                } catch (err) {
                    updateBtnText.textContent = 'Update';
                    updateSpinner.classList.add('hidden');
                    updateStatus.innerHTML = `<span class="text-red-600">Network error.</span>`;
                }
            });
        }

        function renderRedeemCashSection(guide, redemption) {
        // Use proper redemption data
        const pointsRemaining = redemption ? redemption.points : guide.earned_points || 0;
        const reservedPoints = redemption ? (redemption.reserved_points || 0) : 0;
        const availablePoints = (pointsRemaining - reservedPoints || 0);


        document.getElementById('redeemCashSection').innerHTML = `
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20 mb-8">
                <div class="flex items-center gap-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold gradient-text mb-1">Redeem Cash</h2>
                        <p class="text-gray-600 text-base">Convert Your Points into Cash</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-md">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Total Points</p>
                            <p class="text-2xl font-bold text-blue-700">${pointsRemaining}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-green-500 to-green-600 shadow-md">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Available for Cash</p>
                            <p class="text-2xl font-bold text-green-700">${availablePoints}</p>
                            <p class="text-xs text-green-500 mt-1">1 Point = Rs. 1</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-xl bg-gradient-to-br from-yellow-500 to-orange-500 shadow-md">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Reserved Points</p>
                            <p class="text-2xl font-bold text-yellow-700">${reservedPoints}</p>
                            <p class="text-xs text-orange-500 mt-1">Pending approval</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg border border-white/20 space-y-10">
                <!-- Header -->
                <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    Convert Points to Cash
                </h3>

                <!-- Form -->
                <form id="redeemCashForm" class="space-y-8">

                    <!-- Input -->
                    <div>
                        <label for="cashAmount" class="block text-sm font-semibold text-gray-700 mb-2">
                            Enter Amount to Redeem (Rs.)
                        </label>
                        <input
                            type="number"
                            id="cashAmount"
                            name="cashAmount"
                            min="5000"
                            max="${availablePoints}"
                            class="w-full px-5 py-3 border border-gray-300 rounded-xl text-base bg-white focus:border-green-500 focus:ring-0 transition-all duration-200 shadow-sm"
                            placeholder="Max: Rs. ${availablePoints}"
                            ${availablePoints <= 0 ? 'disabled' : ''}
                            required>

                        <p class="text-sm text-gray-600 mt-3 p-4 bg-white/60 rounded-xl leading-relaxed">
                            <i class="fa-solid fa-info-circle text-blue-500 mr-2"></i>
                            <strong>Available:</strong> Rs. ${availablePoints.toLocaleString()}
                            ${reservedPoints > 0 ? `<br><span class="text-orange-600">(${reservedPoints} points reserved)</span>` : ''}
                        </p>
                    </div>

                    <!-- Info Panel -->
                    <div class="bg-white/80 rounded-xl p-5 border-l-4 border-yellow-500 shadow-sm space-y-3">
                        <h4 class="font-semibold text-gray-800 flex items-center text-base">
                            <i class="fa-solid fa-exclamation-triangle text-yellow-500 mr-2"></i>
                            Important Information
                        </h4>
                        <ul class="text-sm text-gray-700 space-y-1.5">
                            <li class="flex items-start"><i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i> Requires admin approval</li>
                            <li class="flex items-start"><i class="fa-solid fa-clock text-blue-500 mr-2 mt-1"></i> Processed in 24–48 hours</li>
                            <li class="flex items-start"><i class="fa-solid fa-shield-alt text-purple-500 mr-2 mt-1"></i> Points held during review</li>
                            <li class="flex items-start"><i class="fa-brands fa-whatsapp text-green-500 mr-2 mt-1"></i> WhatsApp updates enabled</li>
                        </ul>
                    </div>

                    <!-- Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="redeemCashBtn"
                            ${availablePoints <= 0 ? 'disabled' : ''}
                            class="w-full py-4 px-6 bg-gradient-to-r from-green-600 via-green-500 to-green-400 hover:from-green-700 hover:to-emerald-600 text-white font-semibold text-base rounded-2xl shadow-md hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane text-lg"></i>
                            <span id="redeemCashBtnText">${availablePoints <= 0 ? 'No Points Available' : 'Submit Redemption Request'}</span>
                            <svg id="redeemCashSpinner" class="hidden animate-spin h-5 w-5 text-white ml-2" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                        </button>
                        <div id="redeemCashStatus" class="text-sm text-center text-gray-600 mt-3"></div>
                    </div>
                </form>
            </div>
        `;

        // Handle cash redemption form submission
        document.getElementById('redeemCashForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const redeemCashBtn = document.getElementById('redeemCashBtn');
            const redeemCashBtnText = document.getElementById('redeemCashBtnText');
            const redeemCashSpinner = document.getElementById('redeemCashSpinner');
            const redeemCashStatus = document.getElementById('redeemCashStatus');
            const cashAmountInput = document.getElementById('cashAmount');

            const amount = parseInt(cashAmountInput.value);

            // Validation
            if (!amount || amount < 1) {
                redeemCashStatus.innerHTML = '<span class="text-red-600">Please enter a valid amount (minimum Rs. 1)</span>';
                return;
            }

            if (amount > availablePoints) {
                redeemCashStatus.innerHTML = '<span class="text-red-600">Amount exceeds available points</span>';
                return;
            }

            // Disable button and show loading
            redeemCashBtn.disabled = true;
            redeemCashBtnText.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
            redeemCashSpinner.classList.remove('hidden');
            redeemCashStatus.textContent = '';

            try {
                const response = await fetch(`/api/guides/${guideId}/redeem-cash`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: amount
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    // Success
                    redeemCashStatus.innerHTML = '<span class="text-green-600 font-semibold">Cash redemption request submitted successfully! Points have been reserved pending admin approval.</span>';
                    cashAmountInput.value = '';

                    // Refresh dashboard after 2 seconds to update points
                    setTimeout(() => {
                        fetchGuideDashboard();
                    }, 2000);

                } else {
                    redeemCashStatus.innerHTML = `<span class="text-red-600">${result.message || 'Cash redemption failed'}</span>`;
                }

            } catch (error) {
                console.error('Cash redemption error:', error);
                redeemCashStatus.innerHTML = '<span class="text-red-600">Network error. Please try again.</span>';
            } finally {
                // Reset button state
                redeemCashBtn.disabled = false;
                redeemCashBtnText.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit Cash Redemption Request';
                redeemCashSpinner.classList.add('hidden');
            }
        });
    }
    </script>
</body>

</html>
