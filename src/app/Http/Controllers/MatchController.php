<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $matches = Matches::with(['user1', 'user2'])
            ->where(function($query) use ($user) {
                $query->where('user1_id', $user->id)
                    ->orWhere('user2_id', $user->id);
            })
            ->get()
            ->map(function ($match) use ($user) {
                return [
                    'other_user_id' => $match->user1_id == $user->id ? $match->user2_id : $match->user1_id,
                    'user' => $match->user1_id == $user->id ? $match->user2 : $match->user1,
                    'score' => $match->match_score
                ];
            })
            ->groupBy('other_user_id')
            ->map(function ($userMatches) {
                return $userMatches->sortByDesc('score')->first();
            })
            ->sortByDesc('score')
            ->values();

        return view('matches.index', [
            'matches' => $matches
        ]);
    }


    public function check()
    {
        $user = Auth::user();
        $userFavorites = $user->favorites()->pluck('meme_id');

        $potentialMatches = User::where('id', '!=', $user->id)
            ->whereHas('favorites', function($query) use ($userFavorites) {
                $query->whereIn('meme_id', $userFavorites);
            })
            ->withCount(['favorites as common_favorites' => function($query) use ($userFavorites) {
                $query->whereIn('meme_id', $userFavorites);
            }])
            ->orderByDesc('common_favorites')
            ->get();

        foreach ($potentialMatches as $matchUser) {
            Matches::updateOrCreate(
                [
                    'user1_id' => min($user->id, $matchUser->id),
                    'user2_id' => max($user->id, $matchUser->id),
                ],
                [
                    'match_score' => $matchUser->common_favorites
                ]
            );
        }

        return redirect()->route('matches.index');
    }
}
