{{-- resources/views/public/legal/terms.blade.php --}}
@extends('layouts.app')

@section('title', 'Terms and Conditions - CDF Portal Zambia')
@section('description', 'Terms and conditions for using the CDF portal. Understand your rights and responsibilities when applying for community development funding.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-16 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">
                Terms &
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Conditions
                </span>
            </h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Please read these terms and conditions carefully before using the CDF portal. Your use of our services constitutes acceptance of these terms.
            </p>
            <div class="mt-6 text-gray-200" data-aos="fade-up" data-aos-delay="400">
                <p class="text-sm">Last updated: January 15, 2025</p>
            </div>
        </div>
    </div>
</section>

<!-- Professional Terms Content -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Introduction -->
        <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-3xl p-8 mb-12" data-aos="fade-up">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-contract text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-zambian-black mb-4">Agreement to Terms</h2>
                    <p class="text-gray-700 leading-relaxed">
                        By accessing and using the Constituency Development Fund (CDF) Portal, you agree to be bound by these Terms and Conditions.
                        If you do not agree to these terms, please do not use our services.
                    </p>
                </div>
            </div>
        </div>

        <!-- Table of Contents -->
        <div class="bg-gray-50 rounded-2xl p-6 mb-12" data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-xl font-bold text-zambian-black mb-4">
                <i class="fas fa-list text-green-500 mr-2"></i>Contents
            </h3>
            <nav class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <a href="#definitions" class="text-green-600 hover:text-green-700 py-1">1. Definitions</a>
                <a href="#eligibility" class="text-green-600 hover:text-green-700 py-1">2. Eligibility</a>
                <a href="#user-responsibilities" class="text-green-600 hover:text-green-700 py-1">3. User Responsibilities</a>
                <a href="#application-process" class="text-green-600 hover:text-green-700 py-1">4. Application Process</a>
                <a href="#prohibited-uses" class="text-green-600 hover:text-green-700 py-1">5. Prohibited Uses</a>
                <a href="#intellectual-property" class="text-green-600 hover:text-green-700 py-1">6. Intellectual Property</a>
                <a href="#limitation-liability" class="text-green-600 hover:text-green-700 py-1">7. Limitation of Liability</a>
                <a href="#modifications" class="text-green-600 hover:text-green-700 py-1">8. Modifications</a>
            </nav>
        </div>

        <!-- Terms Content -->
        <div class="prose prose-lg max-w-none">

            <!-- Definitions -->
            <div id="definitions" class="mb-12" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">1</span>
                    </span>
                    Definitions
                </h3>

                <div class="bg-gray-50 rounded-2xl p-6">
                    <div class="space-y-4">
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-semibold text-zambian-black">"CDF Portal" or "Portal"</h4>
                            <p class="text-gray-700">Refers to the online platform for Constituency Development Fund applications and management.</p>
                        </div>
                        <div class="border-l-4 border-orange-500 pl-4">
                            <h4 class="font-semibold text-zambian-black">"User" or "You"</h4>
                            <p class="text-gray-700">Any individual or organization using the CDF Portal services.</p>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-semibold text-zambian-black">"Services"</h4>
                            <p class="text-gray-700">All features, tools, and functionalities provided through the CDF Portal.</p>
                        </div>
                        <div class="border-l-4 border-orange-500 pl-4">
                            <h4 class="font-semibold text-zambian-black">"Application"</h4>
                            <p class="text-gray-700">A formal request for CDF funding submitted through the portal.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Eligibility -->
            <div id="eligibility" class="mb-12" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">2</span>
                    </span>
                    Eligibility
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-green-50 rounded-2xl p-6">
                        <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-user-check text-green-500 mr-2"></i>Who Can Apply
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li>• Zambian citizens over 18 years</li>
                            <li>• Registered community organizations</li>
                            <li>• Ward Development Committees</li>
                            <li>• Recognized community groups</li>
                            <li>• Educational institutions</li>
                            <li>• Healthcare facilities</li>
                        </ul>
                    </div>

                    <div class="bg-orange-50 rounded-2xl p-6">
                        <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>Requirements
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li>• Valid identification documents</li>
                            <li>• Proof of community representation</li>
                            <li>• Technical and financial capacity</li>
                            <li>• Compliance with legal requirements</li>
                            <li>• Environmental impact assessment</li>
                            <li>• Community support documentation</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- User Responsibilities -->
            <div id="user-responsibilities" class="mb-12" data-aos="fade-up" data-aos-delay="400">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">3</span>
                    </span>
                    User Responsibilities
                </h3>

                <div class="space-y-6">
                    <div class="border border-green-200 rounded-2xl p-6 bg-green-50">
                        <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-clipboard-check text-green-500 mr-2"></i>Account and Information
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <ul class="space-y-2 text-gray-700">
                                <li>• Provide accurate and truthful information</li>
                                <li>• Keep account information up to date</li>
                                <li>• Maintain confidentiality of login credentials</li>
                                <li>• Report any unauthorized access immediately</li>
                            </ul>
                            <ul class="space-y-2 text-gray-700">
                                <li>• Submit complete application documents</li>
                                <li>• Respond promptly to information requests</li>
                                <li>• Notify of any changes to project details</li>
                                <li>• Comply with verification procedures</li>
                            </ul>
                        </div>
                    </div>

                    <div class="border border-orange-200 rounded-2xl p-6 bg-orange-50">
                        <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-handshake text-orange-500 mr-2"></i>Project Implementation
                        </h4>
                        <p class="text-gray-700 mb-4">If your application is approved, you agree to:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <ul class="space-y-2 text-gray-700">
                                <li>• Use funds only for approved purposes</li>
                                <li>• Implement projects as specified</li>
                                <li>• Maintain proper financial records</li>
                                <li>• Submit regular progress reports</li>
                            </ul>
                            <ul class="space-y-2 text-gray-700">
                                <li>• Allow monitoring and evaluation visits</li>
                                <li>• Ensure community participation</li>
                                <li>• Complete projects within agreed timelines</li>
                                <li>• Provide final project reports</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Process -->
            <div id="application-process" class="mb-12" data-aos="fade-up" data-aos-delay="500">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">4</span>
                    </span>
                    Application Process
                </h3>

                <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-2xl p-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-white font-bold">1</span>
                            </div>
                            <h5 class="font-semibold text-zambian-black mb-2">Submit</h5>
                            <p class="text-gray-600 text-sm">Complete and submit your application through the portal</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-white font-bold">2</span>
                            </div>
                            <h5 class="font-semibold text-zambian-black mb-2">Review</h5>
                            <p class="text-gray-600 text-sm">Applications undergo initial review and verification</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-white font-bold">3</span>
                            </div>
                            <h5 class="font-semibold text-zambian-black mb-2">Evaluate</h5>
                            <p class="text-gray-600 text-sm">Ward committees and CDFC conduct detailed evaluation</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-white font-bold">4</span>
                            </div>
                            <h5 class="font-semibold text-zambian-black mb-2">Decision</h5>
                            <p class="text-gray-600 text-sm">Final approval or rejection decision is communicated</p>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-white rounded-xl border border-gray-200">
                        <p class="text-gray-700 text-center">
                            <i class="fas fa-info-circle text-green-500 mr-2"></i>
                            <strong>Note:</strong> The CDF reserves the right to request additional information or documentation at any stage of the process.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Prohibited Uses -->
            <div id="prohibited-uses" class="mb-12" data-aos="fade-up" data-aos-delay="600">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">5</span>
                    </span>
                    Prohibited Uses
                </h3>

                <div class="border border-red-200 rounded-2xl p-6 bg-red-50">
                    <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                        <i class="fas fa-ban text-red-500 mr-2"></i>You may NOT use the portal for:
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-times text-red-500 mt-1 flex-shrink-0"></i>
                                <span>Submitting false or misleading information</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-times text-red-500 mt-1 flex-shrink-0"></i>
                                <span>Political campaign activities</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-times text-red-500 mt-1 flex-shrink-0"></i>
                                <span>Personal enrichment projects</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-times text-red-500 mt-1 flex-shrink-0"></i>
                                <span>Illegal or harmful activities</span>
                            </li>
                        </ul>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-times text-red-500 mt-1 flex-shrink-0"></i>
                                <span>Unauthorized access or system interference</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-times text-red-500 mt-1 flex-shrink-0"></i>
                                <span>Harassment or abusive behavior</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-times text-red-500 mt-1 flex-shrink-0"></i>
                                <span>Spamming or unsolicited communications</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-times text-red-500 mt-1 flex-shrink-0"></i>
                                <span>Violation of intellectual property rights</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Intellectual Property -->
            <div id="intellectual-property" class="mb-12" data-aos="fade-up" data-aos-delay="700">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">6</span>
                    </span>
                    Intellectual Property
                </h3>

                <div class="space-y-6">
                    <div class="bg-green-50 rounded-2xl p-6">
                        <h4 class="text-lg font-semibold text-zambian-black mb-3 flex items-center">
                            <i class="fas fa-copyright text-green-500 mr-2"></i>Portal Content
                        </h4>
                        <p class="text-gray-700">
                            The CDF Portal, including its design, functionality, and content, is owned by the Government of Zambia.
                            All rights are reserved. You may not reproduce, distribute, or create derivative works without permission.
                        </p>
                    </div>

                    <div class="bg-orange-50 rounded-2xl p-6">
                        <h4 class="text-lg font-semibold text-zambian-black mb-3 flex items-center">
                            <i class="fas fa-upload text-orange-500 mr-2"></i>User Content
                        </h4>
                        <p class="text-gray-700">
                            By submitting content to the portal, you grant the CDF a license to use, display, and process
                            your submissions for the purposes of application review, project implementation, and transparency reporting.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Limitation of Liability -->
            <div id="limitation-liability" class="mb-12" data-aos="fade-up" data-aos-delay="800">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">7</span>
                    </span>
                    Limitation of Liability
                </h3>

                <div class="bg-gray-50 rounded-2xl p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold text-zambian-black mb-3">Service Availability</h4>
                            <p class="text-gray-700 text-sm">
                                We strive to maintain portal availability but cannot guarantee uninterrupted service.
                                Maintenance, technical issues, or other factors may temporarily affect access.
                            </p>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-zambian-black mb-3">Decision Authority</h4>
                            <p class="text-gray-700 text-sm">
                                All funding decisions are made by authorized committees following established procedures.
                                The portal facilitates the process but does not guarantee approval of any application.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modifications -->
            <div id="modifications" class="mb-12" data-aos="fade-up" data-aos-delay="900">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">8</span>
                    </span>
                    Modifications to Terms
                </h3>

                <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-2xl p-8">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-sync-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-zambian-black mb-4">Updates and Changes</h4>
                            <p class="text-gray-700 mb-4">
                                We reserve the right to modify these Terms and Conditions at any time. Changes will be posted on this page
                                with an updated revision date. Your continued use of the portal after changes constitutes acceptance of the new terms.
                            </p>
                            <div class="bg-white rounded-xl p-4 border border-green-200">
                                <p class="text-gray-700 text-sm">
                                    <i class="fas fa-bell text-green-500 mr-2"></i>
                                    <strong>Important:</strong> We recommend reviewing these terms periodically to stay informed of any updates.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Contact and Support -->
        <div class="bg-gradient-to-r from-green-500 to-orange-500 rounded-2xl p-8 text-white mb-12" data-aos="fade-up" data-aos-delay="1000">
            <h3 class="text-2xl font-bold mb-4">Questions or Support?</h3>
            <p class="mb-6">If you have questions about these Terms and Conditions or need assistance with the portal, we're here to help.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-envelope text-2xl"></i>
                    <div>
                        <p class="font-semibold">Email Support</p>
                        <p class="text-sm opacity-90">support@cdf.gov.zm</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <i class="fas fa-phone text-2xl"></i>
                    <div>
                        <p class="font-semibold">Phone Support</p>
                        <p class="text-sm opacity-90">+260 211 123456</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <i class="fas fa-clock text-2xl"></i>
                    <div>
                        <p class="font-semibold">Office Hours</p>
                        <p class="text-sm opacity-90">Mon-Fri: 08:00-17:00</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Last Updated Notice -->
        <div class="text-center pt-8 border-t border-gray-200" data-aos="fade-up" data-aos-delay="1100">
            <p class="text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                These Terms and Conditions were last updated on January 15, 2025
            </p>
        </div>
    </div>
</section>
@endsection
