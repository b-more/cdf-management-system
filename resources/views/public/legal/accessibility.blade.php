{{-- resources/views/public/legal/accessibility.blade.php --}}
@extends('layouts.app')

@section('title', 'Accessibility Statement - CDF Portal Zambia')
@section('description', 'Our commitment to making the CDF portal accessible to all users, including those with disabilities. Learn about our accessibility features and standards.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-16 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">
                Accessibility
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Statement
                </span>
            </h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                We are committed to ensuring the CDF portal is accessible to all users, regardless of ability or technology used.
            </p>
            <div class="mt-6 text-gray-200" data-aos="fade-up" data-aos-delay="400">
                <p class="text-sm">Last updated: January 15, 2025</p>
            </div>
        </div>
    </div>
</section>

<!-- Professional Accessibility Content -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Introduction -->
        <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-3xl p-8 mb-12" data-aos="fade-up">
            <div class="flex items-start space-x-4">
                <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-green-500 mr-2"></i>Helpful Tips
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h5 class="font-semibold text-zambian-black mb-2">Keyboard Navigation</h5>
                            <ul class="space-y-1 text-gray-700 text-sm">
                                <li>• Use Tab to move forward</li>
                                <li>• Use Shift+Tab to move backward</li>
                                <li>• Use Enter/Space to activate buttons</li>
                                <li>• Use Arrow keys in menus</li>
                                <li>• Press Alt+S to skip to main content</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-semibold text-zambian-black mb-2">Text Sizing</h5>
                            <ul class="space-y-1 text-gray-700 text-sm">
                                <li>• Use Ctrl/Cmd + Plus to zoom in</li>
                                <li>• Use Ctrl/Cmd + Minus to zoom out</li>
                                <li>• Use Ctrl/Cmd + 0 to reset zoom</li>
                                <li>• Text can be enlarged up to 200%</li>
                                <li>• Page layout remains functional</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                        <i class="fas fa-mobile-alt text-orange-500 mr-2"></i>Mobile Accessibility
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-hand-pointer text-green-600"></i>
                            </div>
                            <h6 class="font-semibold text-zambian-black mb-1">Touch Targets</h6>
                            <p class="text-gray-600 text-sm">All buttons and links are at least 44px for easy tapping</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-expand-arrows-alt text-orange-600"></i>
                            </div>
                            <h6 class="font-semibold text-zambian-black mb-1">Responsive Design</h6>
                            <p class="text-gray-600 text-sm">Layout adapts to any screen size or orientation</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-volume-up text-green-600"></i>
                            </div>
                            <h6 class="font-semibold text-zambian-black mb-1">Voice Control</h6>
                            <p class="text-gray-600 text-sm">Compatible with mobile voice assistance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Known Issues and Ongoing Improvements -->
        <div class="mb-12" data-aos="fade-up" data-aos-delay="500">
            <h3 class="text-2xl font-bold text-zambian-black mb-8 flex items-center">
                <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-tools text-orange-600"></i>
                </span>
                Ongoing Improvements
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-orange-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                        <i class="fas fa-wrench text-orange-500 mr-2"></i>Current Focus Areas
                    </h4>
                    <ul class="space-y-2 text-gray-700">
                        <li>• Enhanced mobile screen reader support</li>
                        <li>• Additional language support</li>
                        <li>• Improved form error messaging</li>
                        <li>• Better color contrast in charts</li>
                        <li>• Voice navigation improvements</li>
                    </ul>
                </div>

                <div class="bg-green-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                        <i class="fas fa-calendar-check text-green-500 mr-2"></i>Planned Updates
                    </h4>
                    <ul class="space-y-2 text-gray-700">
                        <li>• Q1 2025: Enhanced keyboard navigation</li>
                        <li>• Q2 2025: Audio content descriptions</li>
                        <li>• Q3 2025: Sign language interpretation</li>
                        <li>• Q4 2025: Offline accessibility features</li>
                        <li>• Ongoing: Regular accessibility audits</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alternative Access Methods -->
        <div class="mb-12" data-aos="fade-up" data-aos-delay="600">
            <h3 class="text-2xl font-bold text-zambian-black mb-8 flex items-center">
                <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-route text-orange-600"></i>
                </span>
                Alternative Access Methods
            </h3>

            <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-2xl p-8">
                <p class="text-gray-700 mb-6">
                    If you encounter barriers accessing our digital portal, we provide alternative ways to access CDF services:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-6 border border-green-200">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-phone text-white text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-zambian-black mb-2">Phone Support</h4>
                        <p class="text-gray-700 text-sm mb-3">Call our accessibility support line for assistance with applications</p>
                        <p class="text-green-600 font-semibold">+260 211 123456</p>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-orange-200">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-zambian-black mb-2">In-Person Support</h4>
                        <p class="text-gray-700 text-sm mb-3">Visit our office for personalized assistance</p>
                        <p class="text-orange-600 font-semibold">Munali Road, Lusaka</p>
                    </div>

                    <div class="bg-white rounded-xl p-6 border border-green-200">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-zambian-black mb-2">Paper Forms</h4>
                        <p class="text-gray-700 text-sm mb-3">Request paper application forms and assistance</p>
                        <p class="text-green-600 font-semibold">Available on request</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback and Contact -->
        <div class="mb-12" data-aos="fade-up" data-aos-delay="700">
            <h3 class="text-2xl font-bold text-zambian-black mb-8 flex items-center">
                <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-comments text-orange-600"></i>
                </span>
                Accessibility Feedback
            </h3>

            <div class="bg-gradient-to-r from-green-500 to-orange-500 rounded-2xl p-8 text-white">
                <h4 class="text-2xl font-bold mb-4">Help Us Improve</h4>
                <p class="mb-6 text-green-50">
                    Your feedback helps us identify barriers and improve accessibility. If you encounter any accessibility issues
                    or have suggestions for improvement, please let us know.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white/20 rounded-xl p-6">
                        <h5 class="font-semibold mb-3 flex items-center">
                            <i class="fas fa-envelope mr-2"></i>Email Us
                        </h5>
                        <p class="text-sm mb-2">accessibility@cdf.gov.zm</p>
                        <p class="text-xs opacity-90">We respond within 2 business days</p>
                    </div>

                    <div class="bg-white/20 rounded-xl p-6">
                        <h5 class="font-semibold mb-3 flex items-center">
                            <i class="fas fa-headset mr-2"></i>Accessibility Helpline
                        </h5>
                        <p class="text-sm mb-2">+260 211 123456 (Option 2)</p>
                        <p class="text-xs opacity-90">Monday-Friday: 08:00-17:00</p>
                    </div>
                </div>

                <div class="mt-6 bg-white/10 rounded-xl p-4">
                    <h5 class="font-semibold mb-2 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>When Reporting Issues
                    </h5>
                    <p class="text-sm opacity-90">
                        Please include: your device/browser, assistive technology used, the specific page or feature,
                        and a description of the barrier you encountered.
                    </p>
                </div>
            </div>
        </div>

        <!-- Accessibility Testing -->
        <div class="mb-12" data-aos="fade-up" data-aos-delay="800">
            <h3 class="text-2xl font-bold text-zambian-black mb-8 flex items-center">
                <span class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-search text-orange-600"></i>
                </span>
                Testing and Evaluation
            </h3>

            <div class="bg-gray-50 rounded-2xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-flask text-green-500 mr-2"></i>Regular Testing
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li>• Automated accessibility scanning</li>
                            <li>• Manual testing with assistive technologies</li>
                            <li>• User testing with disability communities</li>
                            <li>• Expert accessibility reviews</li>
                            <li>• Continuous monitoring</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-zambian-black mb-4 flex items-center">
                            <i class="fas fa-certificate text-orange-500 mr-2"></i>Standards Compliance
                        </h4>
                        <ul class="space-y-2 text-gray-700">
                            <li>• WCAG 2.1 Level AA conformance</li>
                            <li>• Section 508 compliance (US standards)</li>
                            <li>• EN 301 549 (European standards)</li>
                            <li>• Local accessibility regulations</li>
                            <li>• International best practices</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Last Updated Notice -->
        <div class="text-center pt-8 border-t border-gray-200" data-aos="fade-up" data-aos-delay="900">
            <p class="text-gray-500 mb-4">
                <i class="fas fa-calendar-alt mr-2"></i>
                This Accessibility Statement was last updated on January 15, 2025
            </p>
            <p class="text-gray-600 text-sm">
                We review and update this statement regularly to reflect our ongoing accessibility improvements.
            </p>
        </div>
    </div>
</section>
@endsection
