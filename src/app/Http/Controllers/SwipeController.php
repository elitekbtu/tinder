<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\Swipe;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SwipeController extends Controller
{
    /**
     * Display the swipe interface with a random meme.
     */
    public function index(): View
    {
        $swipedMemeIds = Swipe::where('user_id', Auth::id())->pluck('meme_id');

        $meme = Meme::whereNotIn('id', $swipedMemeIds)
            ->inRandomOrder()
            ->first();

        if (!$meme) {
            return view('swipe.no-memes');
        }

        $totalSwipes = Swipe::where('user_id', Auth::id())->count();
        $totalLikes = Swipe::where('user_id', Auth::id())
            ->where('action', 'like')
            ->count();

        return view('swipe.index', [
            'meme' => $meme,
            'totalSwipes' => $totalSwipes,
            'totalLikes' => $totalLikes
        ]);
    }

    public function store(Request $request, Meme $meme): RedirectResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:like,dislike'
        ]);

        $existingSwipe = Swipe::where('user_id', Auth::id())
            ->where('meme_id', $meme->id)
            ->first();

        if ($existingSwipe) {
            return back()->with('error', 'Вы уже реагировали на этот мем ранее');
        }

        Swipe::create([
            'user_id' => Auth::id(),
            'meme_id' => $meme->id,
            'action' => $validated['action']
        ]);

        if ($validated['action'] === 'like') {
            Favorite::firstOrCreate([
                'user_id' => Auth::id(),
                'meme_id' => $meme->id
            ]);

            $likeCount = Favorite::where('user_id', Auth::id())->count();
            if ($likeCount >= 10) {
                return redirect()->route('matches.check')
                    ->with('status', 'Вы лайкнули 10+ мемов! Проверьте свои совпадения!');
            }
        }

        return redirect()->route('swipe.index')
            ->with('status', $validated['action'] === 'like' ? 'Мем добавлен в избранное!' : 'Мем пропущен');
    }

    public function history(): View
    {
        $swipes = Swipe::with('meme')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('swipe.history', [
            'swipes' => $swipes,
            'totalLikes' => Swipe::where('user_id', Auth::id())
                ->where('action', 'like')
                ->count(),
            'totalDislikes' => Swipe::where('user_id', Auth::id())
                ->where('action', 'dislike')
                ->count(),
        ]);
    }
    public function clearHistory(): RedirectResponse
    {
        Swipe::where('user_id', Auth::id())->delete();

        return redirect()->route('swipe.history')
            ->with('status', 'История свайпов успешно очищена');
    }

}
