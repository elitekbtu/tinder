<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('История свайпов') }}
            </h2>
            @if($swipes->isNotEmpty())
                <form method="POST" action="{{ route('swipe.clear-history') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Вы уверены, что хотите очистить всю историю?')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Очистить историю
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Всего свайпов</p>
                            <p class="text-2xl font-semibold">{{ $swipes->total() }}</p>
                        </div>
                        <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Лайков</p>
                            <p class="text-2xl font-semibold text-green-600">{{ $totalLikes }}</p>
                        </div>
                        <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Дизлайков</p>
                            <p class="text-2xl font-semibold text-red-600">{{ $totalDislikes }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($swipes as $swipe)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $swipe->meme->image_url }}" alt="{{ $swipe->meme->title }}"
                                             class="h-16 w-16 object-cover rounded-md">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $swipe->meme->title }}</h3>
                                        <p class="text-sm text-gray-500 truncate">{{ $swipe->meme->description }}</p>
                                        <div class="mt-2 flex items-center space-x-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $swipe->action === 'like' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $swipe->action === 'like' ? 'Лайк' : 'Дизлайк' }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ $swipe->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">История свайпов пуста</h3>
                                <p class="mt-1 text-gray-500">Начните свайпать мемы, чтобы увидеть их здесь</p>
                                <div class="mt-6">
                                    <a href="{{ route('swipe.index') }}"
                                       class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Начать свайпить
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($swipes->hasPages())
                        <div class="mt-6">
                            {{ $swipes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-red-600 {
            background-color: #FF5864;
        }
        .hover\:bg-red-700:hover {
            background-color: #FF4757;
        }
        .active\:bg-red-800:active {
            background-color: #E8414D;
        }
        .focus\:ring-red-500:focus {
            --tw-ring-color: rgba(255, 88, 100, 0.5);
        }
        .text-red-600 {
            color: #FF5864;
        }
    </style>
</x-app-layout>
