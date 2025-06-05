{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CDF Management Portal - Empowering Communities')</title>
    <meta name="description" content="@yield('description', 'Constituency Development Fund Management Portal - Apply for community projects, track applications, and build better communities together.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Zambian Flag Inspired Color Variables */
        :root {
            --zambian-green: #00A651;
            --zambian-orange: #FF8200;
            --zambian-red: #DE2910;
            --zambian-black: #1F2937;
            --zambian-dark-green: #008A44;
            --zambian-light-green: #4ADE80;
        }

        /* Custom Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(3deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(0, 166, 81, 0.3); }
            50% { box-shadow: 0 0 40px rgba(0, 166, 81, 0.6); }
        }

        @keyframes shimmer {
            0% { background-position: -200px 0; }
            100% { background-position: calc(200px + 100%) 0; }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            background-size: 200px 100%;
            animation: shimmer 2s infinite;
        }

        /* Professional Zambian Flag Gradients */
        .gradient-primary {
            background: linear-gradient(135deg, var(--zambian-green) 0%, var(--zambian-dark-green) 100%);
        }

        .gradient-secondary {
            background: linear-gradient(135deg, var(--zambian-orange) 0%, #FF9500 100%);
        }

        .gradient-hero {
            background: linear-gradient(135deg,
                var(--zambian-dark-green) 0%,
                var(--zambian-green) 35%,
                var(--zambian-black) 100%);
        }

        .gradient-success {
            background: linear-gradient(135deg, var(--zambian-green) 0%, var(--zambian-light-green) 100%);
        }

        .gradient-accent {
            background: linear-gradient(135deg, var(--zambian-orange) 0%, #FFB347 100%);
        }

        .gradient-professional {
            background: linear-gradient(135deg,
                var(--zambian-black) 0%,
                #374151 50%,
                var(--zambian-dark-green) 100%);
        }

        /* Glass Morphism with Green Tints */
        .glass {
            background: rgba(0, 166, 81, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 166, 81, 0.2);
        }

        .glass-orange {
            background: rgba(255, 130, 0, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 130, 0, 0.2);
        }

        /* Professional Text Colors */
        .text-zambian-green {
            color: var(--zambian-green);
        }

        .text-zambian-orange {
            color: var(--zambian-orange);
        }

        .text-zambian-red {
            color: var(--zambian-red);
        }

        .text-zambian-black {
            color: var(--zambian-black);
        }

        /* Professional Buttons */
        .btn-zambian-primary {
            background: var(--zambian-green);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-zambian-primary:hover {
            background: var(--zambian-dark-green);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 166, 81, 0.3);
        }

        .btn-zambian-secondary {
            background: var(--zambian-orange);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-zambian-secondary:hover {
            background: #FF9500;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 130, 0, 0.3);
        }

        /* Professional Cards */
        .card-zambian {
            background: white;
            border: 1px solid rgba(0, 166, 81, 0.1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 2px 4px rgba(0, 166, 81, 0.1);
            transition: all 0.3s ease;
        }

        .card-zambian:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 4px 8px rgba(0, 166, 81, 0.2);
        }

        /* Scroll Behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Professional Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--zambian-green) 0%, var(--zambian-dark-green) 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--zambian-dark-green) 0%, var(--zambian-green) 100%);
        }

        /* Professional Status Colors */
        .status-success { color: var(--zambian-green); }
        .status-warning { color: var(--zambian-orange); }
        .status-danger { color: var(--zambian-red); }
        .status-info { color: var(--zambian-black); }

        .bg-status-success { background-color: rgba(0, 166, 81, 0.1); }
        .bg-status-warning { background-color: rgba(255, 130, 0, 0.1); }
        .bg-status-danger { background-color: rgba(222, 41, 16, 0.1); }
        .bg-status-info { background-color: rgba(31, 41, 55, 0.1); }

        /* Professional Navigation */
        .nav-professional {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 166, 81, 0.1);
        }

        /* Elegant Hover Effects */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Professional Form Elements */
        .form-zambian input:focus,
        .form-zambian select:focus,
        .form-zambian textarea:focus {
            border-color: var(--zambian-green);
            box-shadow: 0 0 0 3px rgba(0, 166, 81, 0.1);
        }

        /* Professional Badges */
        .badge-zambian-primary {
            background: var(--zambian-green);
            color: white;
        }

        .badge-zambian-secondary {
            background: var(--zambian-orange);
            color: white;
        }

        .badge-zambian-accent {
            background: rgba(0, 166, 81, 0.1);
            color: var(--zambian-green);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">
    <!-- Navigation -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS with professional settings
        AOS.init({
            duration: 1200,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');

            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // Professional navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('nav-professional', 'shadow-lg');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.remove('nav-professional', 'shadow-lg');
                navbar.classList.add('bg-transparent');
            }
        });

        // Add professional loading animation
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });
    </script>

    @stack('scripts')
</body>
</html>
