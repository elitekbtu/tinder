<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Meme Swipe') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
        .footer-link {
            transition: color 0.2s ease;
        }
        .footer-link:hover {
            color: #FF5864;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
<div class="min-h-screen flex flex-col">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('swipe.index') }}" class="text-xl font-bold text-gray-900">
                        MemeSwipe
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Профиль
                        </a>
                        <a href="{{ route('favorites.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Избранное
                        </a>
                        <a href="{{ route('matches.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Совпадения
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Войти
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-tinder px-4 py-2 rounded-md text-sm font-medium">
                                Регистрация
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="md:flex">
                        <div class="md:flex-1 p-8">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">Tinder для мемов</h1>
                            <p class="text-lg text-gray-600 mb-6">
                                Свайпай мемы, сохраняй понравившиеся и находи людей с похожим чувством юмора!
                            </p>
                            <div class="flex flex-col space-y-4">
                                @auth
                                    <a href="{{ route('swipe.index') }}" class="btn-tinder px-6 py-3 rounded-lg text-center font-medium text-lg">
                                        Начать свайпить
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="btn-tinder px-6 py-3 rounded-lg text-center font-medium text-lg">
                                        Зарегистрироваться
                                    </a>
                                    <a href="{{ route('login') }}" class="border border-gray-300 px-6 py-3 rounded-lg text-center font-medium text-lg hover:bg-gray-50">
                                        Уже есть аккаунт? Войти
                                    </a>
                                @endauth
                            </div>
                        </div>
                        <div class="md:flex-1 tinder-gradient flex items-center justify-center p-8">
                            <img src="{{ asset('images/tinder-logo.jpg') }}" alt="Meme Swipe Demo" class="max-w-full h-auto rounded-lg shadow-lg">
                        </div>
                    </div>
                </div>

                <div class="mt-12 grid gap-8 md:grid-cols-3">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="text-pink-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Лайкай мемы</h3>
                        <p class="text-gray-600">
                            Свайпай вправо, если мем тебе понравился, и сохраняй его в избранное.
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="text-blue-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Находи единомышленников</h3>
                        <p class="text-gray-600">
                            Находи людей с похожим чувством юмора на основе твоих лайков.
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="text-yellow-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Персонализированные рекомендации</h3>
                        <p class="text-gray-600">
                            Получай мемы, которые точно соответствуют твоему чувству юмора.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">MemeSwipe</h3>
                    <p class="text-sm text-gray-400">
                        Tinder-подобное приложение для открытия мемов. Свайпай, сохраняй и делись лучшими мемами.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Навигация</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('swipe.index') }}" class="footer-link text-gray-400 hover:text-white">Свайп мемов</a></li>
                        <li><a href="{{ route('favorites.index') }}" class="footer-link text-gray-400 hover:text-white">Избранное</a></li>
                        <li><a href="{{ route('matches.index') }}" class="footer-link text-gray-400 hover:text-white">Совпадения</a></li>
                        <li><a href="{{ route('stats.index') }}" class="footer-link text-gray-400 hover:text-white">Статистика</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Правовая информация</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="footer-link text-gray-400 hover:text-white">Условия использования</a></li>
                        <li><a href="#" class="footer-link text-gray-400 hover:text-white">Политика конфиденциальности</a></li>
                        <li><a href="#" class="footer-link text-gray-400 hover:text-white">Правила сообщества</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Подписаться</h3>
                    <p class="text-sm text-gray-400 mb-4">
                        Подпишитесь на обновления и лучшие мемы недели.
                    </p>
                    <form class="flex">
                        <input type="email" placeholder="Ваш email" class="px-3 py-2 text-sm rounded-l-md focus:outline-none focus:ring-2 focus:ring-pink-500 w-full">
                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-r-md text-sm font-medium transition">
                            OK
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-sm text-gray-400">
                © {{ date('Y') }} MemeSwipe. Все права защищены.
            </div>
        </div>
    </footer>
</div>
</body>
</html>
