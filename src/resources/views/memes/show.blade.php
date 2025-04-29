<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Просмотр мема') }}
            </h2>
            <a href="{{ route('memes.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                ← Назад к списку
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-3xl mx-auto space-y-6">

                        <div class="relative group">
                            <img src="{{ $meme->image_url }}" alt="{{ $meme->title }}"
                                 class="w-full rounded-lg shadow-md cursor-zoom-in hover:shadow-lg transition-shadow duration-300"
                                 onclick="openLightbox(this)">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">
                                    Нажмите для увеличения
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $meme->title }}</h1>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                            {{ $meme->category }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $meme->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                <button onclick="toggleLike({{ $meme->id }})"
                                        class="flex items-center space-x-1 text-gray-500 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span id="like-count-{{ $meme->id }}">{{ $meme->likes_count ?? 0 }}</span>
                                </button>
                            </div>

                            @if($meme->description)
                                <div class="prose max-w-none">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $meme->description }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <form action="{{ route('memes.destroy', $meme) }}" method="POST" onsubmit="return confirm('Вы уверены что хотите удалить этот мем?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                                        Удалить
                                    </button>
                                </form>
                            </div>

                            <div class="text-sm text-gray-500">
                                Автор: {{ $meme->user->name ?? 'Неизвестен' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4">
        <div class="relative max-w-6xl max-h-screen">
            <button onclick="closeLightbox()" class="absolute -top-12 right-0 text-white hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="lightbox-image" src="" alt="" class="max-w-full max-h-screen">
        </div>
    </div>

    <script>
        function openLightbox(img) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-image');
            lightboxImg.src = img.src;
            lightboxImg.alt = img.alt;
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        async function toggleLike(memeId) {
            try {
                const response = await fetch(`/memes/${memeId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                document.getElementById(`like-count-${memeId}`).textContent = data.likes_count;
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
</x-app-layout>
