{{-- resources/views/public/index.blade.php --}}
@extends('layouts.app')

@section('title', 'CDF Management Portal - Empowering Communities Through Development')
@section('description', 'Apply for community development projects, track applications, and build better communities through our transparent CDF management system.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative min-h-screen gradient-hero overflow-hidden">
    <!-- Professional Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-orange-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-1000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-500"></div>
    </div>

    <!-- Professional Floating Elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full float-animation"></div>
    <div class="absolute top-40 right-20 w-16 h-16 bg-orange-400/20 rounded-full float-animation" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-40 left-1/4 w-12 h-12 bg-green-400/20 rounded-full float-animation" style="animation-delay: 4s;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
        <div class="text-center">
            <!-- Professional Hero Content -->
            <div class="max-w-4xl mx-auto" data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    <span class="block">Empowering</span>
                    <span class="block bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                        Communities
                    </span>
                    <span class="block">Together</span>
                </h1>

                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    Transform your community through transparent constituency development fund management.
                    Apply for projects, track progress, and build a better future with professional excellence.
                </p>

                <!-- Professional Hero Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('apply') }}"
                       class="group relative px-8 py-4 btn-zambian-secondary rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-2xl">
                        <span class="relative z-10 flex items-center justify-center">
                            <i class="fas fa-rocket mr-2"></i>
                            Apply for Project
                        </span>
                    </a>

                    <a href="#learn-more"
                       class="group px-8 py-4 border-2 border-white text-white rounded-xl font-semibold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300">
                        <i class="fas fa-play-circle mr-2"></i>
                        Learn More
                    </a>
                </div>

                <!-- Professional Floating Statistics -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16" data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center glass rounded-2xl p-6 hover-lift">
                        <div class="text-3xl md:text-4xl font-bold text-orange-400 mb-2">500+</div>
                        <div class="text-gray-200 text-sm md:text-base">Projects Completed</div>
                    </div>

                    <div class="text-center glass rounded-2xl p-6 hover-lift">
                        <div class="text-3xl md:text-4xl font-bold text-green-400 mb-2">2M+</div>
                        <div class="text-gray-200 text-sm md:text-base">Lives Impacted</div>
                    </div>

                    <div class="text-center glass rounded-2xl p-6 hover-lift">
                        <div class="text-3xl md:text-4xl font-bold text-orange-400 mb-2">50+</div>
                        <div class="text-gray-200 text-sm md:text-base">Constituencies</div>
                    </div>

                    <div class="text-center glass rounded-2xl p-6 hover-lift">
                        <div class="text-3xl md:text-4xl font-bold text-green-400 mb-2">K2B+</div>
                        <div class="text-gray-200 text-sm md:text-base">Funds Allocated</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <a href="#learn-more" class="flex flex-col items-center text-white hover:text-orange-400 transition-colors duration-300">
            <span class="text-sm mb-2">Discover More</span>
            <i class="fas fa-chevron-down text-2xl"></i>
        </a>
    </div>
</section>

<!-- Professional About CDF Section -->
<section id="learn-more" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            <!-- Content -->
            <div class="mb-12 lg:mb-0" data-aos="fade-right">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    What is the
                    <span class="bg-gradient-to-r from-green-600 to-green-500 bg-clip-text text-transparent">
                        CDF?
                    </span>
                </h2>

                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    The Constituency Development Fund is a government initiative designed to empower local communities
                    by providing funding for development projects that directly improve the lives of citizens.
                </p>

                <!-- Professional Feature List -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Transparent Process</h3>
                            <p class="text-gray-600">Every application and fund allocation is tracked and made transparent to ensure accountability.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Community Focused</h3>
                            <p class="text-gray-600">Projects are designed to address the most pressing needs of local communities.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Measurable Impact</h3>
                            <p class="text-gray-600">All projects include clear success metrics and regular progress monitoring.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Image/Visual -->
            <div class="relative" data-aos="fade-left">
                <div class="aspect-w-16 aspect-h-12 rounded-2xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                         alt="Community Development"
                         class="w-full h-full object-cover">
                </div>

                <!-- Professional Floating Stats -->
                <div class="absolute -top-6 -left-6 bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">850K+</div>
                        <div class="text-sm text-gray-600">People with Clean Water</div>
                    </div>
                </div>

                <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-orange-600">65</div>
                        <div class="text-sm text-gray-600">Schools Built</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Project Categories -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Project
                <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
                    Categories
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Explore the different types of development projects we support across various sectors to build stronger communities.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Infrastructure -->
            <div class="group card-zambian rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Infrastructure Projects"
                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-road text-orange-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Infrastructure</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Roads, bridges, markets, and other essential infrastructure that connects and serves communities.</p>
                    <a href="{{ route('projects.infrastructure') }}"
                       class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Education -->
            <div class="group card-zambian rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1497486751825-1233686d5d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Education Projects"
                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Education</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Schools, libraries, computer labs, and educational programs that invest in our children's future.</p>
                    <a href="{{ route('projects.education') }}"
                       class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Healthcare -->
            <div class="group card-zambian rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Healthcare Projects"
                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-heartbeat text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Healthcare</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Clinics, health posts, medical equipment, and health programs for community wellness.</p>
                    <a href="{{ route('projects.health') }}"
                       class="inline-flex items-center text-red-600 hover:text-red-700 font-medium">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Water & Sanitation -->
            <div class="group card-zambian rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1541844053589-346841d0b34c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Water & Sanitation Projects"
                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-tint text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Water & Sanitation</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Boreholes, water systems, toilets, and sanitation facilities for healthy communities.</p>
                    <a href="{{ route('projects.water') }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Agriculture -->
            <div class="group card-zambian rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="500">
                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1500076656116-558758c991c1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Agriculture Projects"
                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-seedling text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Agriculture</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Irrigation systems, storage facilities, and training programs to support farmers.</p>
                    <a href="{{ route('projects.agriculture') }}"
                       class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Youth Development -->
            <div class="group card-zambian rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="600">
                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1529390079861-591de354faf5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Youth Development Projects"
                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-rocket text-orange-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Youth Development</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Skills training, sports facilities, and empowerment programs for young people.</p>
                    <a href="{{ route('projects.youth') }}"
                       class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium">
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Success Stories -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Success
                <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
                    Stories
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Real stories from community members whose lives have been transformed through CDF projects.
            </p>
        </div>

        <!-- Professional Featured Story -->
        <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-3xl p-8 lg:p-12 mb-12" data-aos="fade-up">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                <div class="mb-8 lg:mb-0">
                    <div class="aspect-w-16 aspect-h-12 rounded-2xl overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Community Borehole Project"
                             class="w-full h-full object-cover">
                    </div>
                </div>

                <div>
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b1e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                             alt="Mary Mwanza"
                             class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Mary Mwanza</h3>
                            <p class="text-gray-600">Community Leader, Chilenje Ward</p>
                        </div>
                    </div>

                    <blockquote class="text-lg text-gray-700 italic mb-6 leading-relaxed">
                        "Before the CDF borehole project, our children had to walk 5 kilometers every morning to fetch water.
                        Now, clean water is right here in our community. Our children can focus on their education,
                        and our women have time for income-generating activities. This project has transformed our entire community."
                    </blockquote>

                    <div class="flex items-center space-x-4">
                        <div class="flex text-orange-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-gray-600 font-medium">Community Borehole Project • 2023</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional More Stories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card-zambian rounded-2xl p-6" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center mb-4">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                         alt="John Banda"
                         class="w-12 h-12 rounded-full object-cover mr-3">
                    <div>
                        <h4 class="font-bold text-gray-900">John Banda</h4>
                        <p class="text-sm text-gray-600">Farmer, Kabulonga</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">
                    "The irrigation system increased our crop yield by 300%. We can now support our families
                    and sell surplus to neighboring communities."
                </p>
                <div class="flex text-orange-400 text-sm">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>

            <div class="card-zambian rounded-2xl p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center mb-4">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                         alt="Grace Tembo"
                         class="w-12 h-12 rounded-full object-cover mr-3">
                    <div>
                        <h4 class="font-bold text-gray-900">Grace Tembo</h4>
                        <p class="text-sm text-gray-600">Teacher, Matero</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">
                    "Our new school block means we can accommodate 200 more students.
                    Every child in our community now has access to quality education."
                </p>
                <div class="flex text-orange-400 text-sm">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>

            <div class="card-zambian rounded-2xl p-6" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center mb-4">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                         alt="Peter Zulu"
                         class="w-12 h-12 rounded-full object-cover mr-3">
                    <div>
                        <h4 class="font-bold text-gray-900">Peter Zulu</h4>
                        <p class="text-sm text-gray-600">Youth Leader, Garden</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm mb-4">
                    "The skills training center changed my life. I learned computer skills and now run
                    my own digital services business, employing 5 other young people."
                </p>
                <div class="flex text-orange-400 text-sm">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Impact Statistics -->
<section class="py-20 gradient-professional text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Our
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Impact
                </span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Numbers that tell the story of transformation and development across our communities.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center p-8 glass rounded-2xl border border-white/10" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-orange-400 text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-orange-400 mb-2" data-counter="25000">0</div>
                <div class="text-gray-300">Students in New Classrooms</div>
            </div>

            <div class="text-center p-8 glass rounded-2xl border border-white/10" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heartbeat text-red-400 text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-red-400 mb-2" data-counter="180000">0</div>
                <div class="text-gray-300">People with Healthcare Access</div>
            </div>

            <div class="text-center p-8 glass rounded-2xl border border-white/10" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-road text-orange-400 text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-orange-400 mb-2" data-counter="280">0</div>
                <div class="text-gray-300">KM of Roads Built</div>
            </div>

            <div class="text-center p-8 glass rounded-2xl border border-white/10" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-seedling text-green-400 text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-green-400 mb-2" data-counter="15000">0</div>
                <div class="text-gray-300">Farmers Supported</div>
            </div>

            <div class="text-center p-8 glass rounded-2xl border border-white/10" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-rocket text-orange-400 text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-orange-400 mb-2" data-counter="8500">0</div>
                <div class="text-gray-300">Youth Trained in Skills</div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Call to Action -->
<section class="py-20 gradient-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Ready to Transform Your Community?
            </h2>
            <p class="text-xl text-gray-200 mb-8">
                Join thousands of community leaders who are building a better future through the CDF program.
                Your project could be the next success story.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('apply') }}"
                   class="inline-flex items-center px-8 py-4 btn-zambian-secondary rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-2xl">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Start Your Application
                </a>

                <a href="{{ route('contact') }}"
                   class="inline-flex items-center px-8 py-4 border-2 border-white text-white rounded-xl font-semibold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300">
                    <i class="fas fa-phone mr-2"></i>
                    Get Support
                </a>
            </div>

            <div class="mt-8 text-gray-200">
                <p class="text-sm">
                    <i class="fas fa-shield-alt mr-2 text-green-400"></i>
                    100% Secure • Transparent Process • SMS Updates
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Professional Counter Animation
    function animateCounters() {
        const counters = document.querySelectorAll('[data-counter]');

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-counter'));
            const duration = 2500; // 2.5 seconds for professional feel
            const step = target / (duration / 16); // 60fps
            let current = 0;

            const updateCounter = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.floor(current).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };

            // Start animation when element comes into view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(counter);
        });
    }

    // Initialize counters when DOM is loaded
    document.addEventListener('DOMContentLoaded', animateCounters);

    // Professional smooth scroll for internal links
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

    // Professional parallax effect for hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.gradient-hero');
        if (parallax) {
            const speed = scrolled * 0.5;
            parallax.style.transform = `translateY(${speed}px)`;
        }
    });

    // Professional loading animation
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');

        // Add shimmer effect to cards
        const cards = document.querySelectorAll('.card-zambian');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('shimmer');
                setTimeout(() => card.classList.remove('shimmer'), 1000);
            }, index * 200);
        });
    });
</script>
@endpush
@endsection
