<?php

namespace App\Http\Controllers;

use App\Models\Swipe;
use App\Models\Favorite;
use App\Models\Matches;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $swipeStats = [
            'total' => Swipe::where('user_id', $user->id)->count(),
            'likes' => Swipe::where('user_id', $user->id)
                ->where('action', 'like')
                ->count(),
            'dislikes' => Swipe::where('user_id', $user->id)
                ->where('action', 'dislike')
                ->count(),
        ];

        $favoriteStats = [
            'total' => Favorite::where('user_id', $user->id)->count(),
            'last_added' => Favorite::with('meme')
                ->where('user_id', $user->id)
                ->latest()
                ->take(3)
                ->get(),
        ];

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
                    $otherUser = $match->user1_id == $user->id ? $match->user2 : $match->user1;
                    return [
                        'user' => $otherUser ? $otherUser : null,
                        'score' => $match->match_score
                    ];
                })
                ->filter(function ($match) {
                    return !is_null($match['user']);
                }),
        ];


        $recentActions = Swipe::with('meme')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($swipe) {
                $memeTitle = $swipe->meme ? $swipe->meme->title : '[удаленный мем]';
                return (object) [
                    'type' => $swipe->action,
                    'message' => $swipe->action === 'like'
                        ? 'Вы лайкнули мем "' . $memeTitle . '"'
                        : 'Вы дизлайкнули мем "' . $memeTitle . '"',
                    'created_at' => $swipe->created_at
                ];
            });

        $activityData = $this->getDailyActivity($user);

        return view('stats.index', [
            'swipeStats' => $swipeStats,
            'favoriteStats' => $favoriteStats,
            'matchStats' => $matchStats,
            'recentActions' => $recentActions,
            'user' => $user,
            'activityData' => $activityData,
        ]);
    }

    private function getDailyActivity(User $user)
    {
        $hours = [];
        $likes = [];
        $dislikes = [];

        $today = now()->toDateString();

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
            ->keyBy('hour');

        for ($hour = 0; $hour < 24; $hour++) {
            $hours[] = sprintf('%02d:00', $hour);

            $hourlyData = $swipesToday->get($hour);

            $likes[] = $hourlyData ? (int)$hourlyData->likes : 0;
            $dislikes[] = $hourlyData ? (int)$hourlyData->dislikes : 0;
        }

        return [
            'hours' => $hours,
            'likes' => $likes,
            'dislikes' => $dislikes,
        ];
    }
}
