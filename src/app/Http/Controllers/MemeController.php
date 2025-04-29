<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\Swipe;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemeController extends Controller
{
    public function index()
    {
        $memes = Meme::latest()->paginate(10);
        return view('memes.index', compact('memes'));
    }

    public function create()
    {
        return view('memes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $request->file('image')->store('memes', 'public');
        Meme::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'image_url' => asset(Storage::url($imagePath))
        ]);

        return redirect()->route('memes.index')->with('success', 'Мем успешно добавлен!');
    }

    public function getRandomMeme()
    {
        $swipedMemeIds = Swipe::where('user_id', Auth::id())->pluck('meme_id');

        $meme = Meme::whereNotIn('id', $swipedMemeIds)
            ->inRandomOrder()
            ->first();

        if (!$meme) {
            return view('no-memes');
        }

        $totalSwipes = Swipe::where('user_id', Auth::id())->count();
        $totalLikes = Swipe::where('user_id', Auth::id())->where('action', 'like')->count();

        return view('swipe', [
            'memes' => $meme,
            'totalSwipes' => $totalSwipes,
            'totalLikes' => $totalLikes
        ]);
    }

    public function handleSwipe(Request $request, Meme $meme)
    {
        $validated = $request->validate([
            'action' => 'required|in:like,dislike'
        ]);

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
        }

        return response()->json([
            'success' => true,
            'redirect' => route('memes.random')
        ]);
    }

    public function toggleFavorite(Meme $meme)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('meme_id', $meme->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Мем удален из избранного');
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'meme_id' => $meme->id
            ]);
            return back()->with('success', 'Мем добавлен в избранное');
        }
    }

    public function show(Meme $meme)
    {
        return view('memes.show', compact('meme'));
    }

    public function destroy(Meme $meme)
    {
        Favorite::where('meme_id', $meme->id)->delete();
        Swipe::where('meme_id', $meme->id)->delete();

        $imagePath = str_replace(asset('storage'), 'public', $meme->image_url);
        Storage::delete($imagePath);

        $meme->delete();

        return redirect()->route('memes.index')
            ->with('success', 'Мем успешно удален');
    }
}
