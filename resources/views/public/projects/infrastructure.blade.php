{{-- resources/views/public/projects/infrastructure.blade.php --}}
@extends('layouts.app')

@section('title', 'Infrastructure Projects - CDF Portal Zambia')
@section('description', 'Explore completed infrastructure development projects funded by CDF. Building roads, bridges, community centers, and essential infrastructure to connect and strengthen Zambian communities.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-20 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-6" data-aos="fade-up">
                <i class="fas fa-road text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up" data-aos-delay="100">
                Infrastructure
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Projects
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="200">
                Building the backbone of community development through roads, bridges, buildings, and essential infrastructure that connects and empowers Zambian communities.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('apply') }}" class="btn-zambian-primary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-file-alt mr-3"></i>Apply for Infrastructure Funding
                </a>
                <a href="{{ route('gallery') }}" class="btn-zambian-secondary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-images mr-3"></i>View All Projects
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Infrastructure Impact Statistics -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-road text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">2,500+</h3>
                <p class="text-gray-600 font-medium">Kilometers of Roads</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bridge-water text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">350+</h3>
                <p class="text-gray-600 font-medium">Bridges Constructed</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-building text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">450+</h3>
                <p class="text-gray-600 font-medium">Buildings Completed</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-users text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">2M+</h3>
                <p class="text-gray-600 font-medium">People Connected</p>
            </div>
        </div>

        <!-- Infrastructure Focus Areas -->
        <div class="bg-gradient-to-r from-blue-50 to-orange-50 rounded-3xl p-8 mb-16" data-aos="fade-up" data-aos-delay="500">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-zambian-black mb-4">
                    Our Infrastructure
                    <span class="bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">
                        Focus Areas
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Building essential infrastructure that forms the foundation for economic growth, social development, and improved quality of life.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 border border-blue-200">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-road text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Roads & Highways</h3>
                    <p class="text-gray-700 text-sm">Construction and rehabilitation of feeder roads, trunk roads, and highway networks.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-bridge-water text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Bridges & Culverts</h3>
                    <p class="text-gray-700 text-sm">Connecting communities across rivers and valleys with durable bridge infrastructure.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-blue-200">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-building text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Community Centers</h3>
                    <p class="text-gray-700 text-sm">Multi-purpose halls, civic centers, and community gathering spaces.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-store text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Markets & Trading</h3>
                    <p class="text-gray-700 text-sm">Modern market facilities and commercial infrastructure for economic activities.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-blue-200">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-bolt text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Energy Infrastructure</h3>
                    <p class="text-gray-700 text-sm">Power lines, transformers, and electrical infrastructure for rural electrification.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-wifi text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Communication</h3>
                    <p class="text-gray-700 text-sm">Telecommunication towers and ICT infrastructure for digital connectivity.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Infrastructure Projects -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-zambian-black mb-6">
                Featured Infrastructure
                <span class="bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">
                    Success Stories
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover how CDF infrastructure projects are connecting communities, boosting economic activities, and improving living standards across Zambia.
            </p>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($projects as $project)
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <!-- Project Image -->
                <div class="relative h-48 bg-gradient-to-br from-blue-100 to-orange-100">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->project_title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-road text-blue-500 text-4xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Infrastructure
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">
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
                        <div class="text-blue-600 font-bold">
                            K{{ number_format($project->approved_amount ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-road text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Infrastructure Projects Yet</h3>
                <p class="text-gray-500">Infrastructure projects will be displayed here once they are completed.</p>
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

<!-- Infrastructure Impact Story -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-blue-50 to-orange-50 rounded-3xl p-8 md:p-12" data-aos="fade-up">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-zambian-black mb-6">
                        Connecting Communities Through
                        <span class="bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">
                            Quality Infrastructure
                        </span>
                    </h2>
                    <p class="text-lg text-gray-700 mb-6">
                        Our infrastructure projects have revolutionized transportation, communication, and economic opportunities in rural and urban areas. By building roads, bridges, and essential facilities, we're creating the foundation for sustainable development and prosperity.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-blue-600 mb-1">85%</h3>
                            <p class="text-gray-600 text-sm">Reduced Travel Time</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-orange-600 mb-1">150%</h3>
                            <p class="text-gray-600 text-sm">Economic Growth</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-blue-600 mb-1">95%</h3>
                            <p class="text-gray-600 text-sm">Market Access</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-orange-600 mb-1">500+</h3>
                            <p class="text-gray-600 text-sm">Communities Connected</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-quote-left text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-zambian-black">Success Story</h4>
                                <p class="text-gray-500 text-sm">Lusaka-Kafue Road Project</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic mb-6">
                            "The new road has transformed our community completely. What used to be a 3-hour journey is now just 45 minutes. Farmers can now easily transport their produce to markets, and children can attend school regularly even during the rainy season."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">CM</span>
                            </div>
                            <div>
                                <p class="font-semibold text-zambian-black">Chief Mukuni</p>
                                <p class="text-gray-500 text-sm">Traditional Leader</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Economic Impact Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-zambian-black mb-6">
                Economic Impact of
                <span class="bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">
                    Infrastructure Development
                </span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Quality infrastructure drives economic growth, creates employment opportunities, and attracts investment to communities.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chart-line text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-zambian-black mb-4">Economic Growth</h3>
                <p class="text-gray-600 mb-4">Infrastructure development has led to a 150% increase in local economic activities and business opportunities.</p>
                <div class="text-3xl font-bold text-blue-600">150%</div>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-briefcase text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-zambian-black mb-4">Job Creation</h3>
                <p class="text-gray-600 mb-4">Over 15,000 direct and indirect jobs created through infrastructure construction and maintenance.</p>
                <div class="text-3xl font-bold text-orange-600">15K+</div>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-lg border border-gray-100" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-dollar-sign text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-zambian-black mb-4">Investment Attraction</h3>
                <p class="text-gray-600 mb-4">Quality infrastructure has attracted over K2.5 billion in private sector investments.</p>
                <div class="text-3xl font-bold text-blue-600">K2.5B</div>
            </div>
        </div>
    </div>
</section>

<!-- Apply for Infrastructure Funding -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-r from-blue-500 to-orange-500 rounded-3xl p-12 text-white" data-aos="fade-up">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-road text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Build Infrastructure in Your Community?
            </h2>
            <p class="text-xl text-blue-50 mb-8 max-w-2xl mx-auto">
                Apply for CDF infrastructure funding and help build roads, bridges, community centers, and essential facilities that will connect and strengthen your community.
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
                <span class="bg-gradient-to-r from-blue-600 to-orange-500 bg-clip-text text-transparent">
                    Project Categories
                </span>
            </h2>
            <p class="text-lg text-gray-600">
                Discover more ways CDF is supporting community development across various sectors.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <a href="{{ route('projects.education') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-purple-600 transition-colors">Education</h3>
                <p class="text-gray-600 text-sm">Schools, libraries, and learning facilities</p>
            </a>

            <a href="{{ route('projects.health') }}" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-red-200 transition-colors">
                    <i class="fas fa-heartbeat text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-zambian-black mb-2 group-hover:text-red-600 transition-colors">Healthcare</h3>
                <p class="text-gray-600 text-sm">Clinics, health centers, and medical facilities</p>
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
