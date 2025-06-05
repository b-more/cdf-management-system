{{-- resources/views/public/projects/agriculture.blade.php --}}
@extends('layouts.app')

@section('title', 'Agriculture Projects - CDF Portal Zambia')
@section('description', 'Explore completed agriculture and farming development projects funded by CDF. Supporting rural communities with farming equipment, training, and agricultural infrastructure.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-20 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-2xl mb-6" data-aos="fade-up">
                <i class="fas fa-seedling text-green-600 text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up" data-aos-delay="100">
                Agriculture
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Projects
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="200">
                Empowering rural communities through sustainable farming initiatives, equipment support, and agricultural training programs.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('apply') }}" class="btn-zambian-primary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-file-alt mr-3"></i>Apply for Agriculture Funding
                </a>
                <a href="{{ route('gallery') }}" class="btn-zambian-secondary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center justify-center">
                    <i class="fas fa-images mr-3"></i>View All Projects
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Agriculture Impact Statistics -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-tractor text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">150+</h3>
                <p class="text-gray-600 font-medium">Farming Equipment Projects</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-users text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">12,500+</h3>
                <p class="text-gray-600 font-medium">Farmers Trained</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">75%</h3>
                <p class="text-gray-600 font-medium">Yield Improvement</p>
            </div>

            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-map-marker-alt text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-zambian-black mb-2">85</h3>
                <p class="text-gray-600 font-medium">Constituencies Served</p>
            </div>
        </div>

        <!-- Agriculture Focus Areas -->
        <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-3xl p-8 mb-16" data-aos="fade-up" data-aos-delay="500">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-zambian-black mb-4">
                    Our Agriculture
                    <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
                        Focus Areas
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Supporting sustainable agricultural development across multiple sectors to enhance food security and rural livelihoods.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 border border-green-200">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-tractor text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Farm Equipment</h3>
                    <p class="text-gray-700 text-sm">Tractors, plows, harvesters, and modern farming tools to increase productivity and efficiency.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-graduation-cap text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Training Programs</h3>
                    <p class="text-gray-700 text-sm">Modern farming techniques, crop management, and sustainable agriculture practices.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-green-200">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-warehouse text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Storage Facilities</h3>
                    <p class="text-gray-700 text-sm">Grain silos, warehouses, and cold storage to reduce post-harvest losses.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-seedling text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Seed & Fertilizer</h3>
                    <p class="text-gray-700 text-sm">Quality seeds, fertilizers, and agricultural inputs for improved crop yields.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-green-200">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-tint text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Irrigation Systems</h3>
                    <p class="text-gray-700 text-sm">Water pumps, irrigation infrastructure, and water management systems.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-orange-200">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-cow text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-zambian-black mb-3">Livestock Support</h3>
                    <p class="text-gray-700 text-sm">Animal husbandry, veterinary services, and livestock improvement programs.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Agriculture Projects -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-zambian-black mb-6">
                Featured Agriculture
                <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
                    Success Stories
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover how CDF agriculture projects are transforming farming communities and improving food security across Zambia.
            </p>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($projects as $project)
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <!-- Project Image -->
                <div class="relative h-48 bg-gradient-to-br from-green-100 to-orange-100">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->project_title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-seedling text-green-500 text-4xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Agriculture
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">
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
                        <div class="text-green-600 font-bold">
                            K{{ number_format($project->approved_amount ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-seedling text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Agriculture Projects Yet</h3>
                <p class="text-gray-500">Agriculture projects will be displayed here once they are completed.</p>
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

<!-- Apply for Agriculture Funding -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-r from-green-500 to-orange-500 rounded-3xl p-12 text-white" data-aos="fade-up">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-seedling text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Transform Agriculture in Your Community?
            </h2>
            <p class="text-xl text-green-50 mb-8 max-w-2xl mx-auto">
                Apply for CDF agriculture funding and help improve farming practices, increase yields, and enhance food security in your area.
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
                <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
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
