<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Athreya Ayurveda Ashram</title>
  @vite(['resources/css/app.css'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/sageffine" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .hero-gradient {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
    }
    .card-hover {
      transition: all 0.3s ease;
    }
    .card-hover:hover {
      transform: translateY(-8px);
    }
    .floating-animation {
      animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }
    .pulse-slow {
      animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .bg-pattern {
      background-image: 
        radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(101, 163, 13, 0.1) 0%, transparent 50%);
    }
  </style>
</head>
<body class="min-h-screen flex flex-col bg-gray-50">
  <main class="flex-1 relative overflow-hidden">
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-16 lg:py-24">

      <!-- Hero Section -->
      <div class="text-center mb-16">
        <div class="inline-block mb-6">
          <span class="bg-gradient-to-r from-green-600 to-green-300 bg-clip-text text-transparent text-sm font-semibold tracking-wide uppercase">
            Welcome to
          </span>
        </div>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight" style="font-family: 'Sageffine', serif;">
          <span class="bg-gradient-to-r from-green-700 via-green-600 to-green-400 bg-clip-text text-transparent">
            Athreya Ayurveda
          </span><br>
          <span class="text-gray-800">Ashram</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
          Experience authentic Ayurvedic healing and wellness in a serene environment. 
          <span class="text-green-600 font-semibold">Choose your portal below</span> to begin your journey.
        </p>
      </div>

      <!-- Portal Cards -->
      <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <!-- Admin Portal -->
        <a href="{{url('/admin/login')}}" class="group card-hover bg-white rounded-3xl p-8 shadow-xl border border-gray-100 overflow-hidden block">
          <div class="relative z-10">
            <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-300 rounded-2xl mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
              <i class="fas fa-user-shield text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Admin Portal</h3>
            <p class="text-gray-600 mb-6 leading-relaxed">
              Manage ashram operations, oversee guide activities, and maintain system configurations with comprehensive administrative tools.
            </p>
            <div class="flex items-center text-green-600 font-semibold group-hover:text-green-700 transition-colors">
              <span>Access Admin Panel</span>
              <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </div>
          </div>
        </a>

        <!-- Guide Portal -->
        <a href="{{url('/guide/login')}}" class="group card-hover bg-white rounded-3xl p-8 shadow-xl border border-gray-100 overflow-hidden block">
          <div class="relative z-10">
            <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
              <i class="fas fa-user-tie text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Guide Portal</h3>
            <p class="text-gray-600 mb-6 leading-relaxed">
              Access your personalized dashboard, view your profile, track points, and redeem rewards through our guide management system.
            </p>
            <div class="flex items-center text-amber-600 font-semibold group-hover:text-amber-700 transition-colors">
              <span>Access Guide Panel</span>
              <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </div>
          </div>
        </a>
      </div>

      <!-- Features Section -->
      <div class="mt-20 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-12">Why Choose Athreya?</h2>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
          <div class="group">
            <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl mb-4 mx-auto group-hover:scale-110 transition-transform">
              <i class="fas fa-leaf text-2xl text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Authentic Ayurveda</h3>
            <p class="text-gray-600">Traditional healing practices passed down through generations</p>
          </div>
          <div class="group">
            <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl mb-4 mx-auto group-hover:scale-110 transition-transform">
              <i class="fas fa-users text-2xl text-blue-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Expert Guidance</h3>
            <p class="text-gray-600">Experienced practitioners dedicated to your wellness journey</p>
          </div>
          <div class="group">
            <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl mb-4 mx-auto group-hover:scale-110 transition-transform">
              <i class="fas fa-spa text-2xl text-purple-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Holistic Wellness</h3>
            <p class="text-gray-600">Complete mind, body, and spirit rejuvenation programs</p>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- Footer -->
  <footer class="relative z-10 bg-white/80 backdrop-blur-sm border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-6 text-center">
      <p class="text-sm text-gray-600">
        &copy; 2025 Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd. All rights reserved.
      </p>
      <div class="mt-2 flex items-center justify-center gap-4 text-xs text-gray-500">
        <a href="{{url('#')}}" class="hover:text-green-600 transition-colors">Privacy Policy</a>
        <span>•</span>
        <a href="{{url('#')}}" class="hover:text-green-600 transition-colors">Terms of Service</a>
        <span>•</span>
        <a href="{{url('#')}}" class="hover:text-green-600 transition-colors">Admin Support</a>
      </div>
    </div>
  </footer>
</body>
</html>