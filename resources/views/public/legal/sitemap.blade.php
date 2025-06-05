{{-- resources/views/public/legal/sitemap.blade.php --}}
@extends('layouts.app')

@section('title', 'Sitemap - CDF Portal Zambia')
@section('description', 'Complete sitemap of the CDF portal. Find all pages and sections of our website quickly and easily.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-16 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">
                Site
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Map
                </span>
            </h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Find all pages and sections of the CDF portal quickly and easily. Navigate to any part of our website from this comprehensive sitemap.
            </p>
        </div>
    </div>
</section>

<!-- Professional Sitemap Content -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Navigation -->
        <div class="mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-zambian-black mb-8 flex items-center">
                <span class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-home text-green-600 text-xl"></i>
                </span>
                Main Pages
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-home text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Homepage</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Main landing page with project statistics and featured content</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold">
                        Visit Page <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">About Us</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Learn about CDF, our mission, and impact on communities</p>
                    <a href="{{ route('about') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold">
                        Visit Page <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Apply Now</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Submit your application for CDF funding and support</p>
                    <a href="{{ route('apply') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold">
                        Visit Page <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Project Gallery</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Browse completed projects and success stories</p>
                    <a href="{{ route('gallery') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold">
                        Visit Page <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Contact Us</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Get in touch with our team for support and inquiries</p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold">
                        Visit Page <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-search text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Check Status</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Track the status of your submitted applications</p>
                    <a href="{{ route('status.check') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold">
                        Visit Page <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Project Categories -->
        <div class="mb-12" data-aos="fade-up" data-aos-delay="200">
            <h2 class="text-3xl font-bold text-zambian-black mb-8 flex items-center">
                <span class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-project-diagram text-orange-600 text-xl"></i>
                </span>
                Project Categories
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-road text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Infrastructure</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Roads, bridges, buildings, and community infrastructure projects</p>
                    <a href="{{ route('projects.infrastructure') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold">
                        View Projects <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Education</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Schools, libraries, educational facilities and learning programs</p>
                    <a href="{{ route('projects.education') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold">
                        View Projects <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-heartbeat text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Health</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Clinics, health centers, medical equipment and health programs</p>
                    <a href="{{ route('projects.health') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-semibold">
                        View Projects <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-tint text-cyan-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Water & Sanitation</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Water wells, sanitation facilities, and hygiene programs</p>
                    <a href="{{ route('projects.water') }}" class="inline-flex items-center text-cyan-600 hover:text-cyan-700 font-semibold">
                        View Projects <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-seedling text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Agriculture</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Farming support, equipment, training and agricultural development</p>
                    <a href="{{ route('projects.agriculture') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold">
                        View Projects <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-users text-yellow-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-zambian-black">Youth Development</h3>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">Youth programs, skills training, and empowerment initiatives</p>
                    <a href="{{ route('projects.youth') }}" class="inline-flex items-center text-yellow-600 hover:text-yellow-700 font-semibold">
                        View Projects <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Legal and Support -->
        <div class="mb-12" data-aos="fade-up" data-aos-delay="400">
            <h2 class="text-3xl font-bold text-zambian-black mb-8 flex items-center">
                <span class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-gavel text-green-600 text-xl"></i>
                </span>
                Legal & Support
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-2">Privacy Policy</h3>
                    <p class="text-gray-700 text-sm mb-4">How we protect and use your personal information</p>
                    <a href="{{ route('privacy') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold">
                        Read Policy <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-file-contract text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-2">Terms & Conditions</h3>
                    <p class="text-gray-700 text-sm mb-4">Rules and guidelines for using our portal</p>
                    <a href="{{ route('terms') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold">
                        Read Terms <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-universal-access text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-2">Accessibility</h3>
                    <p class="text-gray-700 text-sm mb-4">Our commitment to accessible web experiences</p>
                    <a href="{{ route('accessibility') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-sitemap text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-2">Sitemap</h3>
                    <p class="text-gray-700 text-sm mb-4">Complete navigation map of our website</p>
                    <span class="inline-flex items-center text-orange-600 font-semibold">
                        Current Page <i class="fas fa-check ml-2"></i>
                    </span>
                </div>
            </div>
        </div>

        <!-- API and Technical -->
        <div class="mb-12" data-aos="fade-up" data-aos-delay="600">
            <h2 class="text-3xl font-bold text-zambian-black mb-8 flex items-center">
                <span class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-cogs text-orange-600 text-xl"></i>
                </span>
                Technical & API
            </h2>

            <div class="bg-gray-50 rounded-2xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-code text-green-500 mr-2"></i>API Endpoints
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                <span class="text-gray-700">Ward Lookup</span>
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded">/api/wards</code>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                <span class="text-gray-700">Application Submit</span>
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded">/api/applications</code>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                <span class="text-gray-700">Status Search</span>
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded">/api/status/search</code>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                <span class="text-gray-700">SMS Service</span>
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded">/api/send-sms</code>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-tools text-orange-500 mr-2"></i>Additional Features
                        </h3>
                        <div class="space-y-3">
                            <div class="p-3 bg-white rounded-lg border">
                                <h4 class="font-semibold text-gray-800">Newsletter Subscription</h4>
                                <p class="text-gray-600 text-sm">Stay updated with CDF news and opportunities</p>
                            </div>
                            <div class="p-3 bg-white rounded-lg border">
                                <h4 class="font-semibold text-gray-800">Application Tracking</h4>
                                <p class="text-gray-600 text-sm">Real-time status updates for submissions</p>
                            </div>
                            <div class="p-3 bg-white rounded-lg border">
                                <h4 class="font-semibold text-gray-800">Document Upload</h4>
                                <p class="text-gray-600 text-sm">Secure file upload for application materials</p>
                            </div>
                            <div class="p-3 bg-white rounded-lg border">
                                <h4 class="font-semibold text-gray-800">SMS Notifications</h4>
                                <p class="text-gray-600 text-sm">Mobile updates for application progress</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="text-center" data-aos="fade-up" data-aos-delay="800">
            <div class="bg-gradient-to-r from-green-500 to-orange-500 rounded-2xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-4">Need Help Finding Something?</h3>
                <p class="mb-6 opacity-90">
                    Can't find what you're looking for? Our support team is here to help you navigate the portal.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-green-600 rounded-xl font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-envelope mr-2"></i>Contact Support
                    </a>
                    <a href="{{ route('apply') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white/20 text-white rounded-xl font-semibold hover:bg-white/30 transition-colors">
                        <i class="fas fa-file-alt mr-2"></i>Start Application
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
