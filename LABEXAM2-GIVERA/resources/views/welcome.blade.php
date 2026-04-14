<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rice Order Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Figtree', sans-serif;
            }

            .hero {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
            }

            .hero-content {
                text-align: center;
                max-width: 600px;
                padding: 2rem;
            }

            .hero h1 {
                font-size: 3.5rem;
                font-weight: 800;
                margin-bottom: 1rem;
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            }

            .hero p {
                font-size: 1.25rem;
                margin-bottom: 2rem;
                opacity: 0.95;
                line-height: 1.6;
            }

            .hero-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-hero {
                display: inline-block;
                padding: 0.875rem 2rem;
                border-radius: 0.5rem;
                font-weight: 600;
                font-size: 1rem;
                text-decoration: none;
                transition: all 0.3s ease;
                cursor: pointer;
                border: 2px solid white;
            }

            .btn-hero-primary {
                background-color: white;
                color: #667eea;
                border-color: white;
            }

            .btn-hero-primary:hover {
                background-color: transparnt;
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }

            .btn-hero-secondary {
                background-color: transparent;
                color: white;
                border-color: white;
            }

            .btn-hero-secondary:hover {
                background-color: white;
                color: #667eea;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }

            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 2rem;
                margin-top: 3rem;
                max-width: 1000px;
                margin-left: auto;
                margin-right: auto;
            }

            .feature-item {
                background-color: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                padding: 2rem;
                border-radius: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
            }

            .feature-item:hover {
                background-color: rgba(255, 255, 255, 0.15);
                transform: translateY(-5px);
            }

            .feature-icon {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            .feature-item h3 {
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }

            .feature-item p {
                font-size: 0.9rem;
                opacity: 0.9;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="hero">
            <div class="hero-content">
                <h1>🌾 Rice Order Management</h1>
                <p>Streamline your rice sales and order management with our comprehensive system. Manage inventory, track orders, and process payments effortlessly.</p>

                <div class="hero-buttons">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-hero btn-hero-primary">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-hero btn-hero-primary">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-hero btn-hero-secondary">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">📦</div>
                        <h3>Inventory Management</h3>
                        <p>Manage rice products with real-time stock tracking and pricing control.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🛒</div>
                        <h3>Order Management</h3>
                        <p>Create and manage customer orders with detailed item tracking.</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">💳</div>
                        <h3>Payment Tracking</h3>
                        <p>Record payments and track order payment status efficiently.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
