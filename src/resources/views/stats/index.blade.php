<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ваша статистика') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" /></svg>
                                </div>
                                <h2 class="text-lg font-semibold">Свайпы</h2>
                            </div>
                            <div class="space-y-2">
                                <p class="flex justify-between"><span class="text-gray-600">Всего:</span> <span class="font-semibold">{{ $swipeStats['total'] }}</span></p>
                                <p class="flex justify-between"><span class="text-green-600">Лайки:</span> <span class="font-semibold">{{ $swipeStats['likes'] }}</span></p>
                                <p class="flex justify-between"><span class="text-red-600">Дизлайки:</span> <span class="font-semibold">{{ $swipeStats['dislikes'] }}</span></p>
                            </div>
                        </div>

                        {{-- Stat Card 2: Favorites --}}
                        {{-- Adjusted card styles --}}
                        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                            <div class="flex items-center mb-4">
                                {{-- Icon container style remains consistent --}}
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
                                </div>
                                <h2 class="text-lg font-semibold">Избранное</h2>
                            </div>
                            <div class="space-y-2">
                                <p class="flex justify-between"><span class="text-gray-600">Всего:</span> <span class="font-semibold">{{ $favoriteStats['total'] }}</span></p>
                                <p class="text-gray-600">Последние:</p>
                                <div class="space-y-1">
                                    @forelse($favoriteStats['last_added'] as $favorite)
                                        {{-- List item style remains --}}
                                        <p class="text-sm truncate">
                                            {{ $favorite->meme ? $favorite->meme->title : '[удаленный мем]' }}
                                        </p>
                                    @empty
                                        {{-- Adjusted empty message text color for consistency --}}
                                        <p class="text-sm text-gray-500">Нет избранных</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Stat Card 3: Matches --}}
                        {{-- Adjusted card styles --}}
                        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                            <div class="flex items-center mb-4">
                                {{-- Icon container style remains consistent --}}
                                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                </div>
                                <h2 class="text-lg font-semibold">Совпадения</h2>
                            </div>
                            <div class="space-y-2">
                                <p class="flex justify-between"><span class="text-gray-600">Всего:</span> <span class="font-semibold">{{ $matchStats['total'] }}</span></p>
                                <p class="text-gray-600">Лучшие:</p>
                                <div class="space-y-1">
                                    @forelse($matchStats['top_matches'] as $match)
                                        @if($match['user'])
                                            {{-- List item style remains --}}
                                            <p class="text-sm truncate">
                                                {{ $match['user']->name }} ({{ $match['score'] }}%)
                                            </p>
                                        @endif
                                    @empty
                                        {{-- Adjusted empty message text color for consistency --}}
                                        <p class="text-sm text-gray-500">Нет совпадений</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Activity Chart Container --}}
                    {{-- Adjusted card styles --}}
                    <div class="bg-white rounded-2xl shadow-md p-6 mb-8 border border-gray-100">
                        <h2 class="text-lg font-semibold mb-4">Активность за сегодня</h2>
                        <div class="h-64" id="activity-chart"></div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                        <h2 class="text-lg font-semibold mb-4">Последние действия</h2>
                        <div class="space-y-3">
                            @forelse($recentActions as $action)
                                {{-- Individual action item styles remain --}}
                                <div class="flex items-center p-2 border-b border-gray-100 last:border-b-0">
                                    <div class="mr-3 flex-shrink-0">
                                        @if($action->type === 'like')
                                            <span class="inline-flex items-center justify-center bg-green-100 text-green-800 h-8 w-8 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                            </span>
                                        @else {{-- Dизлайк --}}
                                        <span class="inline-flex items-center justify-center bg-red-100 text-red-800 h-8 w-8 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" /></svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm truncate">
                                            {{ $action->message }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $action->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                {{-- Empty message style remains --}}
                                <p class="text-gray-500 text-center py-4">Нет недавних действий.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const activityData = @json($activityData);
                const chartElement = document.getElementById('activity-chart');
                if (chartElement && activityData && activityData.hours) {
                    const ctx = chartElement.getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: activityData.hours,
                            datasets: [{
                                label: 'Лайки',
                                data: activityData.likes,
                                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                borderColor: 'rgba(16, 185, 129, 1)',
                                borderWidth: 2,
                                tension: 0.1,
                                fill: true
                            }, {
                                label: 'Дизлайки',
                                data: activityData.dislikes,
                                backgroundColor: 'rgba(239, 68, 68, 0.2)',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: 2,
                                tension: 0.1,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': ' + context.raw;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                },
                                x: {
                                    ticks: {
                                        maxRotation: 45,
                                        minRotation: 45
                                    }
                                }
                            },
                            interaction: {
                                mode: 'nearest',
                                axis: 'x',
                                intersect: false
                            }
                        }
                    });
                } else {
                    if (chartElement) {
                        chartElement.parentElement.innerHTML = '<p class="text-center text-gray-500 py-8">Нет данных активности за сегодня.</p>';
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
