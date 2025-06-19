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
                    <div class="car-image">
                        <img src="{{ asset('images/car landin.jpeg') }}"
                             alt="Luxury Car - Motivus Car Rental"
                             class="car-photo"
                             onerror="this.style.display='none'; this.parentElement.classList.add('fallback');">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
