<?php

namespace App\Http\Controllers;

use App\Models\Swipe;
use App\Models\Favorite;
use App\Models\Matches; // Убедитесь, что модель Matches импортирована
use App\Models\User;    // Импортируем модель User
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // Импортируем фасад DB для группировки

class StatsController extends Controller
{
    /**
     * Display the user's statistics.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Статистика по свайпам (остается без изменений)
        $swipeStats = [
            'total' => Swipe::where('user_id', $user->id)->count(),
            'likes' => Swipe::where('user_id', $user->id)
                ->where('action', 'like')
                ->count(),
            'dislikes' => Swipe::where('user_id', $user->id)
                ->where('action', 'dislike')
                ->count(),
        ];

        // Статистика по избранному (остается без изменений)
        $favoriteStats = [
            'total' => Favorite::where('user_id', $user->id)->count(),
            'last_added' => Favorite::with('meme')
                ->where('user_id', $user->id)
                ->latest()
                ->take(3)
                ->get(),
        ];

        // Статистика по совпадениям (остается без изменений)
        $matchStats = [
            'total' => Matches::where(function($query) use ($user) {
                $query->where('user1_id', $user->id)
                    ->orWhere('user2_id', $user->id);
            })
                ->count(),
            'top_matches' => Matches::with(['user1', 'user2'])
                ->where(function($query) use ($user) {
                    $query->where('user1_id', $user->id)
                        ->orWhere('user2_id', $user->id);
                })
                ->orderByDesc('match_score')
                ->take(5)
                ->get()
                ->map(function ($match) use ($user) {
                    // Определяем другого пользователя в паре
                    $otherUser = $match->user1_id == $user->id ? $match->user2 : $match->user1;
                    return [
                        // Проверяем, что $otherUser не null, прежде чем обращаться к 'name'
                        'user' => $otherUser ? $otherUser : null, // Передаем объект User или null
                        'score' => $match->match_score
                    ];
                })
                ->filter(function ($match) {
                    // Фильтруем возможные null значения, если связь user1 или user2 нарушена
                    return !is_null($match['user']);
                }),
        ];


        // Получаем последние действия (свайпы) - остается без изменений
        $recentActions = Swipe::with('meme')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($swipe) {
                // Добавляем проверку, существует ли связанный мем
                $memeTitle = $swipe->meme ? $swipe->meme->title : '[удаленный мем]';
                return (object) [
                    'type' => $swipe->action,
                    'message' => $swipe->action === 'like'
                        ? 'Вы лайкнули мем "' . $memeTitle . '"'
                        : 'Вы дизлайкнули мем "' . $memeTitle . '"',
                    'created_at' => $swipe->created_at
                ];
            });

        // Данные для графика активности (теперь за день)
        $activityData = $this->getDailyActivity($user); // Вызываем новый метод

        return view('stats.index', [
            'swipeStats' => $swipeStats,
            'favoriteStats' => $favoriteStats,
            'matchStats' => $matchStats,
            'recentActions' => $recentActions,
            'user' => $user,
            'activityData' => $activityData,
        ]);
    }

    /**
     * Получаем данные активности за текущий день по часам
     */
    private function getDailyActivity(User $user) // Принимаем объект User
    {
        $hours = [];
        $likes = [];
        $dislikes = [];

        $today = now()->toDateString();

        // Получаем агрегированные данные одним запросом для эффективности
        $swipesToday = Swipe::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('SUM(CASE WHEN action = "like" THEN 1 ELSE 0 END) as likes'),
            DB::raw('SUM(CASE WHEN action = "dislike" THEN 1 ELSE 0 END) as dislikes')
        )
            ->where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour', 'asc')
            ->get()
            ->keyBy('hour'); // Индексируем коллекцию по часам для быстрого доступа

        // Заполняем массивы данными для каждого часа (0-23)
        for ($hour = 0; $hour < 24; $hour++) {
            $hours[] = sprintf('%02d:00', $hour); // Формат ЧЧ:00

            $hourlyData = $swipesToday->get($hour); // Получаем данные для текущего часа

            $likes[] = $hourlyData ? (int)$hourlyData->likes : 0;
            $dislikes[] = $hourlyData ? (int)$hourlyData->dislikes : 0;
        }

        return [
            'hours' => $hours, // Меняем ключ с 'days' на 'hours'
            'likes' => $likes,
            'dislikes' => $dislikes,
        ];
    }
}
