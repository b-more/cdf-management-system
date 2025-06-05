{{-- resources/views/public/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Contact Us - CDF Portal Zambia')
@section('description', 'Get in touch with the CDF team. Visit our office in Lusaka Munali, call us, or send a message. We are here to help with your community development fund inquiries.')

@section('content')
<!-- Professional Hero Section -->
<section class="relative py-20 gradient-hero overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up">
                Contact
                <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
                    Us
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                We're here to help you navigate the CDF process and answer all your questions about community development funding.
            </p>
        </div>
    </div>
</section>

<!-- Professional Contact Information Cards -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <!-- Office Location -->
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Visit Our Office</h3>
                <p class="text-gray-600 leading-relaxed">
                    CDF Secretariat Building<br>
                    Munali Road, Plot 1234<br>
                    Lusaka, Zambia<br>
                    <span class="text-green-600 font-semibold">P.O. Box 12345</span>
                </p>
            </div>

            <!-- Phone Numbers -->
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-phone text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Call Us</h3>
                <div class="space-y-2 text-gray-600">
                    <p>
                        <span class="font-semibold text-zambian-black">Main Office:</span><br>
                        <a href="tel:+260211123456" class="text-orange-600 hover:text-orange-700">+260 211 123456</a>
                    </p>
                    <p>
                        <span class="font-semibold text-zambian-black">Mobile:</span><br>
                        <a href="tel:+260971234567" class="text-orange-600 hover:text-orange-700">+260 971 234567</a>
                    </p>
                </div>
            </div>

            <!-- Email Addresses -->
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-envelope text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Email Us</h3>
                <div class="space-y-2 text-gray-600">
                    <p>
                        <span class="font-semibold text-zambian-black">General:</span><br>
                        <a href="mailto:info@cdf.gov.zm" class="text-green-600 hover:text-green-700">info@cdf.gov.zm</a>
                    </p>
                    <p>
                        <span class="font-semibold text-zambian-black">Applications:</span><br>
                        <a href="mailto:applications@cdf.gov.zm" class="text-green-600 hover:text-green-700">applications@cdf.gov.zm</a>
                    </p>
                </div>
            </div>

            <!-- Office Hours -->
            <div class="text-center card-zambian rounded-2xl p-8" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clock text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-zambian-black mb-4">Office Hours</h3>
                <div class="space-y-2 text-gray-600">
                    <p>
                        <span class="font-semibold text-zambian-black">Monday - Friday:</span><br>
                        08:00 - 17:00
                    </p>
                    <p>
                        <span class="font-semibold text-zambian-black">Saturday:</span><br>
                        09:00 - 13:00
                    </p>
                    <p class="text-red-600 font-semibold">Closed on Sundays</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Contact Form & Map Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Professional Contact Form -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" data-aos="fade-right">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-green-50 to-orange-50 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-paper-plane text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-zambian-black">Send us a Message</h2>
                            <p class="text-gray-600">We'll get back to you within 24 hours</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="p-8">
                    <form id="contactForm" class="space-y-6">
                        @csrf
                        <!-- Name and Email Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-zambian-black mb-2">
                                    <i class="fas fa-user text-green-500 mr-2"></i>Full Name *
                                </label>
                                <input type="text"
                                       id="full_name"
                                       name="full_name"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                       placeholder="Enter your full name">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-zambian-black mb-2">
                                    <i class="fas fa-envelope text-orange-500 mr-2"></i>Email Address *
                                </label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                       placeholder="your.email@example.com">
                            </div>
                        </div>

                        <!-- Phone and Subject Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-zambian-black mb-2">
                                    <i class="fas fa-phone text-green-500 mr-2"></i>Phone Number
                                </label>
                                <input type="tel"
                                       id="phone"
                                       name="phone"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                       placeholder="+260 971 234567">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-zambian-black mb-2">
                                    <i class="fas fa-tag text-orange-500 mr-2"></i>Subject *
                                </label>
                                <select id="subject"
                                        name="subject"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300">
                                    <option value="">Select a subject</option>
                                    <option value="application-inquiry">Application Inquiry</option>
                                    <option value="project-status">Project Status Update</option>
                                    <option value="technical-support">Technical Support</option>
                                    <option value="general-information">General Information</option>
                                    <option value="feedback">Feedback & Suggestions</option>
                                    <option value="complaint">Complaint</option>
                                    <option value="partnership">Partnership Opportunity</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Constituency and Ward -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="constituency" class="block text-sm font-medium text-zambian-black mb-2">
                                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>Constituency
                                </label>
                                <input type="text"
                                       id="constituency"
                                       name="constituency"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                       placeholder="e.g., Munali Constituency">
                            </div>

                            <div>
                                <label for="ward" class="block text-sm font-medium text-zambian-black mb-2">
                                    <i class="fas fa-location-dot text-orange-500 mr-2"></i>Ward/Area
                                </label>
                                <input type="text"
                                       id="ward"
                                       name="ward"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300"
                                       placeholder="e.g., Ward 15">
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-zambian-black mb-2">
                                <i class="fas fa-comment text-green-500 mr-2"></i>Message *
                            </label>
                            <textarea id="message"
                                      name="message"
                                      required
                                      rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 resize-none"
                                      placeholder="Please describe your inquiry or message in detail..."></textarea>
                        </div>

                        <!-- Privacy Notice -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox"
                                       id="privacy_consent"
                                       name="privacy_consent"
                                       required
                                       class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                <label for="privacy_consent" class="text-sm text-gray-600">
                                    I agree to the <a href="{{ route('privacy') }}" class="text-green-600 hover:text-green-700 font-medium">Privacy Policy</a>
                                    and consent to my personal data being processed for the purpose of responding to this inquiry.
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center pt-4">
                            <button type="submit"
                                    class="btn-zambian-primary text-white px-8 py-4 rounded-xl font-semibold text-lg transform hover:scale-105 transition-all duration-300 shadow-lg flex items-center">
                                <i class="fas fa-paper-plane mr-3"></i>
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Professional Google Map -->
            <div class="space-y-8" data-aos="fade-left">
                <!-- Map Container -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-orange-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-zambian-black flex items-center">
                            <i class="fas fa-map-marked-alt text-green-500 mr-3"></i>
                            Find Us in Lusaka Munali
                        </h3>
                    </div>

                    <!-- Google Map Embed -->
                    <div class="relative h-96">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3846.6167864567!2d28.377742!3d-15.4167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19408b5b6b5b5b5b%3A0x6b5b5b5b5b5b5b5b!2sMunali%20Road%2C%20Lusaka%2C%20Zambia!5e0!3m2!1sen!2szm!4v1640995200000!5m2!1sen!2szm&markers=color:green%7Clabel:CDF%7C-15.4167,28.377742"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-full">
                        </iframe>
                    </div>

                    <!-- Map Footer with Directions -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                <strong>CDF Secretariat:</strong> Munali Road, Lusaka
                            </div>
                            <a href="https://maps.google.com/?q=-15.4167,28.377742"
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-medium hover:bg-green-600 transition-colors duration-300">
                                <i class="fas fa-directions mr-2"></i>Get Directions
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Professional Quick Contact Card -->
                <div class="bg-gradient-to-r from-green-500 to-orange-500 rounded-3xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4">Need Immediate Assistance?</h3>
                    <p class="mb-6 text-green-50">
                        For urgent matters or immediate support, don't hesitate to call us directly or visit our office during working hours.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="tel:+260211123456"
                           class="flex items-center justify-center px-6 py-3 bg-white/20 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300">
                            <i class="fas fa-phone mr-3"></i>Call Now
                        </a>
                        <a href="https://wa.me/260971234567"
                           target="_blank"
                           class="flex items-center justify-center px-6 py-3 bg-white/20 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300">
                            <i class="fab fa-whatsapp mr-3"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional FAQ Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-zambian-black mb-6">
                Frequently Asked
                <span class="bg-gradient-to-r from-green-600 to-orange-500 bg-clip-text text-transparent">
                    Questions
                </span>
            </h2>
            <p class="text-xl text-gray-600">
                Quick answers to common questions about the CDF process and requirements.
            </p>
        </div>

        <!-- Professional FAQ Accordion -->
        <div class="space-y-4" data-aos="fade-up" data-aos-delay="200">
            <div class="faq-item border border-gray-200 rounded-2xl overflow-hidden">
                <button class="faq-question w-full px-6 py-5 text-left bg-white hover:bg-gray-50 transition-colors duration-300 flex items-center justify-between">
                    <span class="text-lg font-semibold text-zambian-black">How do I apply for CDF funding?</span>
                    <i class="fas fa-chevron-down text-green-500 transform transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 py-4 bg-gray-50 border-t border-gray-200 hidden">
                    <p class="text-gray-700">
                        To apply for CDF funding, visit our online portal and complete the application form. You'll need to provide project details, budget, community support documentation, and environmental impact assessment. Our team will guide you through each step of the process.
                    </p>
                </div>
            </div>

            <div class="faq-item border border-gray-200 rounded-2xl overflow-hidden">
                <button class="faq-question w-full px-6 py-5 text-left bg-white hover:bg-gray-50 transition-colors duration-300 flex items-center justify-between">
                    <span class="text-lg font-semibold text-zambian-black">What types of projects are eligible for funding?</span>
                    <i class="fas fa-chevron-down text-green-500 transform transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 py-4 bg-gray-50 border-t border-gray-200 hidden">
                    <p class="text-gray-700">
                        CDF supports infrastructure, education, healthcare, water & sanitation, agriculture, and youth development projects. Projects must benefit the community, be sustainable, and align with constituency development priorities.
                    </p>
                </div>
            </div>

            <div class="faq-item border border-gray-200 rounded-2xl overflow-hidden">
                <button class="faq-question w-full px-6 py-5 text-left bg-white hover:bg-gray-50 transition-colors duration-300 flex items-center justify-between">
                    <span class="text-lg font-semibold text-zambian-black">How long does the approval process take?</span>
                    <i class="fas fa-chevron-down text-green-500 transform transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 py-4 bg-gray-50 border-t border-gray-200 hidden">
                    <p class="text-gray-700">
                        The approval process typically takes 4-6 weeks from submission to final decision. This includes initial review, ward committee assessment, CDFC evaluation, and final approval. You'll receive SMS updates throughout the process.
                    </p>
                </div>
            </div>

            <div class="faq-item border border-gray-200 rounded-2xl overflow-hidden">
                <button class="faq-question w-full px-6 py-5 text-left bg-white hover:bg-gray-50 transition-colors duration-300 flex items-center justify-between">
                    <span class="text-lg font-semibold text-zambian-black">Can I track my application status online?</span>
                    <i class="fas fa-chevron-down text-green-500 transform transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 py-4 bg-gray-50 border-t border-gray-200 hidden">
                    <p class="text-gray-700">
                        Yes! Use our online status checker with your application ID and phone number. You'll see real-time updates on your application progress, upcoming meetings, and next steps in the approval process.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Professional Contact Form Handler
    const contactForm = document.getElementById('contactForm');

    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending Message...';
        submitBtn.disabled = true;

        // Simulate form submission (replace with actual API call)
        setTimeout(() => {
            // Show success message
            showAlert('Message sent successfully! We\'ll get back to you within 24 hours.', 'success');

            // Reset form
            contactForm.reset();

            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });

    // Professional FAQ Accordion
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const chevron = question.querySelector('.fas');

        question.addEventListener('click', function() {
            const isOpen = !answer.classList.contains('hidden');

            // Close all other items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.querySelector('.faq-answer').classList.add('hidden');
                    otherItem.querySelector('.fas').classList.remove('rotate-180');
                }
            });

            // Toggle current item
            if (isOpen) {
                answer.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            } else {
                answer.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            }
        });
    });

    // Professional Alert Function
    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200';
        const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

        const alert = document.createElement('div');
        alert.className = `fixed top-4 right-4 ${alertClass} border px-6 py-4 rounded-xl shadow-lg z-50 max-w-md`;
        alert.innerHTML = `
            <div class="flex items-center">
                <i class="${iconClass} mr-3"></i>
                <span>${message}</span>
                <button class="ml-4 text-lg font-bold" onclick="this.parentElement.parentElement.remove()">&times;</button>
            </div>
        `;

        document.body.appendChild(alert);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }

    // Form field enhancements
    const inputs = contactForm.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
    .focused label {
        @apply text-green-600;
    }

    .faq-question:hover .fas {
        @apply text-orange-500;
    }

    .rotate-180 {
        transform: rotate(180deg);
    }
</style>
@endpush
@endsection
