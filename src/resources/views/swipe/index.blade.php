<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Свайп мемов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-md mx-auto">
                        <!-- Статистика -->
                        <div class="flex justify-between mb-6">
                            <div class="text-gray-500">
                                <span class="font-semibold">{{ $totalSwipes }}</span> просмотрено
                            </div>
                            <div class="text-green-500">
                                <span class="font-semibold">{{ $totalLikes }}</span> лайков
                            </div>
                        </div>

                        @if(isset($meme))
                            <!-- Карточка мема -->
                            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-200" id="meme-card">
                                <img src="{{ $meme->image_url }}" alt="{{ $meme->title }}"
                                     class="w-full h-96 object-cover" id="meme-image">

                                <div class="p-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $meme->title }}</h3>
                                    <p class="text-gray-600 mb-2">{{ $meme->description }}</p>
                                    <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                        {{ $meme->category }}
                                    </span>
                                </div>
                            </div>

                            <!-- Кнопки действий -->
                            <div class="flex justify-center space-x-8">
                                <button onclick="handleSwipe('dislike')"
                                        class="p-4 bg-red-100 text-red-500 rounded-full hover:bg-red-200 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <button onclick="handleSwipe('like')"
                                        class="p-4 bg-green-100 text-green-500 rounded-full hover:bg-green-200 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">Нет доступных мемов для свайпа</p>
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
                });

                memeCard.addEventListener('touchmove', e => {
                    moveX = e.touches[0].clientX;
                });

                memeCard.addEventListener('touchend', e => {
                    const diffX = moveX - startX;

                    if (Math.abs(diffX) > threshold) {
                        if (diffX > 0) {
                            handleSwipe('like');
                        } else {
                            handleSwipe('dislike');
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
