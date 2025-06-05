{{-- resources/views/public/apply.blade.php --}}
@extends('layouts.app')

@section('title', 'Apply for CDF Project - Submit Your Community Development Proposal')
@section('description', 'Submit your community development project proposal through our secure online application form. Get SMS updates and track your application status in real-time.')

@section('content')
<!-- Professional Hero Section with Zambian Colors -->
<section class="py-16 gradient-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up">
            Apply for a
            <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                CDF Project
            </span>
        </h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Transform your community by submitting a development project proposal. Our transparent process
            ensures your application is reviewed fairly and efficiently.
        </p>
    </div>
</section>

<!-- Professional Application Form -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 rounded-xl p-6 flex items-center" data-aos="fade-down">
            <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
            <div>
                <h3 class="text-green-800 font-semibold">Application Submitted Successfully!</h3>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-8 bg-red-50 border border-red-200 rounded-xl p-6 flex items-center" data-aos="fade-down">
            <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-4"></i>
            <div>
                <h3 class="text-red-800 font-semibold">Application Error</h3>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Professional Application Form -->
        <div class="card-zambian rounded-2xl overflow-hidden" data-aos="fade-up">
            <!-- Professional Progress Bar with Zambian Colors -->
            <div class="gradient-primary p-6">
                <div class="flex items-center justify-between text-white" x-data="{ step: 1 }">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center" :class="step >= 1 ? 'text-orange-300' : 'text-white/60'">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mr-2"
                                 :class="step >= 1 ? 'border-orange-300 bg-orange-400 text-white' : 'border-white/60'">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span class="font-medium hidden sm:block">Personal Info</span>
                        </div>

                        <div class="flex items-center" :class="step >= 2 ? 'text-orange-300' : 'text-white/60'">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mr-2"
                                 :class="step >= 2 ? 'border-orange-300 bg-orange-400 text-white' : 'border-white/60'">
                                <i class="fas fa-clipboard-list text-sm"></i>
                            </div>
                            <span class="font-medium hidden sm:block">Project Info</span>
                        </div>

                        <div class="flex items-center" :class="step >= 3 ? 'text-orange-300' : 'text-white/60'">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mr-2"
                                 :class="step >= 3 ? 'border-orange-300 bg-orange-400 text-white' : 'border-white/60'">
                                <i class="fas fa-info-circle text-sm"></i>
                            </div>
                            <span class="font-medium hidden sm:block">Details</span>
                        </div>

                        <div class="flex items-center" :class="step >= 4 ? 'text-orange-300' : 'text-white/60'">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mr-2"
                                 :class="step >= 4 ? 'border-orange-300 bg-orange-400 text-white' : 'border-white/60'">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span class="font-medium hidden sm:block">Review</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Form with Zambian Styling -->
            <form method="POST" action="{{ route('application.submit') }}" class="p-8 form-zambian" x-data="applicationForm()" x-init="init()">
                @csrf

                <!-- Step 1: Personal Information -->
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-zambian-black mb-6">Personal Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text"
                                   name="applicant_name"
                                   x-model="form.applicant_name"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Enter your full name"
                                   required>
                            @error('applicant_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel"
                                   name="applicant_phone"
                                   x-model="form.applicant_phone"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                   placeholder="e.g., 260975020473"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">SMS updates will be sent to this number</p>
                            @error('applicant_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email"
                                   name="applicant_email"
                                   x-model="form.applicant_email"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                   placeholder="your.email@example.com">
                            @error('applicant_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">National ID Number *</label>
                            <input type="text"
                                   name="applicant_id_number"
                                   x-model="form.applicant_id_number"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                   placeholder="123456/78/9"
                                   required>
                            @error('applicant_id_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                        <textarea name="applicant_address"
                                  x-model="form.applicant_address"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                  placeholder="Enter your complete address"
                                  required></textarea>
                        @error('applicant_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Step 2: Project Information -->
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-zambian-black mb-6">Project Information</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                            <input type="text"
                                   name="title"
                                   x-model="form.title"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                   placeholder="e.g., Community Borehole Project"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Category *</label>
                                <select name="category"
                                        x-model="form.category"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                        required>
                                    <option value="">Select category</option>
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
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ward *</label>
                                <select name="ward_id"
                                        x-model="form.ward_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                        required>
                                    <option value="">Select your ward</option>
                                    @foreach($wards as $ward)
                                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                    @endforeach
                                </select>
                                @error('ward_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Location *</label>
                            <input type="text"
                                   name="location"
                                   x-model="form.location"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Specific location where project will be implemented"
                                   required>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 3: Project Details -->
                <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-zambian-black mb-6">Project Details</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Description *</label>
                            <textarea name="description"
                                      x-model="form.description"
                                      rows="5"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Provide detailed description of your project, including objectives, activities, and expected outcomes"
                                      required></textarea>
                            <p class="mt-1 text-xs text-gray-500">Minimum 100 characters required</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Requested Amount (ZMW) *</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">K</span>
                                    <input type="number"
                                           name="requested_amount"
                                           x-model="form.requested_amount"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                           placeholder="50000"
                                           min="1000"
                                           max="500000"
                                           required>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Amount between K1,000 - K500,000</p>
                                @error('requested_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Number of Beneficiaries *</label>
                                <input type="number"
                                       name="beneficiaries_count"
                                       x-model="form.beneficiaries_count"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                       placeholder="500"
                                       min="1"
                                       required>
                                <p class="mt-1 text-xs text-gray-500">Estimated number of people who will benefit</p>
                                @error('beneficiaries_count')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Justification *</label>
                            <textarea name="justification"
                                      x-model="form.justification"
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Explain why this project is needed in your community and how it will address specific problems"
                                      required></textarea>
                            @error('justification')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level *</label>
                            <select name="priority"
                                    x-model="form.priority"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                    required>
                                <option value="">Select priority level</option>
                                <option value="High">High - Urgent community need</option>
                                <option value="Medium">Medium - Important but not urgent</option>
                                <option value="Low">Low - Can be delayed if necessary</option>
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 4: Review and Submit -->
                <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-zambian-black mb-6">Review Your Application</h2>

                    <div class="bg-green-50 rounded-xl p-6 space-y-6">
                        <!-- Personal Information Review -->
                        <div>
                            <h3 class="text-lg font-semibold text-zambian-black mb-3">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Name:</span>
                                    <span class="ml-2 font-medium" x-text="form.applicant_name"></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="ml-2 font-medium" x-text="form.applicant_phone"></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Email:</span>
                                    <span class="ml-2 font-medium" x-text="form.applicant_email || 'Not provided'"></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">ID Number:</span>
                                    <span class="ml-2 font-medium" x-text="form.applicant_id_number"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Project Information Review -->
                        <div class="border-t border-green-200 pt-6">
                            <h3 class="text-lg font-semibold text-zambian-black mb-3">Project Information</h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-gray-600">Title:</span>
                                    <span class="ml-2 font-medium" x-text="form.title"></span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-gray-600">Category:</span>
                                        <span class="ml-2 font-medium" x-text="form.category"></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Priority:</span>
                                        <span class="ml-2 font-medium" x-text="form.priority"></span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-gray-600">Requested Amount:</span>
                                    <span class="ml-2 font-medium">K<span x-text="parseInt(form.requested_amount || 0).toLocaleString()"></span></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Beneficiaries:</span>
                                    <span class="ml-2 font-medium" x-text="parseInt(form.beneficiaries_count || 0).toLocaleString()"></span> people
                                </div>
                            </div>
                        </div>

                        <!-- Professional Terms and Conditions -->
                        <div class="border-t border-green-200 pt-6">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox"
                                       id="terms"
                                       name="terms"
                                       x-model="form.terms"
                                       class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                       required>
                                {{-- <label for="terms" class="text-sm text-gray-700">
                                    I confirm that the information provided is accurate and complete. I understand that
                                    providing false information may result in disqualification. I agree to the
                                    <a href="{{ route('terms') }}" class="text-green-600 hover:text-green-700" target="_blank">terms and conditions</a>
                                    and <a href="{{ route('privacy') }}" class="text-green-600 hover:text-green-700" target="_blank">privacy policy</a>.
                                </label> --}}
                            </div>
                        </div>

                        <!-- Professional SMS Consent -->
                        <div class="bg-green-100 border border-green-300 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox"
                                       id="sms_consent"
                                       name="sms_consent"
                                       x-model="form.sms_consent"
                                       class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                       required>
                                <label for="sms_consent" class="text-sm text-green-800">
                                    <i class="fas fa-mobile-alt mr-2"></i>
                                    I consent to receive SMS notifications about my application status and important updates
                                    on the phone number provided above.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Navigation Buttons -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                    <button type="button"
                            @click="previousStep()"
                            x-show="currentStep > 1"
                            class="flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Previous
                    </button>

                    <div class="flex space-x-4">
                        <button type="button"
                                @click="saveProgress()"
                                class="flex items-center px-6 py-3 border border-green-300 text-green-600 rounded-lg hover:bg-green-50 transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Save Progress
                        </button>

                        <button type="button"
                                @click="nextStep()"
                                x-show="currentStep < 4"
                                class="flex items-center px-6 py-3 btn-zambian-primary rounded-lg transition-all duration-200">
                            Next
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <button type="submit"
                                x-show="currentStep === 4"
                                class="flex items-center px-8 py-3 btn-zambian-secondary rounded-lg font-semibold">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Application
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Professional Help Section -->
        <div class="mt-12 card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-xl font-bold text-zambian-black mb-6">Need Help?</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-green-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-zambian-black mb-2">Call Us</h4>
                    <p class="text-gray-600 text-sm">+260 975 020 473</p>
                    <p class="text-gray-500 text-xs">Mon-Fri, 8AM-5PM</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-orange-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-zambian-black mb-2">Email Support</h4>
                    <p class="text-gray-600 text-sm">info@cdfportal.gov.zm</p>
                    <p class="text-gray-500 text-xs">Response within 24 hours</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-question-circle text-green-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-zambian-black mb-2">Application Guide</h4>
                    <a href="#" class="text-green-600 hover:text-green-700 text-sm">Download PDF Guide</a>
                    <p class="text-gray-500 text-xs">Step-by-step instructions</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function applicationForm() {
    return {
        currentStep: 1,
        form: {
            applicant_name: '',
            applicant_phone: '',
            applicant_email: '',
            applicant_id_number: '',
            applicant_address: '',
            title: '',
            category: '',
            ward_id: '',
            location: '',
            description: '',
            requested_amount: '',
            beneficiaries_count: '',
            justification: '',
            priority: '',
            terms: false,
            sms_consent: false
        },

        init() {
            // Load saved progress from localStorage
            const saved = localStorage.getItem('cdf_application_draft');
            if (saved) {
                try {
                    this.form = { ...this.form, ...JSON.parse(saved) };
                } catch (e) {
                    console.log('Error loading saved form data');
                }
            }
        },

        nextStep() {
            if (this.validateCurrentStep()) {
                if (this.currentStep < 4) {
                    this.currentStep++;
                    this.saveProgress();
                }
            }
        },

        previousStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
            }
        },

        validateCurrentStep() {
            const step = this.currentStep;

            if (step === 1) {
                return this.form.applicant_name &&
                       this.form.applicant_phone &&
                       this.form.applicant_id_number &&
                       this.form.applicant_address;
            }

            if (step === 2) {
                return this.form.title &&
                       this.form.category &&
                       this.form.ward_id &&
                       this.form.location;
            }

            if (step === 3) {
                return this.form.description &&
                       this.form.requested_amount &&
                       this.form.beneficiaries_count &&
                       this.form.justification &&
                       this.form.priority;
            }

            return true;
        },

        saveProgress() {
            try {
                localStorage.setItem('cdf_application_draft', JSON.stringify(this.form));

                // Show professional save confirmation with Zambian styling
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300';
                notification.innerHTML = '<i class="fas fa-check mr-2"></i>Progress saved!';
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.transform = 'translateX(400px)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            } catch (e) {
                console.log('Error saving form data');
            }
        }
    }
}

// Professional auto-save form data every 30 seconds
setInterval(() => {
    const form = Alpine.$data(document.querySelector('[x-data="applicationForm()"]'));
    if (form) {
        form.saveProgress();
    }
}, 30000);

// Professional form enhancement
document.addEventListener('DOMContentLoaded', function() {
    // Add professional focus effects
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-green-500');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-green-500');
        });
    });

    // Professional form validation styling
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Add professional loading animation
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
                submitBtn.disabled = true;
            }
        });
    }
});
</script>
@endpush
@endsection{{-- resources/views/public/apply.blade.php --}}
@extends('layouts.app')

@section('title', 'Apply for CDF Project - Submit Your Community Development Proposal')
@section('description', 'Submit your community development project proposal through our secure online application form. Get SMS updates and track your application status in real-time.')

@section('content')
<!-- Hero Section -->
<section class="py-16 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up">
            Apply for a
            <span class="gradient-text bg-gradient-to-r from-yellow-400 to-pink-400 bg-clip-text text-transparent">
                CDF Project
            </span>
        </h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Transform your community by submitting a development project proposal. Our transparent process
            ensures your application is reviewed fairly and efficiently.
        </p>
    </div>
</section>

<!-- Application Form -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 rounded-xl p-6 flex items-center" data-aos="fade-down">
            <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
            <div>
                <h3 class="text-green-800 font-semibold">Application Submitted Successfully!</h3>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-8 bg-red-50 border border-red-200 rounded-xl p-6 flex items-center" data-aos="fade-down">
            <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-4"></i>
            <div>
                <h3 class="text-red-800 font-semibold">Application Error</h3>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Application Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden" data-aos="fade-up">
            <!-- Progress Bar -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                <div class="flex items-center justify-between text-white" x-data="{ step: 1 }">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center" :class="step >= 1 ? 'text-yellow-300' : 'text-white/60'">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mr-2"
                                 :class="step >= 1 ? 'border-yellow-300 bg-yellow-300 text-gray-900' : 'border-white/60'">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span class="font-medium hidden sm:block">Personal Info</span>
                        </div>

                        <div class="flex items-center" :class="step >= 2 ? 'text-yellow-300' : 'text-white/60'">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mr-2"
                                 :class="step >= 2 ? 'border-yellow-300 bg-yellow-300 text-gray-900' : 'border-white/60'">
                                <i class="fas fa-clipboard-list text-sm"></i>
                            </div>
                            <span class="font-medium hidden sm:block">Project Info</span>
                        </div>

                        <div class="flex items-center" :class="step >= 3 ? 'text-yellow-300' : 'text-white/60'">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mr-2"
                                 :class="step >= 3 ? 'border-yellow-300 bg-yellow-300 text-gray-900' : 'border-white/60'">
                                <i class="fas fa-info-circle text-sm"></i>
                            </div>
                            <span class="font-medium hidden sm:block">Details</span>
                        </div>

                        <div class="flex items-center" :class="step >= 4 ? 'text-yellow-300' : 'text-white/60'">
                            <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center mr-2"
                                 :class="step >= 4 ? 'border-yellow-300 bg-yellow-300 text-gray-900' : 'border-white/60'">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span class="font-medium hidden sm:block">Review</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('application.submit') }}" class="p-8" x-data="applicationForm()" x-init="init()">
                @csrf

                <!-- Step 1: Personal Information -->
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Personal Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text"
                                   name="applicant_name"
                                   x-model="form.applicant_name"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Enter your full name"
                                   required>
                            @error('applicant_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel"
                                   name="applicant_phone"
                                   x-model="form.applicant_phone"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="e.g., 260975020473"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">SMS updates will be sent to this number</p>
                            @error('applicant_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email"
                                   name="applicant_email"
                                   x-model="form.applicant_email"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="your.email@example.com">
                            @error('applicant_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">National ID Number *</label>
                            <input type="text"
                                   name="applicant_id_number"
                                   x-model="form.applicant_id_number"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="123456/78/9"
                                   required>
                            @error('applicant_id_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                        <textarea name="applicant_address"
                                  x-model="form.applicant_address"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                  placeholder="Enter your complete address"
                                  required></textarea>
                        @error('applicant_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Step 2: Project Information -->
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Project Information</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Title *</label>
                            <input type="text"
                                   name="title"
                                   x-model="form.title"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="e.g., Community Borehole Project"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Category *</label>
                                <select name="category"
                                        x-model="form.category"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                        required>
                                    <option value="">Select category</option>
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
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ward *</label>
                                <select name="ward_id"
                                        x-model="form.ward_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                        required>
                                    <option value="">Select your ward</option>
                                    @foreach($wards as $ward)
                                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                    @endforeach
                                </select>
                                @error('ward_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Location *</label>
                            <input type="text"
                                   name="location"
                                   x-model="form.location"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Specific location where project will be implemented"
                                   required>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 3: Project Details -->
                <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Project Details</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Description *</label>
                            <textarea name="description"
                                      x-model="form.description"
                                      rows="5"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Provide detailed description of your project, including objectives, activities, and expected outcomes"
                                      required></textarea>
                            <p class="mt-1 text-xs text-gray-500">Minimum 100 characters required</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Requested Amount (ZMW) *</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">K</span>
                                    <input type="number"
                                           name="requested_amount"
                                           x-model="form.requested_amount"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                           placeholder="50000"
                                           min="1000"
                                           max="500000"
                                           required>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Amount between K1,000 - K500,000</p>
                                @error('requested_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Number of Beneficiaries *</label>
                                <input type="number"
                                       name="beneficiaries_count"
                                       x-model="form.beneficiaries_count"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                       placeholder="500"
                                       min="1"
                                       required>
                                <p class="mt-1 text-xs text-gray-500">Estimated number of people who will benefit</p>
                                @error('beneficiaries_count')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Justification *</label>
                            <textarea name="justification"
                                      x-model="form.justification"
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Explain why this project is needed in your community and how it will address specific problems"
                                      required></textarea>
                            @error('justification')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level *</label>
                            <select name="priority"
                                    x-model="form.priority"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                    required>
                                <option value="">Select priority level</option>
                                <option value="High">High - Urgent community need</option>
                                <option value="Medium">Medium - Important but not urgent</option>
                                <option value="Low">Low - Can be delayed if necessary</option>
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 4: Review and Submit -->
                <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Review Your Application</h2>

                    <div class="bg-gray-50 rounded-xl p-6 space-y-6">
                        <!-- Personal Information Review -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Name:</span>
                                    <span class="ml-2 font-medium" x-text="form.applicant_name"></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="ml-2 font-medium" x-text="form.applicant_phone"></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Email:</span>
                                    <span class="ml-2 font-medium" x-text="form.applicant_email || 'Not provided'"></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">ID Number:</span>
                                    <span class="ml-2 font-medium" x-text="form.applicant_id_number"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Project Information Review -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Project Information</h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-gray-600">Title:</span>
                                    <span class="ml-2 font-medium" x-text="form.title"></span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-gray-600">Category:</span>
                                        <span class="ml-2 font-medium" x-text="form.category"></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Priority:</span>
                                        <span class="ml-2 font-medium" x-text="form.priority"></span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-gray-600">Requested Amount:</span>
                                    <span class="ml-2 font-medium">K<span x-text="parseInt(form.requested_amount || 0).toLocaleString()"></span></span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Beneficiaries:</span>
                                    <span class="ml-2 font-medium" x-text="parseInt(form.beneficiaries_count || 0).toLocaleString()"></span> people
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox"
                                       id="terms"
                                       name="terms"
                                       x-model="form.terms"
                                       class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                       required>
                                <label for="terms" class="text-sm text-gray-700">
                                    I confirm that the information provided is accurate and complete. I understand that
                                    providing false information may result in disqualification. I agree to the
                                    <a href="{{ route('terms') }}" class="text-indigo-600 hover:text-indigo-700" target="_blank">terms and conditions</a>
                                    and <a href="{{ route('privacy') }}" class="text-indigo-600 hover:text-indigo-700" target="_blank">privacy policy</a>.
                                </label>
                            </div>
                        </div>

                        <!-- SMS Consent -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox"
                                       id="sms_consent"
                                       name="sms_consent"
                                       x-model="form.sms_consent"
                                       class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                       required>
                                <label for="sms_consent" class="text-sm text-blue-800">
                                    <i class="fas fa-mobile-alt mr-2"></i>
                                    I consent to receive SMS notifications about my application status and important updates
                                    on the phone number provided above.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                    <button type="button"
                            @click="previousStep()"
                            x-show="currentStep > 1"
                            class="flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Previous
                    </button>

                    <div class="flex space-x-4">
                        <button type="button"
                                @click="saveProgress()"
                                class="flex items-center px-6 py-3 border border-indigo-300 text-indigo-600 rounded-lg hover:bg-indigo-50 transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Save Progress
                        </button>

                        <button type="button"
                                @click="nextStep()"
                                x-show="currentStep < 4"
                                class="flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-200">
                            Next
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <button type="submit"
                                x-show="currentStep === 4"
                                class="flex items-center px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 font-semibold">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Application
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-12 bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Need Help?</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-blue-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Call Us</h4>
                    <p class="text-gray-600 text-sm">+260 975 020 473</p>
                    <p class="text-gray-500 text-xs">Mon-Fri, 8AM-5PM</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-green-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Email Support</h4>
                    <p class="text-gray-600 text-sm">info@cdfportal.gov.zm</p>
                    <p class="text-gray-500 text-xs">Response within 24 hours</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-question-circle text-purple-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Application Guide</h4>
                    <a href="#" class="text-purple-600 hover:text-purple-700 text-sm">Download PDF Guide</a>
                    <p class="text-gray-500 text-xs">Step-by-step instructions</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function applicationForm() {
    return {
        currentStep: 1,
        form: {
            applicant_name: '',
            applicant_phone: '',
            applicant_email: '',
            applicant_id_number: '',
            applicant_address: '',
            title: '',
            category: '',
            ward_id: '',
            location: '',
            description: '',
            requested_amount: '',
            beneficiaries_count: '',
            justification: '',
            priority: '',
            terms: false,
            sms_consent: false
        },

        init() {
            // Load saved progress from localStorage
            const saved = localStorage.getItem('cdf_application_draft');
            if (saved) {
                try {
                    this.form = { ...this.form, ...JSON.parse(saved) };
                } catch (e) {
                    console.log('Error loading saved form data');
                }
            }
        },

        nextStep() {
            if (this.validateCurrentStep()) {
                if (this.currentStep < 4) {
                    this.currentStep++;
                    this.saveProgress();
                }
            }
        },

        previousStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
            }
        },

        validateCurrentStep() {
            const step = this.currentStep;

            if (step === 1) {
                return this.form.applicant_name &&
                       this.form.applicant_phone &&
                       this.form.applicant_id_number &&
                       this.form.applicant_address;
            }

            if (step === 2) {
                return this.form.title &&
                       this.form.category &&
                       this.form.ward_id &&
                       this.form.location;
            }

            if (step === 3) {
                return this.form.description &&
                       this.form.requested_amount &&
                       this.form.beneficiaries_count &&
                       this.form.justification &&
                       this.form.priority;
            }

            return true;
        },

        saveProgress() {
            try {
                localStorage.setItem('cdf_application_draft', JSON.stringify(this.form));

                // Show save confirmation
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                notification.innerHTML = '<i class="fas fa-check mr-2"></i>Progress saved!';
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            } catch (e) {
                console.log('Error saving form data');
            }
        }
    }
}

// Auto-save form data every 30 seconds
setInterval(() => {
    const form = Alpine.$data(document.querySelector('[x-data="applicationForm()"]'));
    if (form) {
        form.saveProgress();
    }
}, 30000);
</script>
@endpush
@endsection
