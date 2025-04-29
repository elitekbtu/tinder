<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.85">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Meme Swipe') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <style>
        .tinder-gradient {
            background: linear-gradient(to right, #ff4e50, #f9d423);
        }
        .btn-tinder {
            background-color: #FF5864;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-tinder:hover {
            background-color: #FF4757;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 88, 100, 0.3);
        }

        .footer-link:hover {
            color: #FF5864; /* Tinder pink */
        }

        .footer-text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }
        .footer-text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
<div class="min-h-screen flex flex-col">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $header }}
                </h2>
            </div>
        </header>
    @endisset

    <main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{ $slot }}
    </main>

    <footer class="bg-white text-gray-600 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center">
            <div class="text-center sm:text-left mb-2 sm:mb-0 footer-text-xs">
                © {{ date('Y') }} Meme Swipe. Все права защищены.
            </div>

            <div class="flex flex-wrap justify-center sm:justify-end space-x-4 footer-text-xs">
                <a href="#" class="footer-link">Условия</a>
                <a href="#" class="footer-link">Конфиденциальность</a>
                <a href="#" class="footer-link">Контакты</a>
            </div>
        </div>
    </footer>
</div>
@stack('scripts')
</body>
</html>
