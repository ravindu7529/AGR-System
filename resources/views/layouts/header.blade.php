<header class="w-full bg-white/90 fixed shadow-md py-4 px-8 flex items-center justify-between mb-8 z-50">
    <div class="flex items-center gap-3">
        <img src="{{ asset('storage/appImages/logo.png') }}" alt="Logo">
    </div>
    <div class="flex items-center gap-4">
        <a href="/admin/dashboard" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="https://instagram.com/yourprofile" target="_blank" class="bg-gradient-to-tr from-pink-500 via-red-500 to-yellow-500 text-white px-4 py-2 rounded-lg font-semibold shadow transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5zm5.25.75a1 1 0 1 1 0 2h-1.5a1 1 0 0 1 0-2h1.5z"/>
            </svg>
            Instagram
        </a>
        <div>
            <button onclick="logout()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold shadow transition">
                Logout
            </button>
        </div>
        <script>
        function logout() {
            if (!confirm('Are you sure you want to logout?')) return;
            localStorage.removeItem('admin_token');
            window.location.href = '/admin/login'; // or your login route
        }
        </script>
    </div>
</header>
