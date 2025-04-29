<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('meme')
            ->where('user_id', Auth::id())
            ->paginate(10);

        return view('favorites.index', ['favorites' => $favorites]);
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $favorite->delete();

        return back()->with('status', 'Мем удален из избранного');
    }
}
