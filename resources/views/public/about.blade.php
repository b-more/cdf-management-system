{{-- resources/views/public/about.blade.php --}}
@extends('layouts.app')

@section('title', 'About CDF - Empowering Communities Through Development')
@section('description', 'Learn about the Constituency Development Fund, our mission, vision, and how we are transforming communities across Zambia through transparent development projects.')

@section('content')
<!-- Professional Hero Section with Zambian Colors -->
<section class="relative py-20 gradient-hero overflow-hidden">
    <!-- Professional Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up">
                About the
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    CDF Program
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Transforming communities through transparent, accountable, and inclusive development projects that put people first.
            </p>
        </div>
    </div>
</section>

<!-- Professional Mission & Vision -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Professional Mission -->
            <div data-aos="fade-right">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-3xl p-8 lg:p-12">
                    <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-zambian-black mb-6">Our Mission</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        To empower communities by providing transparent, accountable, and efficient management of
                        constituency development funds, ensuring that every project directly improves the lives of citizens
                        and contributes to sustainable community development.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Transparent fund allocation and management
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Community-driven project selection
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            Sustainable development outcomes
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Professional Vision -->
            <div data-aos="fade-left">
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl p-8 lg:p-12">
                    <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-zambian-black mb-6">Our Vision</h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        To be the leading model of transparent and accountable constituency development fund management,
                        creating thriving communities where every citizen has access to quality infrastructure, education,
                        healthcare, and economic opportunities.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-star text-orange-500 mr-3"></i>
                            Prosperous and self-reliant communities
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-star text-orange-500 mr-3"></i>
                            Digital-first governance and transparency
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-star text-orange-500 mr-3"></i>
                            Sustainable development for future generations
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Our Story -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            <!-- Professional Image -->
            <div class="mb-12 lg:mb-0" data-aos="fade-right">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Community Meeting"
                         class="w-full h-96 object-cover rounded-2xl shadow-2xl">

                    <!-- Professional Overlay Stats -->
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-sm rounded-xl p-4 shadow-lg">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">12</div>
                            <div class="text-sm text-gray-600">Years Active</div>
                        </div>
                    </div>

                    <div class="absolute bottom-6 right-6 bg-white/90 backdrop-blur-sm rounded-xl p-4 shadow-lg">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">500+</div>
                            <div class="text-sm text-gray-600">Projects Completed</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Content -->
            <div data-aos="fade-left">
                <h2 class="text-4xl font-bold text-zambian-black mb-6">Our Story</h2>
                <div class="space-y-6 text-lg text-gray-700 leading-relaxed">
                    <p>
                        The Constituency Development Fund was established as part of Zambia's commitment to
                        decentralized governance and community empowerment. Born from the recognition that
                        local communities know their needs best, the CDF represents a revolutionary approach
                        to development funding.
                    </p>

                    <p>
                        Since its inception, the program has evolved from a traditional bureaucratic process
                        to a modern, digital-first platform that prioritizes transparency, efficiency, and
                        community participation. Our journey has been marked by continuous innovation and
                        a steadfast commitment to putting communities at the center of development.
                    </p>

                    <p>
                        Today, we proudly serve 156 constituencies
                        across Zambia, having successfully completed over 500
                        projects that have transformed the lives of millions of citizens.
                    </p>
                </div>

                <!-- Professional Timeline -->
                <div class="mt-12">
                    <h3 class="text-xl font-bold text-zambian-black mb-6">Key Milestones</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-green-600 font-bold">2013</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-zambian-black">CDF Program Launch</h4>
                                <p class="text-gray-600">Official establishment of the Constituency Development Fund</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-orange-600 font-bold">2018</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-zambian-black">Digital Transformation</h4>
                                <p class="text-gray-600">Introduction of online application and tracking systems</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-green-600 font-bold">2025</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-zambian-black">Modern Portal Launch</h4>
                                <p class="text-gray-600">Launch of comprehensive digital portal with SMS notifications</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional How We Work -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold text-zambian-black mb-6">
                How We
                <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
                    Work
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Our transparent, community-driven process ensures that every project meets real needs and delivers lasting impact.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Professional Step 1 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-lightbulb text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        1
                    </div>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Community Identifies Need</h3>
                <p class="text-gray-600">
                    Communities identify their most pressing development needs through local consultations and ward meetings.
                </p>
            </div>

            <!-- Professional Step 2 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        2
                    </div>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Project Application</h3>
                <p class="text-gray-600">
                    Community leaders submit detailed project proposals through our digital platform with all necessary documentation.
                </p>
            </div>

            <!-- Professional Step 3 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        3
                    </div>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Review & Approval</h3>
                <p class="text-gray-600">
                    Multi-level review by Ward Development Committees and CDFC ensures projects meet criteria and community needs.
                </p>
            </div>

            <!-- Professional Step 4 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-hammer text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        4
                    </div>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Implementation</h3>
                <p class="text-gray-600">
                    Approved projects are implemented with continuous monitoring, community involvement, and transparent reporting.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Professional Our Values -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold text-zambian-black mb-6">
                Our
                <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
                    Values
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                These core values guide every decision we make and every project we support.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Professional Transparency -->
            <div class="card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-eye text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Transparency</h3>
                <p class="text-gray-600 leading-relaxed">
                    Every aspect of our operations is open to public scrutiny. From fund allocation to project progress,
                    we believe in complete transparency and accountability.
                </p>
            </div>

            <!-- Professional Community Focus -->
            <div class="card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-users text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Community Focus</h3>
                <p class="text-gray-600 leading-relaxed">
                    Communities are at the heart of everything we do. We listen, learn, and respond to the real needs
                    expressed by the people we serve.
                </p>
            </div>

            <!-- Professional Integrity -->
            <div class="card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Integrity</h3>
                <p class="text-gray-600 leading-relaxed">
                    We maintain the highest ethical standards in all our operations, ensuring that public funds are
                    used responsibly and effectively.
                </p>
            </div>

            <!-- Professional Innovation -->
            <div class="card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-rocket text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Innovation</h3>
                <p class="text-gray-600 leading-relaxed">
                    We embrace technology and innovative approaches to improve efficiency, accessibility, and
                    the overall impact of our programs.
                </p>
            </div>

            <!-- Professional Sustainability -->
            <div class="card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-leaf text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Sustainability</h3>
                <p class="text-gray-600 leading-relaxed">
                    Every project we support is designed with long-term sustainability in mind, ensuring lasting
                    benefits for current and future generations.
                </p>
            </div>

            <!-- Professional Inclusivity -->
            <div class="card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-heart text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Inclusivity</h3>
                <p class="text-gray-600 leading-relaxed">
                    We ensure that all community members, regardless of background, gender, or economic status,
                    have equal access to CDF opportunities and benefits.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Professional Leadership Team -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold text-zambian-black mb-6">
                Leadership
                <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
                    Team
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Meet the dedicated professionals who ensure the CDF program operates with excellence and integrity.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Professional Team Member 1 -->
            <div class="text-center group" data-aos="fade-up" data-aos-delay="100">
                <div class="relative mb-6">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                         alt="Director CDF"
                         class="w-32 h-32 rounded-full object-cover mx-auto shadow-lg group-hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-green-600/20 to-transparent rounded-full"></div>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-2">Dr. James Mwanza</h3>
                <p class="text-green-600 font-medium mb-3">Executive Director</p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Leading the CDF program with over 15 years of experience in development finance and community empowerment.
                </p>
            </div>

            <!-- Professional Team Member 2 -->
            <div class="text-center group" data-aos="fade-up" data-aos-delay="200">
                <div class="relative mb-6">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                         alt="Program Manager"
                         class="w-32 h-32 rounded-full object-cover mx-auto shadow-lg group-hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-orange-600/20 to-transparent rounded-full"></div>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-2">Ms. Grace Banda</h3>
                <p class="text-orange-600 font-medium mb-3">Program Manager</p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Overseeing program implementation and ensuring quality delivery of development projects across constituencies.
                </p>
            </div>

            <!-- Professional Team Member 3 -->
            <div class="text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="relative mb-6">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                         alt="Finance Director"
                         class="w-32 h-32 rounded-full object-cover mx-auto shadow-lg group-hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-green-600/20 to-transparent rounded-full"></div>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-2">Mr. Peter Tembo</h3>
                <p class="text-green-600 font-medium mb-3">Finance Director</p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Managing financial operations and ensuring transparent, accountable use of constituency development funds.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Professional Call to Action -->
<section class="py-20 gradient-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Ready to Make a Difference?
            </h2>
            <p class="text-xl text-gray-200 mb-8">
                Join us in building stronger communities. Whether you're applying for a project,
                volunteering your time, or simply want to stay informed, there's a place for you in our mission.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('apply') }}"
                   class="inline-flex items-center px-8 py-4 btn-zambian-secondary rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-2xl">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Submit Your Project
                </a>

                <a href="{{ route('contact') }}"
                   class="inline-flex items-center px-8 py-4 border-2 border-white text-white rounded-xl font-semibold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300">
                    <i class="fas fa-phone mr-2"></i>
                    Get in Touch
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
