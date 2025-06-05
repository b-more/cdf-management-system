{{-- resources/views/public/projects/youth.blade.php --}}
@extends('layouts.app')

@section('title', 'Youth Development Projects - CDF Portal Zambia')
@section('description', 'Explore completed youth development projects funded by CDF. Empowering young Zambians through skills training, entrepreneurship programs, and youth centers across the country.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-20 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-2xl mb-6" data-aos="fade-up">
                <i class="fas fa-users text-yellow-600 text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up" data-aos-delay="100">
                Youth Development
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Projects
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="200">
                Empowering the next generation through skills development, entrepreneurship training, and youth-centered programs that create opportunities and build leadership capacity.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('apply') }}" class="btn-zambian-primary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-file-alt mr-3"></i>Apply for Youth Development Funding
                </a>
                <a href="{{ route('gallery') }}" class="btn-zambian-secondary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-images mr-3"></i>View All Projects
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Youth Development Impact Statistics -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">25,000+</h3>
                <p class="text-gray-600 font-medium">Youth Trained</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-briefcase text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">8,500+</h3>
                <p class="text-gray-600 font-medium">Jobs Created</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-lightbulb text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">1,200+</h3>
                <p class="text-gray-600 font-medium">Businesses Started</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-home text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">150+</h3>
                <p class="text-gray-600 font-medium">Youth Centers Built</p>
            </div>
        </div>

        <!-- Youth Development Focus Areas -->
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-3xl p-8 mb-16" data-aos="fade-up" data-aos-delay="500">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-zambian-black mb-4">
                    Our Youth Development
                    <span class="bg-gradient-to-r from-yellow-600 to-orange-500 bg-clip-text text-transparent">
                        Focus Areas
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive youth empowerment initiatives designed to build skills, create opportunities, and develop the next generation of leaders.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 border border-yellow-200">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-tools text-yellow-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Skills Training</h3>
                    <p class="text-gray-700 text-sm">Technical and vocational skills training in carpentry, tailoring, mechanics, and modern technology.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-lightbulb text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Entrepreneurship</h3>
                    <p class="text-gray-700 text-sm">Business development training, startup funding, and mentorship programs for young entrepreneurs.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-yellow-200">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-home text-yellow-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Youth Centers</h3>
                    <p class="text-gray-700 text-sm">Community youth centers with recreational facilities, meeting spaces, and program venues.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-laptop text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Digital Literacy</h3>
                    <p class="text-gray-700 text-sm">Computer training, internet skills, and digital entrepreneurship programs for the digital age.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-yellow-200">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-handshake text-yellow-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Leadership Development</h3>
                    <p class="text-gray-700 text-sm">Leadership training, civic engagement programs, and youth governance initiatives.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-futbol text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Sports & Recreation</h3>
                    <p class="text-gray-700 text-sm">Sports facilities, recreational programs, and youth tournaments for healthy development.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Youth Development Projects -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-zambian-black mb-6">
                Featured Youth Development
                <span class="bg-gradient-to-r from-yellow-600 to-orange-500 bg-clip-text text-transparent">
                    Success Stories
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover how CDF youth development projects are creating opportunities, building skills, and empowering young Zambians to become leaders and entrepreneurs.
            </p>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($projects as $project)
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <!-- Project Image -->
                <div class="relative h-48 bg-gradient-to-br from-yellow-100 to-orange-100">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->project_title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-users text-yellow-500 text-4xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Youth Development
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 text-yellow-600 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $project->status }}
                        </span>
                    </div>
                </div>

                <!-- Project Content -->
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $project->ward->name ?? 'N/A' }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $project->created_at->format('M Y') }}</span>
                    </div>

                    <h3 class="text-xl font-bold text-zambian-black mb-3 line-clamp-2">
                        {{ $project->project_title }}
                    </h3>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $project->project_description }}
                    </p>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-orange-600">
                            <i class="fas fa-users mr-2"></i>
                            <span class="text-sm font-semibold">
                                {{ number_format($project->beneficiaries_count ?? 0) }} Beneficiaries
                            </span>
                        </div>
                        <div class="text-yellow-600 font-bold">
                            K{{ number_format($project->approved_amount ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Youth Development Projects Yet</h3>
                <p class="text-gray-500">Youth development projects will be displayed here once they are completed.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="flex justify-center" data-aos="fade-up">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</section>

<!-- Youth Success Stories -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-3xl p-8 md:p-12" data-aos="fade-up">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-zambian-black mb-6">
                        Empowering Youth Through
                        <span class="bg-gradient-to-r from-yellow-600 to-orange-500 bg-clip-text text-transparent">
                            Skills & Opportunities
                        </span>
                    </h2>
                    <p class="text-lg text-gray-700 mb-6">
                        Our youth development programs have created thousands of employment opportunities, launched successful businesses, and developed community leaders. By investing in young people, we're building Zambia's future workforce and leadership pipeline.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-yellow-600 mb-1">85%</h3>
                            <p class="text-gray-600 text-sm">Employment Rate</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-orange-600 mb-1">60%</h3>
                            <p class="text-gray-600 text-sm">Start Own Business</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-yellow-600 mb-1">95%</h3>
                            <p class="text-gray-600 text-sm">Skills Certification</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-orange-600 mb-1">200%</h3>
                            <p class="text-gray-600 text-sm">Income Increase</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-quote-left text-yellow-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-zambian-black">Success Story</h4>
                                <p class="text-gray-500 text-sm">Lusaka Youth Skills Center</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic mb-6">
                            "The entrepreneurship training program changed my life completely. I learned business skills, received startup funding, and now employ 12 people in my tailoring business. CDF gave me the tools to become a job creator, not just a job seeker."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">PM</span>
                            </div>
                            <div>
                                <p class="font-semibold text-zambian-black">Patricia Mwenda</p>
                                <p class="text-gray-500 text-sm">Young Entrepreneur, Age 24</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Youth Demographics & Opportunities -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-zambian-black mb-6">
                Youth in Zambia:
                <span class="bg-gradient-to-r from-yellow-600 to-orange-500 bg-clip-text text-transparent">
                    Challenges & Opportunities
                </span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                With 60% of Zambia's population under 25, investing in youth development is crucial for national prosperity.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
            <!-- Challenges -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-zambian-black">Key Challenges</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center mt-1">
                            <i class="fas fa-times text-red-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-zambian-black">High Unemployment</h4>
                            <p class="text-gray-600 text-sm">Youth unemployment rate of 23.4% requires urgent intervention</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center mt-1">
                            <i class="fas fa-times text-red-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-zambian-black">Skills Gap</h4>
                            <p class="text-gray-600 text-sm">Mismatch between education and market demands</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center mt-1">
                            <i class="fas fa-times text-red-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-zambian-black">Limited Access</h4>
                            <p class="text-gray-600 text-sm">Rural youth face barriers to training and opportunities</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Solutions -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-lightbulb text-yellow-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-zambian-black">Our Solutions</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center mt-1">
                            <i class="fas fa-check text-yellow-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-zambian-black">Skills Training</h4>
                            <p class="text-gray-600 text-sm">Market-relevant vocational and technical training programs</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center mt-1">
                            <i class="fas fa-check text-yellow-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-zambian-black">Entrepreneurship Support</h4>
                            <p class="text-gray-600 text-sm">Business training, mentorship, and startup funding</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center mt-1">
                            <i class="fas fa-check text-yellow-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-zambian-black">Rural Outreach</h4>
                            <p class="text-gray-600 text-sm">Mobile training units and community-based programs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Apply for Youth Development Funding -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-3xl p-12 text-white" data-aos="fade-up">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-users text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Empower Youth in Your Community?
            </h2>
            <p class="text-xl text-yellow-50 mb-8 max-w-2xl mx-auto">
                Apply for CDF youth development funding and help create training programs, build youth centers, and provide opportunities for young people to thrive.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('apply') }}" class="btn-zambian-secondary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-file-alt mr-3"></i>Start Your Application
                </a>
                <a href="{{ route('contact') }}" class="bg-white/20 text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center hover:bg-white/30">
                    <i class="fas fa-phone mr-3"></i>Get Consultation
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Related Project Categories -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-zambian-black mb-4">
                Explore Other
                <span class="bg-gradient-to-r from-yellow-600 to-orange-500 bg-clip-text text-transparent">
                    Project Categories
                </span>
            </h2>
            <p class="text-lg text-gray-600">
                Discover more ways CDF is supporting community development across various sectors.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <a href="{{ route('projects.infrastructure') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-road text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-blue-600 transition-colors">Infrastructure</h3>
                <p class="text-gray-600 text-sm">Roads, bridges, and community buildings</p>
            </a>

            <a href="{{ route('projects.education') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-purple-600 transition-colors">Education</h3>
                <p class="text-gray-600 text-sm">Schools, libraries, and learning facilities</p>
            </a>

            <a href="{{ route('projects.health') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="300">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-red-200 transition-colors">
                    <i class="fas fa-heartbeat text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-red-600 transition-colors">Healthcare</h3>
                <p class="text-gray-600 text-sm">Clinics, health centers, and medical facilities</p>
            </a>

            <a href="{{ route('projects.water') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="400">
                <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-cyan-200 transition-colors">
                    <i class="fas fa-tint text-cyan-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-cyan-600 transition-colors">Water & Sanitation</h3>
                <p class="text-gray-600 text-sm">Water wells and sanitation facilities</p>
            </a>

            <a href="{{ route('projects.agriculture') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="500">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-seedling text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-green-600 transition-colors">Agriculture</h3>
                <p class="text-gray-600 text-sm">Farming support and agricultural development</p>
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
