{{-- resources/views/public/status.blade.php --}}
@extends('layouts.app')

@section('title', 'Check Application Status - CDF Portal')
@section('description', 'Track your CDF application status, view project progress, and get real-time updates on your community development fund application.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-16 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">
                Check Your
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Application Status
                </span>
            </h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Track your CDF application progress in real-time and stay updated on your project's journey from submission to completion.
            </p>
        </div>
    </div>
</section>

<!-- Professional Status Check Form -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" data-aos="fade-up">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-50 to-orange-50 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-search text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-zambian-black">Application Status Lookup</h2>
                        <p class="text-gray-600">Enter your details to check your application status</p>
                    </div>
                </div>
            </div>

            <!-- Status Check Form -->
            <div class="p-8">
                <form id="statusForm" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Application ID -->
                        <div>
                            <label for="application_id" class="block text-sm font-medium text-zambian-black mb-2">
                                <i class="fas fa-hashtag text-green-500 mr-2"></i>Application ID
                            </label>
                            <input type="text"
                                   id="application_id"
                                   name="application_id"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                   placeholder="e.g., CDF-2025-001234"
                                   maxlength="20">
                            <p class="text-xs text-gray-500 mt-1">Enter your 14-digit application ID</p>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-zambian-black mb-2">
                                <i class="fas fa-phone text-orange-500 mr-2"></i>Phone Number
                            </label>
                            <input type="tel"
                                   id="phone_number"
                                   name="phone_number"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                   placeholder="e.g., +260971234567"
                                   maxlength="15">
                            <p class="text-xs text-gray-500 mt-1">Phone number used during application</p>
                        </div>
                    </div>

                    <!-- Alternative Search Option -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-zambian-black mb-4">
                            <i class="fas fa-route text-orange-500 mr-2"></i>Alternative Search
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Applicant Name -->
                            <div>
                                <label for="applicant_name" class="block text-sm font-medium text-zambian-black mb-2">
                                    <i class="fas fa-user text-green-500 mr-2"></i>Applicant Name
                                </label>
                                <input type="text"
                                       id="applicant_name"
                                       name="applicant_name"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                       placeholder="Enter your full name"
                                       maxlength="100">
                            </div>

                            <!-- Project Title -->
                            <div>
                                <label for="project_title" class="block text-sm font-medium text-zambian-black mb-2">
                                    <i class="fas fa-project-diagram text-orange-500 mr-2"></i>Project Title
                                </label>
                                <input type="text"
                                       id="project_title"
                                       name="project_title"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                       placeholder="Enter project title"
                                       maxlength="200">
                            </div>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="flex justify-center pt-6">
                        <button type="submit"
                                class="btn-zambian-primary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center">
                            <i class="fas fa-search mr-3"></i>
                            Check Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Professional Status Results -->
<section id="statusResults" class="py-20 bg-gray-50 hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Results Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-zambian-black mb-4">Application Status</h2>
            <p class="text-xl text-gray-600">Here's the current status of your CDF application</p>
        </div>

        <!-- Status Card -->
        <div id="statusCard" class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-8" data-aos="fade-up">
            <!-- Status Header -->
            <div id="statusHeader" class="px-8 py-6 bg-gradient-to-r from-green-50 to-orange-50 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h3 id="projectTitle" class="text-2xl font-bold text-zambian-black mb-2">Project Title</h3>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <span><i class="fas fa-hashtag text-green-500 mr-2"></i>ID: <span id="applicationId">CDF-2025-001234</span></span>
                            <span><i class="fas fa-calendar text-orange-500 mr-2"></i>Applied: <span id="applicationDate">Jan 15, 2025</span></span>
                            <span><i class="fas fa-user text-green-500 mr-2"></i>Applicant: <span id="applicantName">John Doe</span></span>
                        </div>
                    </div>
                    <div id="statusBadge" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold">
                        <i class="fas fa-clock mr-2"></i>Under Review
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="p-8">
                <h4 class="text-xl font-bold text-zambian-black mb-6">
                    <i class="fas fa-timeline text-green-500 mr-2"></i>Application Timeline
                </h4>

                <div id="statusTimeline" class="space-y-6">
                    <!-- Timeline items will be populated dynamically -->
                </div>
            </div>
        </div>

        <!-- Project Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Project Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8" data-aos="fade-up" data-aos-delay="100">
                <h4 class="text-xl font-bold text-zambian-black mb-6">
                    <i class="fas fa-info-circle text-green-500 mr-2"></i>Project Information
                </h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Category:</span>
                        <span id="projectCategory" class="font-semibold text-zambian-black">Infrastructure</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Ward:</span>
                        <span id="projectWard" class="font-semibold text-zambian-black">Ward 15</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Requested Amount:</span>
                        <span id="requestedAmount" class="font-semibold text-green-600">K 50,000</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Expected Beneficiaries:</span>
                        <span id="beneficiariesCount" class="font-semibold text-orange-600">500 people</span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8" data-aos="fade-up" data-aos-delay="200">
                <h4 class="text-xl font-bold text-zambian-black mb-6">
                    <i class="fas fa-steps text-orange-500 mr-2"></i>Next Steps
                </h4>
                <div id="nextSteps" class="space-y-4">
                    <!-- Next steps will be populated dynamically -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Help Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-3xl p-8" data-aos="fade-up">
            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-question-circle text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-zambian-black mb-4">Need Help?</h3>
            <p class="text-lg text-gray-600 mb-6">
                Can't find your application or need assistance? Our support team is here to help you track your CDF application.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center px-6 py-3 btn-zambian-primary text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-envelope mr-2"></i>Contact Support
                </a>
                <a href="tel:+260211123456"
                   class="inline-flex items-center px-6 py-3 border-2 border-orange-600 text-orange-600 rounded-xl font-semibold hover:bg-orange-600 hover:text-white transition-all duration-300">
                    <i class="fas fa-phone mr-2"></i>Call +260 211 123456
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Professional Status Checking System
document.addEventListener('DOMContentLoaded', function() {
    const statusForm = document.getElementById('statusForm');
    const statusResults = document.getElementById('statusResults');

    // Sample status data (replace with actual API call)
    const sampleStatuses = {
        'CDF-2025-001234': {
            id: 'CDF-2025-001234',
            title: 'Community Borehole Construction',
            applicant: 'John Banda',
            date: 'January 15, 2025',
            status: 'under-review',
            category: 'Water & Sanitation',
            ward: 'Ward 15, Chilenje',
            amount: 'K 75,000',
            beneficiaries: '500 people',
            timeline: [
                { step: 'Application Submitted', date: 'Jan 15, 2025', status: 'completed', icon: 'fa-paper-plane' },
                { step: 'Initial Review', date: 'Jan 18, 2025', status: 'completed', icon: 'fa-eye' },
                { step: 'Ward Committee Review', date: 'Jan 22, 2025', status: 'current', icon: 'fa-users' },
                { step: 'CDFC Approval', date: 'Pending', status: 'pending', icon: 'fa-check-circle' },
                { step: 'Implementation', date: 'Pending', status: 'pending', icon: 'fa-hammer' }
            ],
            nextSteps: [
                'Ward Development Committee is reviewing your application',
                'Site visit scheduled for January 25, 2025',
                'Community consultation meeting planned',
                'Expected decision by January 30, 2025'
            ]
        }
    };

    statusForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const applicationId = document.getElementById('application_id').value.trim().toUpperCase();
        const phoneNumber = document.getElementById('phone_number').value.trim();

        if (!applicationId && !phoneNumber) {
            showAlert('Please enter either an Application ID or Phone Number', 'error');
            return;
        }

        // Show loading state
        const submitBtn = statusForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Searching...';
        submitBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            const statusData = sampleStatuses[applicationId] || sampleStatuses['CDF-2025-001234'];
            displayStatusResults(statusData);

            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;

            // Scroll to results
            statusResults.scrollIntoView({ behavior: 'smooth' });
        }, 1500);
    });

    function displayStatusResults(data) {
        // Show results section
        statusResults.classList.remove('hidden');

        // Populate basic information
        document.getElementById('projectTitle').textContent = data.title;
        document.getElementById('applicationId').textContent = data.id;
        document.getElementById('applicationDate').textContent = data.date;
        document.getElementById('applicantName').textContent = data.applicant;

        // Set status badge
        const statusBadge = document.getElementById('statusBadge');
        const statusInfo = getStatusInfo(data.status);
        statusBadge.className = `inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold ${statusInfo.classes}`;
        statusBadge.innerHTML = `<i class="fas ${statusInfo.icon} mr-2"></i>${statusInfo.text}`;

        // Populate project details
        document.getElementById('projectCategory').textContent = data.category;
        document.getElementById('projectWard').textContent = data.ward;
        document.getElementById('requestedAmount').textContent = data.amount;
        document.getElementById('beneficiariesCount').textContent = data.beneficiaries;

        // Build timeline
        const timeline = document.getElementById('statusTimeline');
        timeline.innerHTML = data.timeline.map(item => `
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 w-12 h-12 ${getTimelineIconClass(item.status)} rounded-full flex items-center justify-center">
                    <i class="fas ${item.icon} text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <h5 class="text-lg font-semibold text-zambian-black">${item.step}</h5>
                        <span class="text-sm text-gray-500">${item.date}</span>
                    </div>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${getTimelineStatusClass(item.status)}">
                            ${getTimelineStatusText(item.status)}
                        </span>
                    </div>
                </div>
            </div>
        `).join('');

        // Build next steps
        const nextSteps = document.getElementById('nextSteps');
        nextSteps.innerHTML = data.nextSteps.map(step => `
            <div class="flex items-start space-x-3">
                <i class="fas fa-arrow-right text-orange-500 mt-1 flex-shrink-0"></i>
                <span class="text-gray-700">${step}</span>
            </div>
        `).join('');
    }

    function getStatusInfo(status) {
        const statuses = {
            'under-review': { text: 'Under Review', icon: 'fa-clock', classes: 'bg-orange-100 text-orange-800' },
            'approved': { text: 'Approved', icon: 'fa-check-circle', classes: 'bg-green-100 text-green-800' },
            'rejected': { text: 'Rejected', icon: 'fa-times-circle', classes: 'bg-red-100 text-red-800' },
            'in-progress': { text: 'In Progress', icon: 'fa-cog', classes: 'bg-blue-100 text-blue-800' },
            'completed': { text: 'Completed', icon: 'fa-check', classes: 'bg-green-100 text-green-800' }
        };
        return statuses[status] || statuses['under-review'];
    }

    function getTimelineIconClass(status) {
        const classes = {
            'completed': 'bg-green-500',
            'current': 'bg-orange-500',
            'pending': 'bg-gray-400'
        };
        return classes[status] || 'bg-gray-400';
    }

    function getTimelineStatusClass(status) {
        const classes = {
            'completed': 'bg-green-100 text-green-800',
            'current': 'bg-orange-100 text-orange-800',
            'pending': 'bg-gray-100 text-gray-800'
        };
        return classes[status] || 'bg-gray-100 text-gray-800';
    }

    function getTimelineStatusText(status) {
        const texts = {
            'completed': 'Completed',
            'current': 'In Progress',
            'pending': 'Pending'
        };
        return texts[status] || 'Pending';
    }

    function showAlert(message, type) {
        // Simple alert function (you can replace with a toast library)
        const alertClass = type === 'error' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800';
        const alert = document.createElement('div');
        alert.className = `fixed top-4 right-4 ${alertClass} px-4 py-2 rounded-lg shadow-lg z-50`;
        alert.textContent = message;
        document.body.appendChild(alert);

        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
});
</script>
@endpush
@endsection
