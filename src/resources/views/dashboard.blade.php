<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meme Swipe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold">{{ __("Welcome to Meme Swipe!") }}</h3>
                            <p class="text-gray-600">{{ __("Your meme discovery platform") }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('About the Project') }}</h3>
                    <div class="space-y-4">
                        <p>
                            Meme Swipe - это инновационная платформа для открытия мемов в формате Tinder.
                            Свайпайте мемы вправо (нравится) или влево (не нравится), сохраняйте понравившиеся
                            и находите людей с похожим чувством юмора.
                        </p>
                        <p>
                            Проект разработан с использованием современного стека технологий:
                        </p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Laravel 12 - backend framework</li>
                            <li>Tailwind CSS - стилизация</li>
                            <li>Alpine.js - интерактивность</li>
                            <li>Livewire - динамические компоненты</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Свайп мемов -->
                <a href="{{ route('swipe.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </div>
                            <h3 class="font-semibold">Свайп мемов</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            Начните открывать новые мемы с помощью интуитивного интерфейса свайпов
                        </p>
                    </div>
                </a>

                <a href="{{ route('favorites.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold">Избранное</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            Просматривайте все понравившиеся мемы в одном месте
                        </p>
                    </div>
                </a>

                <a href="{{ route('matches.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                            </div>
                            <h3 class="font-semibold">Совпадения</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            Найдите людей с похожим чувством юмора
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
