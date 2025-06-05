{{-- resources/views/layouts/footer.blade.php --}}
<footer class="gradient-professional text-white">
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Logo and Description -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 gradient-primary rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">CDF Portal</h3>
                        <p class="text-sm text-gray-300">Empowering Communities</p>
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed mb-6">
                    Transforming communities through transparent and accountable constituency development fund management. Building a better future together with professional excellence.
                </p>

                <!-- Professional Social Media Links -->
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-black/20 hover:bg-green-500 rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-black/20 hover:bg-green-500 rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-black/20 hover:bg-green-500 rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-black/20 hover:bg-green-500 rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-110">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Quick Links</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-home mr-2 text-green-400 group-hover:text-green-300"></i>Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-info-circle mr-2 text-green-400 group-hover:text-green-300"></i>About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('apply') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-file-alt mr-2 text-orange-400 group-hover:text-orange-300"></i>Apply Now
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-images mr-2 text-green-400 group-hover:text-green-300"></i>Project Gallery
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-envelope mr-2 text-green-400 group-hover:text-green-300"></i>Contact Us
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Project Categories -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Project Categories</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('projects.infrastructure') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-road mr-2 text-orange-400 group-hover:text-orange-300"></i>Infrastructure
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('projects.education') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-graduation-cap mr-2 text-green-400 group-hover:text-green-300"></i>Education
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('projects.health') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-heartbeat mr-2 text-red-400 group-hover:text-red-300"></i>Healthcare
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('projects.water') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-tint mr-2 text-blue-400 group-hover:text-blue-300"></i>Water & Sanitation
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('projects.agriculture') }}" class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-seedling mr-2 text-green-400 group-hover:text-green-300"></i>Agriculture
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">Contact Information</h4>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-green-400 mt-1"></i>
                        <div>
                            <p class="text-gray-300 text-sm">
                                Parliament Buildings<br>
                                Independence Avenue<br>
                                Lusaka, Zambia
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-green-400"></i>
                        <a href="tel:+260975020473" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">
                            +260 975 020 473
                        </a>
                    </div>

                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-green-400"></i>
                        <a href="mailto:info@cdfportal.gov.zm" class="text-gray-300 hover:text-white transition-colors duration-200 text-sm">
                            info@cdfportal.gov.zm
                        </a>
                    </div>

                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clock text-orange-400"></i>
                        <div class="text-gray-300 text-sm">
                            <p>Monday - Friday</p>
                            <p>8:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Newsletter Subscription -->
    <div class="border-t border-green-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="md:flex-1">
                    <h4 class="text-lg font-semibold text-white mb-2">Stay Updated</h4>
                    <p class="text-gray-300 text-sm">
                        Subscribe to receive the latest updates about CDF projects and opportunities in your area.
                    </p>
                </div>

                <div class="mt-4 md:mt-0 md:ml-8">
                    <form class="flex flex-col sm:flex-row max-w-md">
                        <input type="email"
                               placeholder="Enter your email address"
                               class="flex-1 px-4 py-3 bg-black/20 border border-gray-600 rounded-lg sm:rounded-r-none text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <button type="submit"
                                class="mt-2 sm:mt-0 px-6 py-3 btn-zambian-primary rounded-lg sm:rounded-l-none shadow-lg transition-all duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Bottom Footer -->
    <div class="border-t border-green-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="text-gray-300 text-sm">
                    <p>&copy; {{ date('Y') }} CDF Management Portal. All rights reserved.</p>
                    <p class="mt-1">Developed with <span class="text-green-400">❤️</span> for community empowerment</p>
                </div>

                <div class="mt-4 md:mt-0">
                    <div class="flex space-x-6 text-sm">
                        <a href="{{ route('privacy') }}" class="text-gray-300 hover:text-white transition-colors duration-200">
                            Privacy Policy
                        </a>
                        <a href="{{ route('terms') }}" class="text-gray-300 hover:text-white transition-colors duration-200">
                            Terms of Service
                        </a>
                        <a href="{{ route('accessibility') }}" class="text-gray-300 hover:text-white transition-colors duration-200">
                            Accessibility
                        </a>
                        <a href="{{ route('sitemap') }}" class="text-gray-300 hover:text-white transition-colors duration-200">
                            Sitemap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Back to Top Button -->
    <button id="back-to-top"
            class="fixed bottom-8 right-8 w-12 h-12 btn-zambian-primary rounded-full shadow-lg flex items-center justify-center text-white opacity-0 transform translate-y-4 transition-all duration-300 hover:scale-110 z-40 pulse-glow"
            onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>
</footer>

<script>
    // Back to top functionality
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Show/hide back to top button
    window.addEventListener('scroll', function() {
        const backToTopButton = document.getElementById('back-to-top');
        if (window.scrollY > 300) {
            backToTopButton.classList.remove('opacity-0', 'translate-y-4');
            backToTopButton.classList.add('opacity-100', 'translate-y-0');
        } else {
            backToTopButton.classList.add('opacity-0', 'translate-y-4');
            backToTopButton.classList.remove('opacity-100', 'translate-y-0');
        }
    });

    // Professional newsletter subscription
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;

        if (email) {
            // Show success message with Zambian styling
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300';
            notification.innerHTML = '<i class="fas fa-check mr-2"></i>Thank you for subscribing! You will receive updates about CDF projects.';
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);

            this.querySelector('input[type="email"]').value = '';
        }
    });
</script>
    </button>
</footer>

<script>
    // Back to top functionality
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Show/hide back to top button
    window.addEventListener('scroll', function() {
        const backToTopButton = document.getElementById('back-to-top');
        if (window.scrollY > 300) {
            backToTopButton.classList.remove('opacity-0', 'translate-y-4');
            backToTopButton.classList.add('opacity-100', 'translate-y-0');
        } else {
            backToTopButton.classList.add('opacity-0', 'translate-y-4');
            backToTopButton.classList.remove('opacity-100', 'translate-y-0');
        }
    });

    // Newsletter subscription
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;

        if (email) {
            // Show success message
            alert('Thank you for subscribing! You will receive updates about CDF projects and opportunities.');
            this.querySelector('input[type="email"]').value = '';
        }
    });
</script>
