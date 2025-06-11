<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .create-vehicle-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .create-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .page-header {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #00d4ff;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .price-input {
            position: relative;
        }
        
        .price-input::before {
            content: 'KSh';
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-weight: 600;
            z-index: 1;
        }
        
        .price-input .form-input {
            padding-left: 50px;
        }
        
        .form-help {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
        }
        
        .image-preview {
            width: 100%;
            height: 200px;
            border: 2px dashed #ddd;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
            margin-top: 10px;
            transition: all 0.3s ease;
        }
        
        .image-preview:hover {
            border-color: #00d4ff;
            background: #f0f9ff;
        }
        
        .preview-content {
            text-align: center;
            color: #666;
        }
        
        .preview-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        
        .btn-submit {
            background: linear-gradient(45deg, #00d4ff, #0099cc);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 200px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 212, 255, 0.3);
        }
        
        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
            min-width: 200px;
        }
        
        .btn-cancel:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .checkbox-group {
            margin-top: 5px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-weight: 500;
            color: #333;
        }

        .checkbox-label input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #0099cc;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .form-card {
                padding: 25px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="desktop-nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">MOTIVUS</a>
            <div class="nav-links">
                <a href="{{ route('vehicles.index') }}" class="nav-link">Browse Cars</a>
                @auth
                    @if(auth()->user()->isRenter())
                        <a href="{{ route('bookings.index') }}" class="nav-link">My Bookings</a>
                    @endif
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.vehicles.index') }}" class="nav-link">My Vehicles</a>
                        <a href="{{ route('owner.bookings.index') }}" class="nav-link">Booking Requests</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none; color: white;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-btn">Sign In</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="create-vehicle-page">
        <div class="create-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Edit Vehicle</h1>
                <p class="page-subtitle">Update your vehicle details and pricing</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Vehicle Form -->
            <form method="POST" action="{{ isset($vehicle) ? route('owner.vehicles.update', $vehicle) : route('owner.vehicles.store') }}" class="form-card">
                @csrf
                @if(isset($vehicle))
                    @method('PATCH')
                @endif

                <!-- Vehicle Details Section -->
                <div class="form-section">
                    <h3 class="section-title">🚗 Vehicle Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="make" class="form-label">Make *</label>
                            <input type="text" id="make" name="make" class="form-input"
                                   value="{{ old('make', $vehicle->make ?? '') }}" placeholder="e.g., Toyota, Nissan, Honda" required>
                            <div class="form-help">Enter the vehicle manufacturer</div>
                        </div>

                        <div class="form-group">
                            <label for="model" class="form-label">Model *</label>
                            <input type="text" id="model" name="model" class="form-input" 
                                   value="{{ old('model', $vehicle->model ?? '') }}" placeholder="e.g., Corolla, X-Trail, Civic" required>
                            <div class="form-help">Enter the vehicle model</div>
                        </div>

                        <div class="form-group">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" id="year" name="year" class="form-input" 
                                   value="{{ old('year', $vehicle->year ?? '') }}" placeholder="e.g., 2020"
                                   min="1990" max="{{ date('Y') + 1 }}">
                            <div class="form-help">Manufacturing year (optional)</div>
                        </div>
                    </div>
                </div>

                <!-- Location & Pricing Section -->
                <div class="form-section">
                    <h3 class="section-title">📍 Location & Pricing</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="location" class="form-label">Location *</label>
                            <input type="text" id="location" name="location" class="form-input" 
                                   value="{{ old('location', $vehicle->location ?? '') }}" placeholder="e.g., Westlands, Nairobi" required>
                            <div class="form-help">Where is your vehicle located?</div>
                        </div>

                        <div class="form-group">
                            <label for="price_per_day" class="form-label">Daily Rental Price *</label>
                            <div class="price-input">
                                <input type="number" id="price_per_day" name="price_per_day" class="form-input"
                                       value="{{ old('price_per_day', $vehicle->price_per_day ?? '') }}" placeholder="3500"
                                       min="0" max="999999" step="0.01" required>
                            </div>
                            <div class="form-help">How much per day? (in Kenyan Shillings)</div>
                        </div>

                        <div class="form-group">
                            <label for="availability" class="form-label">Availability</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="hidden" name="availability" value="0">
                                    <input type="checkbox" id="availability" name="availability" value="1"
                                           {{ old('availability', $vehicle->availability ?? true) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    Available for rent
                                </label>
                            </div>
                            <div class="form-help">Uncheck to temporarily make vehicle unavailable</div>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Image Section -->
                <div class="form-section">
                    <h3 class="section-title">📸 Vehicle Photo</h3>
                    <div class="form-group">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="url" id="image_url" name="image_url" class="form-input" 
                               value="{{ old('image_url', $vehicle->image_url ?? '') }}" placeholder="https://example.com/your-car-photo.jpg">
                        <div class="form-help">Add a photo URL to attract more renters (optional)</div>
                        
                        <div class="image-preview" id="imagePreview">
                            <div class="preview-content">
                                <div class="preview-icon">📷</div>
                                <div>Image preview will appear here</div>
                                <div style="font-size: 0.8rem; margin-top: 5px;">Enter an image URL above</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        💾 Update Vehicle
                    </button>
                    <a href="{{ route('owner.vehicles.index') }}" class="btn-cancel">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const imageUrlInput = document.getElementById('image_url');
            const preview = document.getElementById('imagePreview');

            // Show existing image on page load
            if (imageUrlInput.value) {
                updatePreview(imageUrlInput.value);
            }

            imageUrlInput.addEventListener('input', function() {
                updatePreview(this.value);
            });

            function updatePreview(imageUrl) {
                if (imageUrl) {
                    preview.innerHTML = `
                        <img src="${imageUrl}" alt="Vehicle Preview"
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                             onerror="this.parentElement.innerHTML='<div class=\\"preview-content\\"><div class=\\"preview-icon\\">❌</div><div>Invalid image URL</div></div>'">
                    `;
                } else {
                    preview.innerHTML = `
                        <div class="preview-content">
                            <div class="preview-icon">📷</div>
                            <div>Image preview will appear here</div>
                            <div style="font-size: 0.8rem; margin-top: 5px;">Enter an image URL above</div>
                        </div>
                    `;
                }
            }
        });
    </script>
</body>
</html>
