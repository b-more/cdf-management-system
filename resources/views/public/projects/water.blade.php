{{-- resources/views/public/projects/water.blade.php --}}
@extends('layouts.app')

@section('title', 'Water & Sanitation Projects - CDF Portal Zambia')
@section('description', 'Explore completed water and sanitation development projects funded by CDF. Building water wells, sanitation facilities, and hygiene programs to improve health and quality of life across Zambia.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-20 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-cyan-100 rounded-2xl mb-6" data-aos="fade-up">
                <i class="fas fa-tint text-cyan-600 text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up" data-aos-delay="100">
                Water & Sanitation
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Projects
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="200">
                Ensuring access to clean water and proper sanitation facilities to improve health outcomes and enhance quality of life for all Zambians.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('apply') }}" class="btn-zambian-primary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-file-alt mr-3"></i>Apply for Water & Sanitation Funding
                </a>
                <a href="{{ route('gallery') }}" class="btn-zambian-secondary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-images mr-3"></i>View All Projects
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Water & Sanitation Impact Statistics -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-cyan-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-water text-cyan-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">1,200+</h3>
                <p class="text-gray-600 font-medium">Water Points Constructed</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-home text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">800,000+</h3>
                <p class="text-gray-600 font-medium">People with Clean Water Access</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-cyan-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-restroom text-cyan-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">950+</h3>
                <p class="text-gray-600 font-medium">Sanitation Facilities Built</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chart-line text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">70%</h3>
                <p class="text-gray-600 font-medium">Reduction in Waterborne Diseases</p>
            </div>
        </div>

        <!-- Water & Sanitation Focus Areas -->
        <div class="bg-gradient-to-r from-cyan-50 to-orange-50 rounded-3xl p-8 mb-16" data-aos="fade-up" data-aos-delay="500">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-zambian-black mb-4">
                    Our Water & Sanitation
                    <span class="bg-gradient-to-r from-cyan-600 to-orange-500 bg-clip-text text-transparent">
                        Focus Areas
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive water and sanitation development initiatives designed to ensure universal access to clean water and proper sanitation facilities.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 border border-cyan-200">
                    <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-water text-cyan-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Water Wells & Boreholes</h3>
                    <p class="text-gray-700 text-sm">Deep water wells, solar-powered boreholes, and hand pumps for reliable water access.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-filter text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Water Treatment Systems</h3>
                    <p class="text-gray-700 text-sm">Water purification plants, filtration systems, and quality testing facilities.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-cyan-200">
                    <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-restroom text-cyan-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Sanitation Facilities</h3>
                    <p class="text-gray-700 text-sm">Public toilets, school latrines, and community sanitation blocks with proper waste management.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-recycle text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Waste Management</h3>
                    <p class="text-gray-700 text-sm">Sewage treatment plants, waste collection systems, and recycling facilities.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-cyan-200">
                    <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-hands-wash text-cyan-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Hygiene Education</h3>
                    <p class="text-gray-700 text-sm">Community hygiene programs, handwashing stations, and health education campaigns.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-tools text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Maintenance & Repair</h3>
                    <p class="text-gray-700 text-sm">Equipment maintenance, repair services, and technical support for water systems.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Water & Sanitation Projects -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-zambian-black mb-6">
                Featured Water & Sanitation
                <span class="bg-gradient-to-r from-cyan-600 to-orange-500 bg-clip-text text-transparent">
                    Success Stories
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover how CDF water and sanitation projects are transforming communities, improving health outcomes, and providing dignified living conditions across Zambia.
            </p>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($projects as $project)
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <!-- Project Image -->
                <div class="relative h-48 bg-gradient-to-br from-cyan-100 to-orange-100">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->project_title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-tint text-cyan-500 text-4xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-cyan-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Water & Sanitation
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 text-cyan-600 px-3 py-1 rounded-full text-xs font-semibold">
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
                        <div class="text-cyan-600 font-bold">
                            K{{ number_format($project->approved_amount ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tint text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Water & Sanitation Projects Yet</h3>
                <p class="text-gray-500">Water and sanitation projects will be displayed here once they are completed.</p>
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

<!-- Health Impact of Clean Water -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-cyan-50 to-orange-50 rounded-3xl p-8 md:p-12" data-aos="fade-up">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-zambian-black mb-6">
                        Transforming Health Through
                        <span class="bg-gradient-to-r from-cyan-600 to-orange-500 bg-clip-text text-transparent">
                            Clean Water & Sanitation
                        </span>
                    </h2>
                    <p class="text-lg text-gray-700 mb-6">
                        Access to clean water and proper sanitation facilities has dramatically reduced waterborne diseases, improved child mortality rates, and enhanced overall community health. Our projects ensure that every Zambian has access to this basic human right.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-cyan-600 mb-1">70%</h3>
                            <p class="text-gray-600 text-sm">Disease Reduction</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-orange-600 mb-1">85%</h3>
                            <p class="text-gray-600 text-sm">Improved Hygiene</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-cyan-600 mb-1">50%</h3>
                            <p class="text-gray-600 text-sm">Child Mortality Drop</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-orange-600 mb-1">90%</h3>
                            <p class="text-gray-600 text-sm">Water Quality Improvement</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-quote-left text-cyan-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-zambian-black">Success Story</h4>
                                <p class="text-gray-500 text-sm">Chibombo Water Project</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic mb-6">
                            "Before the borehole was installed, our children were constantly sick from drinking contaminated water. Now, we have clean water 24/7, and our community health has improved dramatically. Children can attend school regularly without falling ill."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">MM</span>
                            </div>
                            <div>
                                <p class="font-semibold text-zambian-black">Mrs. Margaret Mwanza</p>
                                <p class="text-gray-500 text-sm">Community Health Volunteer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Water Access & SDG Goals -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-zambian-black mb-6">
                Contributing to
                <span class="bg-gradient-to-r from-cyan-600 to-orange-500 bg-clip-text text-transparent">
                    Sustainable Development Goals
                </span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Our water and sanitation projects directly contribute to achieving SDG 6: Clean Water and Sanitation for All.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-cyan-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-water text-cyan-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-zambian-black mb-4">Universal Access</h3>
                <p class="text-gray-600 mb-4">Ensuring equitable access to safe and affordable drinking water for all communities, especially rural areas.</p>
                <div class="text-3xl font-bold text-cyan-600">800K+</div>
                <p class="text-gray-500 text-sm">People with Clean Water</p>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-restroom text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-zambian-black mb-4">Adequate Sanitation</h3>
                <p class="text-gray-600 mb-4">Providing access to adequate and equitable sanitation and hygiene facilities, ending open defecation.</p>
                <div class="text-3xl font-bold text-orange-600">950+</div>
                <p class="text-gray-500 text-sm">Sanitation Facilities</p>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-cyan-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-recycle text-cyan-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-zambian-black mb-4">Water Quality</h3>
                <p class="text-gray-600 mb-4">Improving water quality by reducing pollution, eliminating dumping, and minimizing release of hazardous materials.</p>
                <div class="text-3xl font-bold text-cyan-600">90%</div>
                <p class="text-gray-500 text-sm">Quality Improvement</p>
            </div>
        </div>
    </div>
</section>

<!-- Apply for Water & Sanitation Funding -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-r from-cyan-500 to-orange-500 rounded-3xl p-12 text-white" data-aos="fade-up">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-tint text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Improve Water & Sanitation in Your Community?
            </h2>
            <p class="text-xl text-cyan-50 mb-8 max-w-2xl mx-auto">
                Apply for CDF water and sanitation funding and help provide clean water access, build sanitation facilities, and improve health outcomes in your community.
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
                <span class="bg-gradient-to-r from-cyan-600 to-orange-500 bg-clip-text text-transparent">
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

            <a href="{{ route('projects.agriculture') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="400">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-seedling text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-green-600 transition-colors">Agriculture</h3>
                <p class="text-gray-600 text-sm">Farming support and agricultural development</p>
            </a>

            <a href="{{ route('projects.youth') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="500">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-yellow-200 transition-colors">
                    <i class="fas fa-users text-yellow-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-yellow-600 transition-colors">Youth Development</h3>
                <p class="text-gray-600 text-sm">Youth programs and empowerment initiatives</p>
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    .line-clamp-2 {
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
