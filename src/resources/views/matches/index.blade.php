<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ваши совпадения') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    @if($matches->isEmpty())
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Пока нет совпадений</h3>
                            <p class="mt-2 text-gray-500">Продолжайте листать, чтобы найти идеальный мем!</p>
                            <div class="mt-6">
                                <a href="{{ route('swipe.index') }}" class="btn-tinder inline-flex items-center px-6 py-3 rounded-full font-semibold text-sm text-white uppercase tracking-wider transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                    </svg>
                                    Начать просмотр
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($matches as $match)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center text-xl font-bold text-red-600">
                                                {{ substr($match['user']->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $match['user']->name }}
                                            </p>
                                            <div class="flex items-center mt-2">
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ $match['score'] }}%"></div>
                                                </div>
                                                <span class="ml-2 text-xs font-medium text-red-600">{{ $match['score'] }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
