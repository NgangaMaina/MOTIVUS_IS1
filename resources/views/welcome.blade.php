<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOTIVUS - Car Rental Made Easy</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="desktop-nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">MOTIVUS</a>
            <div class="nav-links">
                <a href="#features" class="nav-link">Features</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#contact" class="nav-link">Contact</a>
                <a href="{{ route('login') }}" class="nav-btn">Get Started</a>
            </div>
        </div>
    </nav>

    <div class="mobile-container">
        <div class="homepage">
            <!-- Left Side (Mobile: Top, Desktop: Left) -->
            <div class="homepage-left">
                <!-- Logo Section -->
                <div class="logo-section">
                    <div class="logo">MOTIVUS</div>
                    <div class="tagline">Car Rental Made Easy</div>
                </div>

                <!-- Car Text -->
                <div class="car-text">
                    <h2>RENT A CAR EFFORTLESSLY<br>WITH OUR STREAMLINED SERVICES</h2>
                    
                </div>

                <!-- CTA Section -->
                <div class="cta-section">
                    <a href="{{ route('login') }}" class="get-started-btn">
                        GET STARTED
                    </a>
                </div>
            </div>

            <!-- Right Side (Mobile: Middle, Desktop: Right) -->
            <div class="homepage-right">
                <div class="car-section">
<<<<<<< HEAD
                    <div class="car-image">
                        <img src="{{ asset('images/car landin.jpeg') }}"
                             alt="Luxury Car - Motivus Car Rental"
                             class="car-photo"
                             onerror="this.style.display='none'; this.parentElement.classList.add('fallback');">
=======
                    <!-- Premium Car Slider -->
                    <div class="premium-car-slider">
                        <div class="slider-wrapper">
                            <div class="slider-viewport">
                                <div class="slider-track" id="sliderTrack">
                                    <div class="slide active" data-car="Toyota">
                                        <div class="slide-content">
                                            <img src="{{ asset('images/Toyota.jpeg') }}" alt="Toyota - Premium Sedan" class="slide-image">
                                            <div class="slide-overlay">
                                                <div class="car-info">
                                                    <h3 class="car-name">Toyota</h3>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="slide" data-car="Mazda">
                                        <div class="slide-content">
                                            <img src="{{ asset('images/maz.jpeg') }}" alt="Mazda - Luxury Vehicle" class="slide-image">
                                            <div class="slide-overlay">
                                                <div class="car-info">
                                                    <h3 class="car-name">Mazda</h3>
                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="slide" data-car="Nissan">
                                        <div class="slide-content">
                                            <img src="{{ asset('images/nis.jpeg') }}" alt="Nissan - Sports Car" class="slide-image">
                                            <div class="slide-overlay">
                                                <div class="car-info">
                                                    <h3 class="car-name">Nissan</h3>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="slide" data-car="Peugeot">
                                        <div class="slide-content">
                                            <img src="{{ asset('images/pug.jpeg') }}" alt="Peugeot - Compact Car" class="slide-image">
                                            <div class="slide-overlay">
                                                <div class="car-info">
                                                    <h3 class="car-name">Peugeot</h3>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="slide" data-car="Hero">
                                        <div class="slide-content">
                                            <img src="{{ asset('images/hero-car.jpeg') }}" alt="Luxury Car - Premium Choice" class="slide-image">
                                            <div class="slide-overlay">
                                                <div class="car-info">
                                                    <h3 class="car-name">Premium Choice</h3>
                                                    <p class="car-type">Luxury Vehicle</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modern Navigation Controls -->
                            <div class="slider-controls">
                                <button class="slider-btn slider-btn-prev" id="prevBtn" aria-label="Previous car">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="15,18 9,12 15,6"></polyline>
                                    </svg>
                                </button>
                                <button class="slider-btn slider-btn-next" id="nextBtn" aria-label="Next car">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9,18 15,12 9,6"></polyline>
                                    </svg>
                                </button>
                            </div>

                            <!-- Modern Progress Indicators -->
                            <div class="slider-indicators">
                                <button class="indicator active" data-slide="0" aria-label="Toyota"></button>
                                <button class="indicator" data-slide="1" aria-label="Mazda"></button>
                                <button class="indicator" data-slide="2" aria-label="Nissan"></button>
                                <button class="indicator" data-slide="3" aria-label="Peugeot"></button>
                                <button class="indicator" data-slide="4" aria-label="Premium Choice"></button>
                            </div>
                        </div>
>>>>>>> main
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Why Choose MOTIVUS?</h2>
                <p class="section-subtitle">Experience the future of car rental with our innovative features</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🚗</div>
                    <h3 class="feature-title">Wide Selection</h3>
                    <p class="feature-description">Choose from hundreds of verified vehicles from economy to luxury cars</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3 class="feature-title">Easy Booking</h3>
                    <p class="feature-description">Book your perfect car in just a few taps with our streamlined process</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💳</div>
                    <h3 class="feature-title">M-PESA Integration</h3>
                    <p class="feature-description">Secure payments through M-PESA for convenient transactions</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📍</div>
                    <h3 class="feature-title">GPS Tracking</h3>
                    <p class="feature-description">Real-time vehicle tracking for enhanced security and peace of mind</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h3 class="feature-title">Verified Owners</h3>
                    <p class="feature-description">All vehicle owners are thoroughly verified for your safety</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Instant Approval</h3>
                    <p class="feature-description">Get instant booking confirmations and quick rental approvals</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="section-container">
            <div class="about-content">
                <div class="about-text">
                    <h2 class="section-title">About MOTIVUS</h2>
                    <p class="about-description">
                        MOTIVUS is revolutionizing car rental in Nairobi by connecting car owners with renters through
                        our innovative platform. We believe in making transportation accessible, affordable, and convenient
                        for everyone.
                    </p>
                    <p class="about-description">
                        Our mission is to create a seamless car-sharing ecosystem that benefits both car owners looking
                        to monetize their vehicles and renters seeking reliable transportation solutions.
                    </p>

                    <div class="about-stats">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Verified Vehicles</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">1000+</div>
                            <div class="stat-label">Happy Customers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Support Available</div>
                        </div>
                    </div>
                </div>

                <div class="about-image">
                    <div class="about-img-placeholder">
                        <span class="about-emoji">🚙</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Get In Touch</h2>
                <p class="section-subtitle">Have questions? We're here to help you get on the road</p>
            </div>

            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div class="contact-details">
                            <h4>Location</h4>
                            <p>Nairobi, Kenya<br>Central Business District</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div class="contact-details">
                            <h4>Phone</h4>
                            <p>+254 700 000 000<br>Available 24/7</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p>support@motivus.co.ke<br>info@motivus.co.ke</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <form class="contact-form-container">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" class="form-input" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-input" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-input form-textarea" placeholder="Your Message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="primary-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="section-container">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="footer-logo">MOTIVUS</div>
                    <p class="footer-tagline">Car Rental Made Easy</p>
                </div>
                <div class="footer-links">
                    <a href="#features">Features</a>
                    <a href="#about">About</a>
                    <a href="#contact">Contact</a>
                    <a href="{{ route('login') }}">Get Started</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 MOTIVUS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Enhanced Slider JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderTrack = document.getElementById('sliderTrack');
            const slides = document.querySelectorAll('.slide');
            const indicators = document.querySelectorAll('.indicator');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            let currentSlide = 0;
            const totalSlides = slides.length;

            // Auto-play settings
            let autoPlayInterval;
            const autoPlayDelay = 5000; // 5 seconds for better viewing

            function updateSlider() {
                // Update slider position with smooth transition
                sliderTrack.style.transform = `translateX(-${currentSlide * (100 / totalSlides)}%)`;

                // Update active slide with fade effect
                slides.forEach((slide, index) => {
                    slide.classList.toggle('active', index === currentSlide);

                    // Add entrance animation to active slide
                    if (index === currentSlide) {
                        slide.style.opacity = '1';
                        slide.style.transform = 'scale(1)';
                    } else {
                        slide.style.opacity = '0.7';
                        slide.style.transform = 'scale(0.95)';
                    }
                });

                // Update active indicator
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentSlide);
                });

                // Add subtle animation to car info
                const activeSlide = slides[currentSlide];
                const carInfo = activeSlide.querySelector('.car-info');
                if (carInfo) {
                    carInfo.style.animation = 'none';
                    setTimeout(() => {
                        carInfo.style.animation = 'slideInUp 0.6s ease-out';
                    }, 100);
                }
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
            }

            function goToSlide(slideIndex) {
                if (slideIndex !== currentSlide) {
                    currentSlide = slideIndex;
                    updateSlider();
                }
            }

            function startAutoPlay() {
                autoPlayInterval = setInterval(nextSlide, autoPlayDelay);
            }

            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
            }

            // Event listeners with improved UX
            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                nextSlide();
                stopAutoPlay();
                setTimeout(startAutoPlay, 2000); // Restart after 2 seconds
            });

            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                prevSlide();
                stopAutoPlay();
                setTimeout(startAutoPlay, 2000); // Restart after 2 seconds
            });

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', (e) => {
                    e.preventDefault();
                    goToSlide(index);
                    stopAutoPlay();
                    setTimeout(startAutoPlay, 3000); // Restart after 3 seconds
                });
            });

            // Enhanced hover behavior
            const sliderWrapper = document.querySelector('.slider-wrapper');
            sliderWrapper.addEventListener('mouseenter', () => {
                stopAutoPlay();
                sliderWrapper.classList.add('hovered');
            });

            sliderWrapper.addEventListener('mouseleave', () => {
                sliderWrapper.classList.remove('hovered');
                startAutoPlay();
            });

            // Improved touch/swipe support
            let startX = 0;
            let endX = 0;
            let isDragging = false;

            sliderWrapper.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                stopAutoPlay();
            }, { passive: true });

            sliderWrapper.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                endX = e.touches[0].clientX;
            }, { passive: true });

            sliderWrapper.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                isDragging = false;

                const diff = startX - endX;
                const threshold = 75; // Minimum swipe distance

                if (Math.abs(diff) > threshold) {
                    if (diff > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                }

                setTimeout(startAutoPlay, 2000);
            }, { passive: true });

            // Keyboard navigation with focus management
            document.addEventListener('keydown', (e) => {
                if (document.activeElement.closest('.premium-car-slider')) {
                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        prevSlide();
                        stopAutoPlay();
                        setTimeout(startAutoPlay, 2000);
                    } else if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        nextSlide();
                        stopAutoPlay();
                        setTimeout(startAutoPlay, 2000);
                    }
                }
            });

            // Initialize slider
            updateSlider();

            // Start auto-play after a brief delay
            setTimeout(startAutoPlay, 1000);

            // Pause auto-play when page is not visible
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    stopAutoPlay();
                } else {
                    startAutoPlay();
                }
            });
        });
    </script>
</body>
</html>
