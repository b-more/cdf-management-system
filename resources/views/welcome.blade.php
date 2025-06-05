<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        // Utility Functions
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
        }

        function closeModal() {
            document.getElementById('successModal').classList.add('hidden');
            document.getElementById('successModal').classList.remove('flex');
        }

        // SMS Service Function
        async function sendSMS(phone, message) {
            try {
                const encodedMessage = encodeURIComponent(message);
                const url = `https://www.cloudservicezm.com/smsservice/httpapi?username=Blessmore&password=Blessmore&msg=${encodedMessage}&shortcode=2343&sender_id=BLESSMORE&phone=${phone}&api_key=121231313213123123`;

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Cookie': 'MUTUMIKI=us0kovmvlpga3vpdf5dl1uclih'
                    }
                });

                return response.ok;
            } catch (error) {
                console.error('SMS Error:', error);
                return false;
            }
        }

        // Application Form Alpine.js Component
        function applicationForm() {
            return {
                currentStep: 1,
                isSubmitting: false,
                termsAccepted: false,
                formData: {
                    fullName: '',
                    phone: '',
                    email: '',
                    nationalId: '',
                    address: '',
                    projectType: '',
                    projectTitle: '',
                    category: '',
                    ward: '',
                    description: '',
                    requestedAmount: '',
                    beneficiaries: '',
                    duration: '',
                    priority: '',
                    location: '',
                    outcomes: ''
                },

                nextStep() {
                    if (this.validateCurrentStep()) {
                        if (this.currentStep < 4) {
                            this.currentStep++;
                        }
                    }
                },

                previousStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                    }
                },

                validateCurrentStep() {
                    let isValid = true;
                    const requiredFields = this.getRequiredFieldsForStep(this.currentStep);

                    requiredFields.forEach(field => {
                        if (!this.formData[field] || this.formData[field].trim() === '') {
                            isValid = false;
                            // Highlight invalid field
                            const input = document.querySelector(`[x-model="formData.${field}"]`);
                            if (input) {
                                input.classList.add('border-red-500');
                                setTimeout(() => input.classList.remove('border-red-500'), 3000);
                            }
                        }
                    });

                    if (!isValid) {
                        this.showNotification('Please fill in all required fields', 'error');
                    }

                    return isValid;
                },

                getRequiredFieldsForStep(step) {
                    const requiredByStep = {
                        1: ['fullName', 'phone', 'nationalId', 'address'],
                        2: ['projectType', 'projectTitle', 'category', 'ward', 'description'],
                        3: ['requestedAmount', 'beneficiaries', 'priority', 'location'],
                        4: []
                    };
                    return requiredByStep[step] || [];
                },

                async submitApplication() {
                    if (!this.termsAccepted) {
                        this.showNotification('Please accept the terms and conditions', 'error');
                        return;
                    }

                    this.isSubmitting = true;

                    try {
                        // Generate application ID
                        const applicationId = 'CDF-' + Date.now() + '-' + Math.random().toString(36).substr(2, 4).toUpperCase();

                        // Save to localStorage (in real app, this would go to your backend)
                        const applicationData = {
                            id: applicationId,
                            ...this.formData,
                            status: 'Submitted',
                            submittedAt: new Date().toISOString(),
                            lastUpdated: new Date().toISOString()
                        };

                        // Get existing applications or create new array
                        const existingApps = JSON.parse(localStorage.getItem('cdfApplications') || '[]');
                        existingApps.push(applicationData);
                        localStorage.setItem('cdfApplications', JSON.stringify(existingApps));

                        // Send SMS notification
                        const smsMessage = `CDF APPLICATION: Your application "${this.formData.projectTitle}" has been submitted successfully. Application ID: ${applicationId}. You will receive updates on this number.`;

                        const smsSuccess = await sendSMS(this.formData.phone, smsMessage);

                        // Show success modal
                        document.getElementById('applicationId').textContent = applicationId;
                        document.getElementById('successModal').classList.remove('hidden');
                        document.getElementById('successModal').classList.add('flex');

                        // Reset form
                        this.resetForm();

                        // Send confirmation SMS in background
                        if (smsSuccess) {
                            console.log('SMS sent successfully');
                        } else {
                            console.log('SMS failed, but application was saved');
                        }

                    } catch (error) {
                        console.error('Submission error:', error);
                        this.showNotification('Submission failed. Please try again.', 'error');
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                resetForm() {
                    this.currentStep = 1;
                    this.termsAccepted = false;
                    this.formData = {
                        fullName: '',
                        phone: '',
                        email: '',
                        nationalId: '',
                        address: '',
                        projectType: '',
                        projectTitle: '',
                        category: '',
                        ward: '',
                        description: '',
                        requestedAmount: '',
                        beneficiaries: '',
                        duration: '',
                        priority: '',
                        location: '',
                        outcomes: ''
                    };
                },

                showNotification(message, type = 'info') {
                    // Create notification element
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${
                        type === 'error' ? 'bg-red-500' : 'bg-green-500'
                    }`;
                    notification.textContent = message;

                    document.body.appendChild(notification);

                    // Remove after 3 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }
            }
        }

        // Status Checker Alpine.js Component
        function statusChecker() {
            return {
                searchQuery: '',
                isSearching: false,
                statusResults: [],
                noResults: false,

                async checkStatus() {
                    this.isSearching = true;
                    this.statusResults = [];
                    this.noResults = false;

                    try {
                        // Get applications from localStorage (in real app, this would be an API call)
                        const applications = JSON.parse(localStorage.getItem('cdfApplications') || '[]');

                        // Search by phone number or application ID
                        const results = applications.filter(app => {
                            const query = this.searchQuery.toLowerCase();
                            return app.phone.includes(query) ||
                                   app.id.toLowerCase().includes(query) ||
                                   app.fullName.toLowerCase().includes(query);
                        });

                        if (results.length > 0) {
                            this.statusResults = results.map(app => ({
                                id: app.id,
                                title: app.projectTitle,
                                status: this.getRandomStatus(), // In real app, this would come from database
                                date: new Date(app.submittedAt).toLocaleDateString(),
                                amount: parseFloat(app.requestedAmount)
                            }));
                        } else {
                            this.noResults = true;
                        }

                    } catch (error) {
                        console.error('Status check error:', error);
                        this.showNotification('Error checking status. Please try again.', 'error');
                    } finally {
                        this.isSearching = false;
                    }
                },

                getRandomStatus() {
                    const statuses = ['Submitted', 'Under Review', 'WDC Review', 'CDFC Review', 'Approved', 'In Progress'];
                    return statuses[Math.floor(Math.random() * statuses.length)];
                },

                getStatusColor(status) {
                    const colors = {
                        'Submitted': 'bg-blue-100 text-blue-800',
                        'Under Review': 'bg-yellow-100 text-yellow-800',
                        'WDC Review': 'bg-orange-100 text-orange-800',
                        'CDFC Review': 'bg-purple-100 text-purple-800',
                        'Approved': 'bg-green-100 text-green-800',
                        'In Progress': 'bg-indigo-100 text-indigo-800',
                        'Completed': 'bg-green-100 text-green-800',
                        'Rejected': 'bg-red-100 text-red-800'
                    };
                    return colors[status] || 'bg-gray-100 text-gray-800';
                },

                showNotification(message, type = 'info') {
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${
                        type === 'error' ? 'bg-red-500' : 'bg-green-500'
                    }`;
                    notification.textContent = message;

                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }
            }
        }

        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.createElement('div');
            mobileMenu.className = 'md:hidden bg-white border-t border-gray-200 hidden';
            mobileMenu.innerHTML = `
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="#home" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Home</a>
                    <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">About</a>
                    <a href="#apply" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Apply</a>
                    <a href="#status" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Check Status</a>
                    <a href="/admin" class="block px-3 py-2 bg-indigo-600 text-white rounded-md">Admin Login</a>
                </div>
            `;

            mobileMenuButton.parentNode.parentNode.appendChild(mobileMenu);

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });

        // Smooth scrolling for anchor links
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' && e.target.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const targetId = e.target.getAttribute('href').substring(1);
                const target = document.getElementById(targetId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });

        // Add some demo data for testing
        document.addEventListener('DOMContentLoaded', function() {
            // Add demo applications if none exist
            const existingApps = JSON.parse(localStorage.getItem('cdfApplications') || '[]');

            if (existingApps.length === 0) {
                const demoApps = [
                    {
                        id: 'CDF-DEMO-001',
                        fullName: 'John Mulenga',
                        phone: '260977123456',
                        projectTitle: 'Community Borehole Project',
                        projectType: 'community',
                        category: 'Water & Sanitation',
                        ward: 'Chilenje',
                        requestedAmount: '150000',
                        status: 'Under Review',
                        submittedAt: new Date(Date.now() - 86400000 * 5).toISOString() // 5 days ago
                    },
                    {
                        id: 'CDF-DEMO-002',
                        fullName: 'Mary Banda',
                        phone: '260966789012',
                        projectTitle: 'Youth Skills Training Center',
                        projectType: 'community',
                        category: 'Youth Development',
                        ward: 'Matero',
                        requestedAmount: '200000',
                        status: 'WDC Review',
                        submittedAt: new Date(Date.now() - 86400000 * 3).toISOString() // 3 days ago
                    }
                ];

                localStorage.setItem('cdfApplications', JSON.stringify(demoApps));
            }
        });

        // Simulate status updates via SMS (for demo purposes)
        async function simulateStatusUpdate(applicationId, newStatus, phone) {
            const message = `CDF UPDATE: Your application ${applicationId} status has been updated to: ${newStatus}. Thank you for your patience.`;
            return await sendSMS(phone, message);
        }

        // Add some animations
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.gradient-bg');
            const speed = scrolled * 0.5;

            if (parallax) {
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });
    </script>

</body>
</html><meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CDF Management System - Apply for Development Funds</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-morphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-indigo-600">CDF Portal</h1>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">About</a>
                    <a href="#apply" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Apply</a>
                    <a href="#status" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Check Status</a>
                    <a href="/admin" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Admin Login</a>
                </div>
                <div class="md:hidden flex items-center">
                    <button class="mobile-menu-button">
                        <i class="fas fa-bars text-gray-700"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="gradient-bg pt-20 pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in">
                    Constituency Development Fund
                    <span class="block text-yellow-300">Management System</span>
                </h1>
                <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto">
                    Apply for community development projects, track your applications, and build a better future for your constituency.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="scrollToSection('apply')" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-yellow-300 transition-all transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Apply Now
                    </button>
                    <button onclick="scrollToSection('status')" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-gray-900 transition-all">
                        <i class="fas fa-search mr-2"></i>
                        Check Status
                    </button>
                </div>
            </div>

            <!-- Floating Elements -->
            <div class="absolute top-20 left-10 animate-float">
                <div class="w-20 h-20 bg-yellow-400 rounded-full opacity-20"></div>
            </div>
            <div class="absolute top-40 right-20 animate-float" style="animation-delay: -2s;">
                <div class="w-16 h-16 bg-white rounded-full opacity-10"></div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">About CDF</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    The Constituency Development Fund empowers communities to initiate and implement development projects that improve their quality of life.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-lg hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Community Projects</h3>
                    <p class="text-gray-600">Support infrastructure, education, health, and social development initiatives in your community.</p>
                </div>

                <div class="text-center p-6 rounded-lg hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Emergency Response</h3>
                    <p class="text-gray-600">Quick funding for disaster response and emergency community needs.</p>
                </div>

                <div class="text-center p-6 rounded-lg hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Empowerment Programs</h3>
                    <p class="text-gray-600">Skills training, capacity building, and empowerment initiatives for community members.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form Section -->
    <section id="apply" class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Apply for CDF Funding</h2>
                <p class="text-xl text-gray-600">Submit your project proposal and get instant SMS notifications on status updates.</p>
            </div>

            <div class="bg-white rounded-xl shadow-xl p-8" x-data="applicationForm()">
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">Step <span x-text="currentStep"></span> of 4</span>
                        <span class="text-sm text-gray-600" x-text="Math.round((currentStep / 4) * 100) + '%'"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300"
                             :style="'width: ' + (currentStep / 4) * 100 + '%'"></div>
                    </div>
                </div>

                <form @submit.prevent="submitApplication()">
                    <!-- Step 1: Personal Information -->
                    <div class="form-step" :class="{ 'active': currentStep === 1 }">
                        <h3 class="text-2xl font-bold mb-6 text-center">Personal Information</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" x-model="formData.fullName" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" x-model="formData.phone" required
                                       pattern="[0-9+\-\s]+" placeholder="260977123456"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" x-model="formData.email"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">National ID *</label>
                                <input type="text" x-model="formData.nationalId" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                                <textarea x-model="formData.address" required rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Project Information -->
                    <div class="form-step" :class="{ 'active': currentStep === 2 }">
                        <h3 class="text-2xl font-bold mb-6 text-center">Project Information</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Type *</label>
                                <select x-model="formData.projectType" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Select Project Type</option>
                                    <option value="community">Community Development</option>
                                    <option value="disaster">Emergency/Disaster Response</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                                <input type="text" x-model="formData.projectTitle" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Category *</label>
                                <select x-model="formData.category" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Select Category</option>
                                    <option value="Infrastructure">Infrastructure</option>
                                    <option value="Education">Education</option>
                                    <option value="Health">Health</option>
                                    <option value="Water & Sanitation">Water & Sanitation</option>
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Youth Development">Youth Development</option>
                                    <option value="Women Empowerment">Women Empowerment</option>
                                    <option value="Sports & Culture">Sports & Culture</option>
                                    <option value="Environment">Environment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ward *</label>
                                <select x-model="formData.ward" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Select Ward</option>
                                    <option value="Chilenje">Chilenje</option>
                                    <option value="Kabulonga">Kabulonga</option>
                                    <option value="Garden">Garden</option>
                                    <option value="Matero">Matero</option>
                                    <option value="Chawama">Chawama</option>
                                    <option value="Kabwata">Kabwata</option>
                                    <option value="Kalingalinga">Kalingalinga</option>
                                    <option value="Mtendere">Mtendere</option>
                                    <option value="Chelstone">Chelstone</option>
                                    <option value="Kamwala">Kamwala</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Description *</label>
                                <textarea x-model="formData.description" required rows="4"
                                          placeholder="Describe your project, its objectives, and expected outcomes..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Project Details -->
                    <div class="form-step" :class="{ 'active': currentStep === 3 }">
                        <h3 class="text-2xl font-bold mb-6 text-center">Project Details</h3>
                        <div class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Requested Amount (ZMW) *</label>
                                    <input type="number" x-model="formData.requestedAmount" required min="1000" max="500000"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Beneficiaries Count *</label>
                                    <input type="number" x-model="formData.beneficiaries" required min="1"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Project Duration (Months)</label>
                                    <input type="number" x-model="formData.duration" min="1" max="60"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level *</label>
                                    <select x-model="formData.priority" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">Select Priority</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                        <option value="Critical">Critical</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Location *</label>
                                <input type="text" x-model="formData.location" required
                                       placeholder="Specific location where the project will be implemented"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Expected Outcomes</label>
                                <textarea x-model="formData.outcomes" rows="3"
                                          placeholder="What are the expected results and impact of this project?"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Review & Submit -->
                    <div class="form-step" :class="{ 'active': currentStep === 4 }">
                        <h3 class="text-2xl font-bold mb-6 text-center">Review & Submit</h3>
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h4 class="font-semibold mb-4">Application Summary</h4>
                            <div class="grid md:grid-cols-2 gap-4 text-sm">
                                <div><strong>Applicant:</strong> <span x-text="formData.fullName"></span></div>
                                <div><strong>Phone:</strong> <span x-text="formData.phone"></span></div>
                                <div><strong>Project:</strong> <span x-text="formData.projectTitle"></span></div>
                                <div><strong>Type:</strong> <span x-text="formData.projectType"></span></div>
                                <div><strong>Category:</strong> <span x-text="formData.category"></span></div>
                                <div><strong>Ward:</strong> <span x-text="formData.ward"></span></div>
                                <div><strong>Amount:</strong> ZMW <span x-text="formData.requestedAmount?.toLocaleString()"></span></div>
                                <div><strong>Beneficiaries:</strong> <span x-text="formData.beneficiaries"></span></div>
                            </div>
                        </div>

                        <div class="border-l-4 border-blue-500 pl-4 mb-6">
                            <h4 class="font-semibold text-blue-700 mb-2">SMS Notifications</h4>
                            <p class="text-sm text-gray-600">
                                You will receive SMS updates on your application status at <strong x-text="formData.phone"></strong>
                            </p>
                        </div>

                        <div class="flex items-center mb-6">
                            <input type="checkbox" x-model="termsAccepted" required class="mr-3">
                            <label class="text-sm text-gray-700">
                                I agree to the <a href="#" class="text-indigo-600 hover:underline">terms and conditions</a>
                                and confirm that all information provided is accurate.
                            </label>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-8">
                        <button type="button" @click="previousStep()" x-show="currentStep > 1"
                                class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-all">
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </button>
                        <div x-show="currentStep < 4">
                            <button type="button" @click="nextStep()"
                                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all ml-auto">
                                Next<i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                        <div x-show="currentStep === 4">
                            <button type="submit" :disabled="isSubmitting || !termsAccepted"
                                    class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!isSubmitting">
                                    <i class="fas fa-paper-plane mr-2"></i>Submit Application
                                </span>
                                <span x-show="isSubmitting">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>Submitting...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Status Check Section -->
    <section id="status" class="py-20 bg-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Check Application Status</h2>
                <p class="text-xl text-gray-600">Enter your phone number or application ID to check the status of your application.</p>
            </div>

            <div class="bg-white rounded-xl shadow-xl p-8" x-data="statusChecker()">
                <form @submit.prevent="checkStatus()">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number or Application ID</label>
                        <input type="text" x-model="searchQuery" required
                               placeholder="Enter phone number (260977123456) or Application ID"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <button type="submit" :disabled="isSearching"
                            class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-all disabled:opacity-50">
                        <span x-show="!isSearching">
                            <i class="fas fa-search mr-2"></i>Check Status
                        </span>
                        <span x-show="isSearching">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Searching...
                        </span>
                    </button>
                </form>

                <!-- Status Results -->
                <div x-show="statusResults.length > 0" class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Application Status</h3>
                    <template x-for="result in statusResults" :key="result.id">
                        <div class="border rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-medium" x-text="result.title"></h4>
                                <span class="px-3 py-1 rounded-full text-sm"
                                      :class="getStatusColor(result.status)"
                                      x-text="result.status"></span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Application ID: <span x-text="result.id"></span></p>
                            <p class="text-sm text-gray-600 mb-2">Submitted: <span x-text="result.date"></span></p>
                            <p class="text-sm text-gray-600">Amount: ZMW <span x-text="result.amount?.toLocaleString()"></span></p>
                        </div>
                    </template>
                </div>

                <div x-show="noResults" class="mt-8 text-center text-gray-500">
                    <i class="fas fa-search text-4xl mb-4"></i>
                    <p>No applications found for the provided information.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">CDF Portal</h3>
                    <p class="text-gray-400">Empowering communities through transparent and efficient fund management.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#home" class="hover:text-white">Home</a></li>
                        <li><a href="#about" class="hover:text-white">About</a></li>
                        <li><a href="#apply" class="hover:text-white">Apply</a></li>
                        <li><a href="#status" class="hover:text-white">Check Status</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Project Types</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Infrastructure</li>
                        <li>Education</li>
                        <li>Health</li>
                        <li>Agriculture</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-phone mr-2"></i>+260 XXX XXX XXX</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@cdfportal.zm</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Lusaka, Zambia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 CDF Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-8 max-w-md mx-4">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Application Submitted!</h3>
                <p class="text-gray-600 mb-4">Your application has been successfully submitted. You will receive SMS updates on your phone.</p>
                <p class="text-sm text-gray-500 mb-6">Application ID: <span id="applicationId" class="font-mono"></span></p>
                <button onclick="closeModal()" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Close
                </button>
            </div>
        </div>
    </div>
</body>
