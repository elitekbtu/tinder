<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Свайп мемов') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="max-w-md mx-auto">
                        <!-- Статистика -->
                        <div class="flex justify-between items-center mb-6 bg-gray-50 rounded-full px-6 py-3">
                            <div class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ $totalSwipes }}</span>
                            </div>
                            <div class="flex items-center text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ $totalLikes }}</span>
                            </div>
                        </div>

                        @if(isset($meme))
                            <!-- Карточка мема -->
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-8 border border-gray-100 transform transition-transform duration-300 hover:shadow-lg" id="meme-card">
                                <div class="relative">
                                    <img src="{{ $meme->image_url }}" alt="{{ $meme->title }}"
                                         class="w-full h-96 object-cover" id="meme-image">
                                    <div class="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">
                                        {{ $meme->category }}
                                    </div>
                                </div>

                                <div class="p-5">
                                    <h3 class="text-xl font-semibold mb-2">{{ $meme->title }}</h3>
                                    <p class="text-gray-600 mb-4">{{ $meme->description }}</p>
                                </div>
                            </div>

                            <!-- Кнопки действий -->
                            <div class="flex justify-center space-x-10">
                                <button onclick="handleSwipe('dislike')"
                                        class="p-4 bg-white border-2 border-gray-300 text-gray-500 rounded-full hover:bg-red-50 hover:border-red-100 hover:text-red-500 transition-all shadow-md transform hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <button onclick="handleSwipe('like')"
                                        class="p-4 bg-white border-2 border-gray-300 text-gray-500 rounded-full hover:bg-green-50 hover:border-green-100 hover:text-green-500 transition-all shadow-md transform hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Нет доступных мемов</h3>
                                <p class="mt-2 text-gray-500">Все мемы просмотрены или пока недоступны</p>
                                <div class="mt-6">
                                    <a href="{{ route('dashboard') }}" class="btn-tinder inline-flex items-center px-6 py-3 rounded-full font-semibold text-sm text-white uppercase tracking-wider transition ease-in-out duration-150">
                                        На главную
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function handleSwipe(action) {
                // Добавляем анимацию свайпа
                const card = document.getElementById('meme-card');
                if (card) {
                    card.style.transition = 'transform 0.5s ease';
                    card.style.transform = action === 'like'
                        ? 'translateX(100px) rotate(10deg)'
                        : 'translateX(-100px) rotate(-10deg)';
                    card.style.opacity = '0';
                }

                fetch('{{ isset($meme) ? route("swipe.store", $meme->id) : "" }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ action: action })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.location.reload();
                    });
            }

            // Mobile swipe handlers
            document.addEventListener('DOMContentLoaded', function() {
                const memeCard = document.getElementById('meme-card');
                if (!memeCard) return;

                let startX, moveX;
                const threshold = 50;

                memeCard.addEventListener('touchstart', e => {
                    startX = e.touches[0].clientX;
                    memeCard.style.transition = 'none';
                });

                memeCard.addEventListener('touchmove', e => {
                    moveX = e.touches[0].clientX;
                    const diffX = moveX - startX;
                    memeCard.style.transform = `translateX(${diffX}px) rotate(${diffX * 0.1}deg)`;
                });

                memeCard.addEventListener('touchend', e => {
                    const diffX = moveX - startX;
                    memeCard.style.transition = 'transform 0.5s ease';

                    if (Math.abs(diffX) > threshold) {
                        memeCard.style.transform = diffX > 0
                            ? 'translateX(200px) rotate(20deg)'
                            : 'translateX(-200px) rotate(-20deg)';
                        memeCard.style.opacity = '0';

                        setTimeout(() => {
                            handleSwipe(diffX > 0 ? 'like' : 'dislike');
                        }, 300);
                    } else {
                        memeCard.style.transform = 'none';
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
