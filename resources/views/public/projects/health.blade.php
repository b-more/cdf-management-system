{{-- resources/views/public/projects/health.blade.php --}}
@extends('layouts.app')

@section('title', 'Health Projects - CDF Portal Zambia')
@section('description', 'Explore completed health and medical development projects funded by CDF. Building clinics, health centers, and medical facilities to improve healthcare access across Zambia.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-20 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-2xl mb-6" data-aos="fade-up">
                <i class="fas fa-heartbeat text-red-600 text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up" data-aos-delay="100">
                Health
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Projects
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="200">
                Improving healthcare access and quality by building modern medical facilities and supporting health programs across Zambian communities.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('apply') }}" class="btn-zambian-primary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-file-alt mr-3"></i>Apply for Health Funding
                </a>
                <a href="{{ route('gallery') }}" class="btn-zambian-secondary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-images mr-3"></i>View All Projects
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Health Impact Statistics -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-hospital text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">180+</h3>
                <p class="text-gray-600 font-medium">Health Facilities Built</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-md text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">500,000+</h3>
                <p class="text-gray-600 font-medium">Patients Served Annually</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-stethoscope text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">850+</h3>
                <p class="text-gray-600 font-medium">Medical Equipment Units</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-map-marker-alt text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">95</h3>
                <p class="text-gray-600 font-medium">Districts Covered</p>
            </div>
        </div>

        <!-- Health Focus Areas -->
        <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-3xl p-8 mb-16" data-aos="fade-up" data-aos-delay="500">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-zambian-black mb-4">
                    Our Health
                    <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
                        Focus Areas
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive healthcare development initiatives designed to improve medical services and health outcomes for all Zambians.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 border border-red-200">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-hospital text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Clinics & Hospitals</h3>
                    <p class="text-gray-700 text-sm">Construction of health centers, rural health posts, and district hospitals to improve access.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-x-ray text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Medical Equipment</h3>
                    <p class="text-gray-700 text-sm">Essential medical equipment, diagnostic tools, and modern healthcare technology.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-red-200">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-baby text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Maternal Health</h3>
                    <p class="text-gray-700 text-sm">Maternity wards, delivery rooms, and maternal healthcare programs for safer births.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-syringe text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Immunization Programs</h3>
                    <p class="text-gray-700 text-sm">Vaccination campaigns and immunization outreach programs for disease prevention.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-red-200">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-ambulance text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Emergency Services</h3>
                    <p class="text-gray-700 text-sm">Ambulances, emergency response systems, and critical care facilities.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-user-md text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Staff Training</h3>
                    <p class="text-gray-700 text-sm">Training programs for healthcare workers and medical professionals.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Health Projects -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-zambian-black mb-6">
                Featured Health
                <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
                    Success Stories
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover how CDF health projects are saving lives, improving medical services, and building healthier communities across Zambia.
            </p>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($projects as $project)
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <!-- Project Image -->
                <div class="relative h-48 bg-gradient-to-br from-red-100 to-orange-100">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->project_title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-heartbeat text-red-500 text-4xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Health
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
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
                        <div class="text-red-600 font-bold">
                            K{{ number_format($project->approved_amount ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heartbeat text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Health Projects Yet</h3>
                <p class="text-gray-500">Health projects will be displayed here once they are completed.</p>
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

<!-- Health Impact Story -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-3xl p-8 md:p-12" data-aos="fade-up">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-zambian-black mb-6">
                        Saving Lives Through
                        <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
                            Better Healthcare
                        </span>
                    </h2>
                    <p class="text-lg text-gray-700 mb-6">
                        Our health projects have dramatically reduced infant mortality rates, improved disease prevention, and provided essential medical services to previously underserved communities. By building modern facilities and training healthcare workers, we're creating a healthier Zambia.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-red-600 mb-1">60%</h3>
                            <p class="text-gray-600 text-sm">Reduced Mortality</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-orange-600 mb-1">90%</h3>
                            <p class="text-gray-600 text-sm">Vaccination Coverage</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-red-600 mb-1">75%</h3>
                            <p class="text-gray-600 text-sm">Safe Deliveries</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-orange-600 mb-1">300+</h3>
                            <p class="text-gray-600 text-sm">Lives Saved Daily</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-quote-left text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-zambian-black">Success Story</h4>
                                <p class="text-gray-500 text-sm">Kafue Rural Health Center</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic mb-6">
                            "The new health center has been a lifesaver for our community. We now have 24/7 emergency services, a modern maternity ward, and equipped ambulances. Maternal mortality has dropped by 80% since the facility opened."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">DM</span>
                            </div>
                            <div>
                                <p class="font-semibold text-zambian-black">Dr. James Mwanza</p>
                                <p class="text-gray-500 text-sm">Medical Officer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Apply for Health Funding -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-r from-red-500 to-orange-500 rounded-3xl p-12 text-white" data-aos="fade-up">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-heartbeat text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Improve Healthcare in Your Community?
            </h2>
            <p class="text-xl text-red-50 mb-8 max-w-2xl mx-auto">
                Apply for CDF health funding and help build better medical facilities, provide essential equipment, and create access to quality healthcare services.
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
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-zambian-black mb-4">
                Explore Other
                <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
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

            <a href="{{ route('projects.water') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="300">
                <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-cyan-200 transition-colors">
                    <i class="fas fa-tint text-cyan-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-cyan-600 transition-colors">Water & Sanitation</h3>
                <p class="text-gray-600 text-sm">Water wells and sanitation facilities</p>
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
