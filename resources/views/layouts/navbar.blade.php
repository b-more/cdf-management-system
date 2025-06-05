{{-- resources/views/layouts/navbar.blade.php --}}
<nav id="navbar" class="fixed w-full z-50 transition-all duration-300 bg-transparent" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Professional Logo with Zambian Colors -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-500 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-zambian-black">CDF Portal</h1>
                        <p class="text-xs text-gray-600">Empowering Communities</p>
                    </div>
                </a>
            </div>

            <!-- Professional Desktop Navigation with Zambian Colors -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-6">
                    <a href="{{ route('home') }}"
                       class="nav-link {{ request()->routeIs('home') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-3 py-2 text-sm font-medium transition-all duration-200 flex items-center whitespace-nowrap">
                        <i class="fas fa-home mr-2 flex-shrink-0"></i>Home
                    </a>

                    <a href="{{ route('about') }}"
                       class="nav-link {{ request()->routeIs('about') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-3 py-2 text-sm font-medium transition-all duration-200 flex items-center whitespace-nowrap">
                        <i class="fas fa-info-circle mr-2 flex-shrink-0"></i>About Us
                    </a>

                    <a href="{{ route('apply') }}"
                       class="nav-link {{ request()->routeIs('apply') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-3 py-2 text-sm font-medium transition-all duration-200 flex items-center whitespace-nowrap">
                        <i class="fas fa-file-alt mr-2 flex-shrink-0"></i>Apply Now
                    </a>

                    <!-- Professional Projects Dropdown with Zambian Colors -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="nav-link text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-all duration-200 flex items-center whitespace-nowrap">
                            <i class="fas fa-th-large mr-2 flex-shrink-0"></i>Projects
                            <i class="fas fa-chevron-down ml-1 text-xs flex-shrink-0" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             @click.outside="open = false"
                             class="absolute left-0 mt-2 w-64 bg-white rounded-xl shadow-lg py-2 z-10 border border-gray-100">

                            <a href="{{ route('gallery') }}"
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
                                <i class="fas fa-images mr-3 text-green-500"></i>Project Gallery
                            </a>

                            <a href="{{ route('projects.infrastructure') }}"
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200">
                                <i class="fas fa-road mr-3 text-orange-500"></i>Infrastructure
                            </a>

                            <a href="{{ route('projects.education') }}"
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
                                <i class="fas fa-graduation-cap mr-3 text-green-500"></i>Education
                            </a>

                            <a href="{{ route('projects.health') }}"
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                <i class="fas fa-heartbeat mr-3 text-red-500"></i>Healthcare
                            </a>

                            <a href="{{ route('projects.water') }}"
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-tint mr-3 text-blue-500"></i>Water & Sanitation
                            </a>

                            <a href="{{ route('projects.agriculture') }}"
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
                                <i class="fas fa-seedling mr-3 text-green-500"></i>Agriculture
                            </a>

                            <a href="{{ route('projects.youth') }}"
                               class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200">
                                <i class="fas fa-rocket mr-3 text-orange-500"></i>Youth Development
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}"
                       class="nav-link {{ request()->routeIs('contact') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-3 py-2 text-sm font-medium transition-all duration-200 flex items-center whitespace-nowrap">
                        <i class="fas fa-envelope mr-2 flex-shrink-0"></i>Contact
                    </a>
                </div>
            </div>

            <!-- Professional CTA Buttons with Zambian Colors -->
            <div class="hidden md:flex items-center space-x-3">
                <a href="{{ route('apply') }}"
                   class="btn-zambian-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-200 whitespace-nowrap">
                    Apply Now
                </a>

                <a href="{{ route('status.check') }}"
                   class="border-2 border-orange-600 text-orange-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 hover:text-white transition-all duration-200 whitespace-nowrap">
                    Check Status
                </a>

                <!-- Professional Admin Login Button -->
                <a href="/admin/login"
                   class="border-2 border-zambian-black text-zambian-black px-3 py-2 rounded-lg text-sm font-medium hover:bg-zambian-black hover:text-white transition-all duration-200 flex items-center whitespace-nowrap">
                    <i class="fas fa-user-shield mr-1 flex-shrink-0"></i>Admin
                </a>
            </div>

            <!-- Professional Mobile menu button -->
            <div class="md:hidden">
                <button @click="open = !open"
                        id="mobile-menu-button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-green-600 hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-bars text-xl" x-show="!open"></i>
                    <i class="fas fa-times text-xl" x-show="open"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Professional Mobile Navigation Menu with Zambian Colors -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         id="mobile-menu"
         class="md:hidden bg-white/95 backdrop-blur-md border-t border-gray-200">

        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
               class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-green-600 bg-green-50' : 'text-gray-700 hover:text-green-600 hover:bg-gray-50' }} transition-all duration-200">
                <i class="fas fa-home mr-3"></i>Home
            </a>

            <a href="{{ route('about') }}"
               class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'text-green-600 bg-green-50' : 'text-gray-700 hover:text-green-600 hover:bg-gray-50' }} transition-all duration-200">
                <i class="fas fa-info-circle mr-3"></i>About Us
            </a>

            <a href="{{ route('apply') }}"
               class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('apply') ? 'text-green-600 bg-green-50' : 'text-gray-700 hover:text-green-600 hover:bg-gray-50' }} transition-all duration-200">
                <i class="fas fa-file-alt mr-3"></i>Apply Now
            </a>

            <a href="{{ route('gallery') }}"
               class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('gallery') ? 'text-green-600 bg-green-50' : 'text-gray-700 hover:text-green-600 hover:bg-gray-50' }} transition-all duration-200">
                <i class="fas fa-images mr-3"></i>Project Gallery
            </a>

            <!-- Professional Mobile Projects Submenu -->
            <div class="ml-4 space-y-1 border-l-2 border-green-200 pl-4">
                <a href="{{ route('projects.infrastructure') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200">
                    <i class="fas fa-road mr-3 text-orange-500"></i>Infrastructure
                </a>

                <a href="{{ route('projects.education') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 transition-all duration-200">
                    <i class="fas fa-graduation-cap mr-3 text-green-500"></i>Education
                </a>

                <a href="{{ route('projects.health') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all duration-200">
                    <i class="fas fa-heartbeat mr-3 text-red-500"></i>Healthcare
                </a>

                <a href="{{ route('projects.water') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                    <i class="fas fa-tint mr-3 text-blue-500"></i>Water & Sanitation
                </a>

                <a href="{{ route('projects.agriculture') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-green-50 transition-all duration-200">
                    <i class="fas fa-seedling mr-3 text-green-500"></i>Agriculture
                </a>

                <a href="{{ route('projects.youth') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200">
                    <i class="fas fa-rocket mr-3 text-orange-500"></i>Youth Development
                </a>
            </div>

            <a href="{{ route('contact') }}"
               class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'text-green-600 bg-green-50' : 'text-gray-700 hover:text-green-600 hover:bg-gray-50' }} transition-all duration-200">
                <i class="fas fa-envelope mr-3"></i>Contact
            </a>
        </div>

        <!-- Professional Mobile CTA Buttons with Zambian Colors -->
        <div class="px-4 py-3 border-t border-gray-200 space-y-2">
            <a href="{{ route('apply') }}"
               class="block w-full text-center btn-zambian-primary text-white py-3 rounded-lg font-medium transition-all duration-200">
                Apply for Project
            </a>

            <a href="{{ route('status.check') }}"
               class="block w-full text-center border-2 border-orange-600 text-orange-600 py-3 rounded-lg font-medium hover:bg-orange-600 hover:text-white transition-all duration-200">
                Check Application Status
            </a>

            <!-- Professional Mobile Admin Login -->
            <a href="/admin/login"
               class="block w-full text-center border-2 border-zambian-black text-zambian-black py-3 rounded-lg font-medium hover:bg-zambian-black hover:text-white transition-all duration-200 flex items-center justify-center">
                <i class="fas fa-user-shield mr-2"></i>Admin Login
            </a>
        </div>
    </div>
</nav>

<!-- Spacer for fixed navbar -->
<div class="h-16"></div>
