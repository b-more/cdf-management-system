{{-- resources/views/public/gallery.blade.php --}}
@extends('layouts.app')

@section('title', 'Project Gallery - CDF Success Stories')
@section('description', 'Explore our comprehensive gallery of completed CDF projects. See the real impact of community development funds across Zambia through photos, videos, and success stories.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-20 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up">
                Project
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Gallery
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Witness the transformation of communities across Zambia through our comprehensive CDF projects.
                Every image tells a story of hope, progress, and empowerment.
            </p>
        </div>
    </div>
</section>

<!-- Professional Filter & Stats Section -->
<section class="py-12 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Project Statistics -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12" data-aos="fade-up">
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">500+</div>
                <div class="text-gray-600">Projects Completed</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">2M+</div>
                <div class="text-gray-600">Lives Impacted</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">156</div>
                <div class="text-gray-600">Constituencies</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">K2B+</div>
                <div class="text-gray-600">Funds Invested</div>
            </div>
        </div>

        <!-- Professional Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-8" data-aos="fade-up" data-aos-delay="200">
            <button class="filter-btn active px-6 py-3 rounded-xl font-semibold transition-all duration-300" data-filter="all">
                <i class="fas fa-th-large mr-2"></i>All Projects
            </button>
            <button class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all duration-300" data-filter="infrastructure">
                <i class="fas fa-road mr-2"></i>Infrastructure
            </button>
            <button class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all duration-300" data-filter="education">
                <i class="fas fa-graduation-cap mr-2"></i>Education
            </button>
            <button class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all duration-300" data-filter="health">
                <i class="fas fa-heartbeat mr-2"></i>Healthcare
            </button>
            <button class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all duration-300" data-filter="water">
                <i class="fas fa-tint mr-2"></i>Water & Sanitation
            </button>
            <button class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all duration-300" data-filter="agriculture">
                <i class="fas fa-seedling mr-2"></i>Agriculture
            </button>
            <button class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all duration-300" data-filter="youth">
                <i class="fas fa-rocket mr-2"></i>Youth Development
            </button>
        </div>

        <!-- Professional Search Bar -->
        <div class="max-w-md mx-auto" data-aos="fade-up" data-aos-delay="400">
            <div class="relative">
                <input type="text"
                       id="searchInput"
                       placeholder="Search projects by location, name, or keyword..."
                       class="w-full px-6 py-4 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>
</section>

<!-- Professional Gallery Grid -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="galleryGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Infrastructure Project -->
            <div class="gallery-item card-zambian rounded-2xl overflow-hidden group cursor-pointer"
                 data-category="infrastructure"
                 data-keywords="road construction chilenje lusaka infrastructure transport"
                 data-aos="fade-up" data-aos-delay="100">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Road Construction Project"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-road mr-1"></i>Infrastructure
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <h3 class="text-lg font-bold mb-1">Chilenje Road Construction</h3>
                        <p class="text-sm">3.5km road connecting communities</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-zambian-black">Chilenje Road Construction</h3>
                        <span class="text-green-600 font-semibold">K 2.5M</span>
                    </div>
                    <p class="text-gray-600 mb-4">A 3.5-kilometer road project connecting rural communities to the main highway, improving access to markets and essential services.</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>Chilenje Ward, Lusaka</span>
                        <span><i class="fas fa-calendar mr-1 text-green-500"></i>Completed 2024</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1 text-orange-500"></i>5,000 beneficiaries
                        </span>
                        <button class="view-project-btn text-green-600 hover:text-green-700 font-medium"
                                data-project-id="1">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Education Project -->
            <div class="gallery-item card-zambian rounded-2xl overflow-hidden group cursor-pointer"
                 data-category="education"
                 data-keywords="school classroom students education matero lusaka"
                 data-aos="fade-up" data-aos-delay="200">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1497486751825-1233686d5d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="School Construction Project"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-graduation-cap mr-1"></i>Education
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <h3 class="text-lg font-bold mb-1">Matero Primary School</h3>
                        <p class="text-sm">New classroom block with 6 classrooms</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-zambian-black">Matero Primary School Block</h3>
                        <span class="text-green-600 font-semibold">K 1.8M</span>
                    </div>
                    <p class="text-gray-600 mb-4">Construction of a modern 6-classroom block equipped with desks, chalkboards, and proper ventilation to accommodate 300 additional students.</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>Matero Ward, Lusaka</span>
                        <span><i class="fas fa-calendar mr-1 text-green-500"></i>Completed 2024</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1 text-orange-500"></i>300 students
                        </span>
                        <button class="view-project-btn text-green-600 hover:text-green-700 font-medium"
                                data-project-id="2">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Healthcare Project -->
            <div class="gallery-item card-zambian rounded-2xl overflow-hidden group cursor-pointer"
                 data-category="health"
                 data-keywords="clinic health medical garden lusaka healthcare"
                 data-aos="fade-up" data-aos-delay="300">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Health Clinic Project"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-heartbeat mr-1"></i>Healthcare
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <h3 class="text-lg font-bold mb-1">Garden Health Post</h3>
                        <p class="text-sm">Modern clinic with maternity wing</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-zambian-black">Garden Health Post</h3>
                        <span class="text-green-600 font-semibold">K 3.2M</span>
                    </div>
                    <p class="text-gray-600 mb-4">A fully equipped health post with maternity wing, consultation rooms, and pharmacy to serve the Garden compound and surrounding areas.</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>Garden Ward, Lusaka</span>
                        <span><i class="fas fa-calendar mr-1 text-green-500"></i>Completed 2024</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1 text-orange-500"></i>12,000 beneficiaries
                        </span>
                        <button class="view-project-btn text-green-600 hover:text-green-700 font-medium"
                                data-project-id="3">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Water & Sanitation Project -->
            <div class="gallery-item card-zambian rounded-2xl overflow-hidden group cursor-pointer"
                 data-category="water"
                 data-keywords="borehole water sanitation kabulonga lusaka clean water"
                 data-aos="fade-up" data-aos-delay="400">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1541844053589-346841d0b34c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Borehole Project"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-tint mr-1"></i>Water & Sanitation
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <h3 class="text-lg font-bold mb-1">Kabulonga Borehole</h3>
                        <p class="text-sm">Solar-powered water system</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-zambian-black">Kabulonga Borehole System</h3>
                        <span class="text-green-600 font-semibold">K 950K</span>
                    </div>
                    <p class="text-gray-600 mb-4">Solar-powered borehole system with 10,000-liter storage tank and distribution network providing clean water to 8 tap points.</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>Kabulonga Ward, Lusaka</span>
                        <span><i class="fas fa-calendar mr-1 text-green-500"></i>Completed 2023</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1 text-orange-500"></i>2,500 beneficiaries
                        </span>
                        <button class="view-project-btn text-green-600 hover:text-green-700 font-medium"
                                data-project-id="4">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Agriculture Project -->
            <div class="gallery-item card-zambian rounded-2xl overflow-hidden group cursor-pointer"
                 data-category="agriculture"
                 data-keywords="irrigation farming agriculture chongwe lusaka farmers"
                 data-aos="fade-up" data-aos-delay="500">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1500076656116-558758c991c1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Irrigation Project"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-seedling mr-1"></i>Agriculture
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <h3 class="text-lg font-bold mb-1">Chongwe Irrigation System</h3>
                        <p class="text-sm">50-hectare irrigation scheme</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-zambian-black">Chongwe Irrigation Scheme</h3>
                        <span class="text-green-600 font-semibold">K 4.1M</span>
                    </div>
                    <p class="text-gray-600 mb-4">A 50-hectare irrigation system with canal network, pump house, and storage facility supporting year-round farming for 200 farmers.</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>Chongwe Ward, Lusaka</span>
                        <span><i class="fas fa-calendar mr-1 text-green-500"></i>Completed 2024</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1 text-orange-500"></i>200 farmers
                        </span>
                        <button class="view-project-btn text-green-600 hover:text-green-700 font-medium"
                                data-project-id="5">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Youth Development Project -->
            <div class="gallery-item card-zambian rounded-2xl overflow-hidden group cursor-pointer"
                 data-category="youth"
                 data-keywords="youth skills training kalingalinga lusaka empowerment"
                 data-aos="fade-up" data-aos-delay="600">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1529390079861-591de354faf5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Youth Center Project"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-rocket mr-1"></i>Youth Development
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <h3 class="text-lg font-bold mb-1">Kalingalinga Skills Center</h3>
                        <p class="text-sm">ICT and vocational training hub</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-zambian-black">Kalingalinga Skills Center</h3>
                        <span class="text-green-600 font-semibold">K 2.7M</span>
                    </div>
                    <p class="text-gray-600 mb-4">Modern skills training center with computer lab, workshop spaces, and classrooms offering ICT, tailoring, and carpentry programs.</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span><i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>Kalingalinga Ward, Lusaka</span>
                        <span><i class="fas fa-calendar mr-1 text-green-500"></i>Completed 2024</span>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1 text-orange-500"></i>500 youth trained annually
                        </span>
                        <button class="view-project-btn text-green-600 hover:text-green-700 font-medium"
                                data-project-id="6">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12" data-aos="fade-up">
            <button id="loadMoreBtn" class="btn-zambian-primary text-white px-8 py-4 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-plus mr-2"></i>Load More Projects
            </button>
        </div>
    </div>
</section>

<!-- Professional Project Modal -->
<div id="projectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="relative">
                <!-- Modal Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 id="modalTitle" class="text-2xl font-bold text-zambian-black">Project Details</h3>
                        <button id="closeModal" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors duration-200">
                            <i class="fas fa-times text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div id="modalContent" class="p-6">
                    <!-- Content will be populated dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .filter-btn {
        @apply bg-gray-100 text-gray-700 hover:bg-green-50 hover:text-green-600;
    }
    .filter-btn.active {
        @apply bg-green-500 text-white shadow-lg;
    }
    .gallery-item {
        transition: all 0.3s ease;
    }
    .gallery-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Professional Gallery System
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const searchInput = document.getElementById('searchInput');
    const projectModal = document.getElementById('projectModal');
    const closeModal = document.getElementById('closeModal');
    const viewProjectBtns = document.querySelectorAll('.view-project-btn');

    // Filter functionality
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            filterProjects(filter);
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterProjects(getActiveFilter(), searchTerm);
    });

    function getActiveFilter() {
        const activeBtn = document.querySelector('.filter-btn.active');
        return activeBtn ? activeBtn.dataset.filter : 'all';
    }

    function filterProjects(category, searchTerm = '') {
        galleryItems.forEach(item => {
            const itemCategory = item.dataset.category;
            const itemKeywords = item.dataset.keywords.toLowerCase();

            const categoryMatch = category === 'all' || itemCategory === category;
            const searchMatch = searchTerm === '' || itemKeywords.includes(searchTerm);

            if (categoryMatch && searchMatch) {
                item.style.display = 'block';
                item.style.animation = 'fadeInUp 0.5s ease';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Project modal functionality
    viewProjectBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const projectId = this.dataset.projectId;
            showProjectModal(projectId);
        });
    });

    function showProjectModal(projectId) {
        const projectData = getProjectData(projectId);

        document.getElementById('modalTitle').textContent = projectData.title;
        document.getElementById('modalContent').innerHTML = `
            <div class="space-y-6">
                <!-- Project Images -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <img src="${projectData.mainImage}" alt="${projectData.title}" class="w-full h-64 object-cover rounded-xl">
                    <div class="grid grid-cols-2 gap-2">
                        ${projectData.additionalImages.map(img => `
                            <img src="${img}" alt="${projectData.title}" class="w-full h-32 object-cover rounded-lg">
                        `).join('')}
                    </div>
                </div>

                <!-- Project Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-semibold text-zambian-black mb-4">Project Information</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Category:</span>
                                <span class="font-semibold text-zambian-black">${projectData.category}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Location:</span>
                                <span class="font-semibold text-zambian-black">${projectData.location}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget:</span>
                                <span class="font-semibold text-green-600">${projectData.budget}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-semibold text-zambian-black">${projectData.duration}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Beneficiaries:</span>
                                <span class="font-semibold text-orange-600">${projectData.beneficiaries}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-zambian-black mb-4">Impact & Outcomes</h4>
                        <ul class="space-y-2">
                            ${projectData.outcomes.map(outcome => `
                                <li class="flex items-start space-x-3">
                                    <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                                    <span class="text-gray-700">${outcome}</span>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                </div>

                <!-- Project Description -->
                <div>
                    <h4 class="text-lg font-semibold text-zambian-black mb-4">Project Description</h4>
                    <p class="text-gray-700 leading-relaxed">${projectData.description}</p>
                </div>

                <!-- Community Testimonial -->
                <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-zambian-black mb-4">Community Impact</h4>
                    <blockquote class="text-gray-700 italic mb-4">"${projectData.testimonial.quote}"</blockquote>
                    <div class="flex items-center space-x-3">
                        <img src="${projectData.testimonial.avatar}" alt="${projectData.testimonial.name}" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-zambian-black">${projectData.testimonial.name}</p>
                            <p class="text-sm text-gray-600">${projectData.testimonial.title}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        projectModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function getProjectData(projectId) {
        const projects = {
            '1': {
                title: 'Chilenje Road Construction',
                category: 'Infrastructure',
                location: 'Chilenje Ward, Lusaka',
                budget: 'K 2.5M',
                duration: '8 months',
                beneficiaries: '5,000 people',
                mainImage: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                additionalImages: [
                    'https://images.unsplash.com/photo-1600585152220-90363fe7e115?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1597149960942-5957a2dbc0f9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                ],
                description: 'The Chilenje Road Construction project involved building a 3.5-kilometer tarmac road connecting the rural Chilenje community to the main Lusaka-Kafue highway. This infrastructure development has significantly improved transportation access, reduced travel time, and opened up economic opportunities for local businesses and farmers. The road features proper drainage systems, street lighting, and pedestrian walkways ensuring safety and durability.',
                outcomes: [
                    'Reduced travel time from 45 minutes to 15 minutes',
                    'Improved access to markets for 200+ farmers',
                    'Enhanced emergency services access',
                    '15 new businesses established along the route',
                    'Decreased transport costs by 40%'
                ],
                testimonial: {
                    quote: 'This road has transformed our community completely. Our children can now get to school easily during the rainy season, and we can transport our produce to the market without struggling through muddy paths.',
                    name: 'Margaret Phiri',
                    title: 'Local Farmer & Community Leader',
                    avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b1e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                }
            },
            '2': {
                title: 'Matero Primary School Block',
                category: 'Education',
                location: 'Matero Ward, Lusaka',
                budget: 'K 1.8M',
                duration: '6 months',
                beneficiaries: '300 students',
                mainImage: 'https://images.unsplash.com/photo-1497486751825-1233686d5d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                additionalImages: [
                    'https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                ],
                description: 'Construction of a modern 6-classroom block at Matero Primary School, designed to accommodate the growing student population. The facility includes spacious classrooms with proper ventilation, natural lighting, teacher preparation rooms, and modern sanitation facilities. Each classroom is equipped with quality desks, chalkboards, and storage facilities.',
                outcomes: [
                    'Accommodated 300 additional students',
                    'Reduced class sizes from 60 to 35 students per class',
                    'Improved learning environment with better facilities',
                    'Created employment for 8 additional teachers',
                    'Enhanced school enrollment rates by 25%'
                ],
                testimonial: {
                    quote: 'The new classrooms have made such a difference. Our children now have proper desks, good lighting, and clean facilities. The learning environment is so much better than before.',
                    name: 'Grace Mulenga',
                    title: 'Head Teacher, Matero Primary School',
                    avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                }
            },
            // Add more projects as needed...
        };

        return projects[projectId] || projects['1'];
    }

    // Close modal functionality
    closeModal.addEventListener('click', function() {
        projectModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    });

    projectModal.addEventListener('click', function(e) {
        if (e.target === projectModal) {
            projectModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });

    // Load more functionality
    document.getElementById('loadMoreBtn').addEventListener('click', function() {
        // Add animation to show loading
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading More Projects...';
        this.disabled = true;

        // Simulate loading (replace with actual API call)
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-plus mr-2"></i>Load More Projects';
            this.disabled = false;
            // Here you would append new project items to the gallery
        }, 2000);
    });

    // Add CSS animation for fadeInUp
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush
@endsection
