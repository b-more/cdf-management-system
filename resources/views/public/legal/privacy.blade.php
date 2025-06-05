{{-- resources/views/public/legal/privacy.blade.php --}}
@extends('layouts.app')

@section('title', 'Privacy Policy - CDF Portal Zambia')
@section('description', 'Learn how we collect, use, and protect your personal information when using the CDF portal. Your privacy and data security are our priority.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-16 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">
                Privacy
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Policy
                </span>
            </h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Your privacy and data security are our top priorities. Learn how we collect, use, and protect your personal information.
            </p>
            <div class="mt-6 text-gray-200" data-aos="fade-up" data-aos-delay="400">
                <p class="text-sm">Last updated: January 15, 2025</p>
            </div>
        </div>
    </div>
</section>

<!-- Professional Privacy Content -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Introduction -->
        <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-3xl p-8 mb-12" data-aos="fade-up">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-zambian-black mb-4">Our Commitment to Your Privacy</h2>
                    <p class="text-gray-700 leading-relaxed">
                        The Constituency Development Fund (CDF) Portal is committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our services.
                    </p>
                </div>
            </div>
        </div>

        <!-- Table of Contents -->
        <div class="bg-gray-50 rounded-2xl p-6 mb-12" data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-xl font-bold text-zambian-black mb-4">
                <i class="fas fa-list text-green-500 mr-2"></i>Table of Contents
            </h3>
            <nav class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <a href="#information-collection" class="text-green-600 hover:text-green-700 py-1">1. Information We Collect</a>
                <a href="#information-use" class="text-green-600 hover:text-green-700 py-1">2. How We Use Your Information</a>
                <a href="#information-sharing" class="text-green-600 hover:text-green-700 py-1">3. Information Sharing</a>
                <a href="#data-security" class="text-green-600 hover:text-green-700 py-1">4. Data Security</a>
                <a href="#your-rights" class="text-green-600 hover:text-green-700 py-1">5. Your Rights</a>
                <a href="#contact-us" class="text-green-600 hover:text-green-700 py-1">6. Contact Us</a>
            </nav>
        </div>

        <!-- Privacy Policy Content -->
        <div class="prose prose-lg max-w-none">

            <!-- Information We Collect -->
            <div id="information-collection" class="mb-12" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">1</span>
                    </span>
                    Information We Collect
                </h3>

                <div class="space-y-6">
                    <div class="border-l-4 border-green-500 pl-6">
                        <h4 class="text-lg font-semibold text-zambian-black mb-3">Personal Information</h4>
                        <p class="text-gray-700 mb-3">When you use our CDF portal, we may collect the following personal information:</p>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-500 mt-1 flex-shrink-0"></i>
                                <span><strong>Contact Information:</strong> Name, email address, phone number, postal address</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-500 mt-1 flex-shrink-0"></i>
                                <span><strong>Identification:</strong> National Registration Card number, constituency, ward</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-500 mt-1 flex-shrink-0"></i>
                                <span><strong>Project Information:</strong> Application details, project descriptions, budget information</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-green-500 mt-1 flex-shrink-0"></i>
                                <span><strong>Communication:</strong> Messages, feedback, and correspondence with our team</span>
                            </li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-orange-500 pl-6">
                        <h4 class="text-lg font-semibold text-zambian-black mb-3">Technical Information</h4>
                        <p class="text-gray-700 mb-3">We automatically collect certain technical information:</p>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-orange-500 mt-1 flex-shrink-0"></i>
                                <span>IP address and device information</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-orange-500 mt-1 flex-shrink-0"></i>
                                <span>Browser type and version</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-orange-500 mt-1 flex-shrink-0"></i>
                                <span>Pages visited and time spent on the portal</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check text-orange-500 mt-1 flex-shrink-0"></i>
                                <span>Cookies and similar tracking technologies</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- How We Use Your Information -->
            <div id="information-use" class="mb-12" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">2</span>
                    </span>
                    How We Use Your Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-green-50 rounded-2xl p-6">
                        <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-cog text-green-500 mr-2"></i>Service Provision
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li>• Process your CDF applications</li>
                            <li>• Communicate about your projects</li>
                            <li>• Provide status updates</li>
                            <li>• Offer customer support</li>
                        </ul>
                    </div>

                    <div class="bg-orange-50 rounded-2xl p-6">
                        <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-chart-line text-orange-500 mr-2"></i>Improvement & Analytics
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li>• Improve our services and portal</li>
                            <li>• Analyze usage patterns</li>
                            <li>• Generate reports and statistics</li>
                            <li>• Enhance user experience</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-6 bg-gray-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                        <i class="fas fa-gavel text-green-500 mr-2"></i>Legal Compliance
                    </h4>
                    <p class="text-gray-700">
                        We may use your information to comply with applicable laws, regulations, and government requests,
                        including transparency and accountability requirements for public funds management.
                    </p>
                </div>
            </div>

            <!-- Information Sharing -->
            <div id="information-sharing" class="mb-12" data-aos="fade-up" data-aos-delay="400">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">3</span>
                    </span>
                    Information Sharing and Disclosure
                </h3>

                <div class="space-y-6">
                    <div class="border border-green-200 rounded-2xl p-6 bg-green-50">
                        <h4 class="text-lg font-semibold text-zambian-black mb-3 flex items-center">
                            <i class="fas fa-users text-green-500 mr-2"></i>Authorized Personnel
                        </h4>
                        <p class="text-gray-700">
                            We share information with authorized CDF personnel, ward committees, and relevant government officials
                            who need access to process your applications and ensure proper project implementation.
                        </p>
                    </div>

                    <div class="border border-orange-200 rounded-2xl p-6 bg-orange-50">
                        <h4 class="text-lg font-semibold text-zambian-black mb-3 flex items-center">
                            <i class="fas fa-eye text-orange-500 mr-2"></i>Public Transparency
                        </h4>
                        <p class="text-gray-700">
                            In line with transparency requirements, certain project information (excluding personal details)
                            may be made publicly available for accountability purposes.
                        </p>
                    </div>

                    <div class="border border-red-200 rounded-2xl p-6 bg-red-50">
                        <h4 class="text-lg font-semibold text-zambian-black mb-3 flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>We Never Share
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li>• Personal information for commercial purposes</li>
                            <li>• Data with unauthorized third parties</li>
                            <li>• Information without proper legal basis</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Data Security -->
            <div id="data-security" class="mb-12" data-aos="fade-up" data-aos-delay="500">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">4</span>
                    </span>
                    Data Security
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 border border-green-200 rounded-2xl">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-lock text-green-600 text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-zambian-black mb-2">Encryption</h4>
                        <p class="text-gray-600 text-sm">All data transmission is encrypted using industry-standard SSL/TLS protocols.</p>
                    </div>

                    <div class="text-center p-6 border border-orange-200 rounded-2xl">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-server text-orange-600 text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-zambian-black mb-2">Secure Storage</h4>
                        <p class="text-gray-600 text-sm">Data is stored on secure servers with access controls and regular backups.</p>
                    </div>

                    <div class="text-center p-6 border border-green-200 rounded-2xl">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-zambian-black mb-2">Access Control</h4>
                        <p class="text-gray-600 text-sm">Strict access controls ensure only authorized personnel can access your data.</p>
                    </div>
                </div>
            </div>

            <!-- Your Rights -->
            <div id="your-rights" class="mb-12" data-aos="fade-up" data-aos-delay="600">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">5</span>
                    </span>
                    Your Rights
                </h3>

                <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-2xl p-8">
                    <p class="text-gray-700 mb-6">Under Zambian data protection laws, you have the following rights:</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-eye text-green-500 mt-1"></i>
                                <div>
                                    <h5 class="font-semibold text-zambian-black">Right to Access</h5>
                                    <p class="text-gray-600 text-sm">Request copies of your personal data</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <i class="fas fa-edit text-orange-500 mt-1"></i>
                                <div>
                                    <h5 class="font-semibold text-zambian-black">Right to Rectification</h5>
                                    <p class="text-gray-600 text-sm">Correct inaccurate information</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <i class="fas fa-trash text-red-500 mt-1"></i>
                                <div>
                                    <h5 class="font-semibold text-zambian-black">Right to Erasure</h5>
                                    <p class="text-gray-600 text-sm">Request deletion of your data</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-pause text-green-500 mt-1"></i>
                                <div>
                                    <h5 class="font-semibold text-zambian-black">Right to Restrict</h5>
                                    <p class="text-gray-600 text-sm">Limit how we use your data</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <i class="fas fa-download text-orange-500 mt-1"></i>
                                <div>
                                    <h5 class="font-semibold text-zambian-black">Data Portability</h5>
                                    <p class="text-gray-600 text-sm">Receive your data in a portable format</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <i class="fas fa-ban text-red-500 mt-1"></i>
                                <div>
                                    <h5 class="font-semibold text-zambian-black">Right to Object</h5>
                                    <p class="text-gray-600 text-sm">Object to certain data processing</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div id="contact-us" class="mb-12" data-aos="fade-up" data-aos-delay="700">
                <h3 class="text-2xl font-bold text-zambian-black mb-6 flex items-center">
                    <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-orange-600 font-bold text-sm">6</span>
                    </span>
                    Contact Us
                </h3>

                <div class="bg-gradient-to-r from-green-500 to-orange-500 rounded-2xl p-8 text-white">
                    <h4 class="text-xl font-bold mb-4">Questions About This Privacy Policy?</h4>
                    <p class="mb-6">If you have any questions about this Privacy Policy or how we handle your personal information, please contact us:</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-2xl"></i>
                            <div>
                                <p class="font-semibold">Email</p>
                                <p class="text-sm opacity-90">privacy@cdf.gov.zm</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-2xl"></i>
                            <div>
                                <p class="font-semibold">Phone</p>
                                <p class="text-sm opacity-90">+260 211 123456</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt text-2xl"></i>
                            <div>
                                <p class="font-semibold">Office</p>
                                <p class="text-sm opacity-90">Munali Road, Lusaka</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Last Updated Notice -->
        <div class="text-center mt-12 pt-8 border-t border-gray-200" data-aos="fade-up" data-aos-delay="800">
            <p class="text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                This Privacy Policy was last updated on January 15, 2025
            </p>
        </div>
    </div>
</section>
@endsection
