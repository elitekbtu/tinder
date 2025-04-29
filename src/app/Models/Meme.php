<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meme extends Model
{
    protected $fillable = ['image_url', 'title', 'description', 'category', 'user_id'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function swipes(): HasMany
    {
        return $this->hasMany(Swipe::class);
    }

    public function favoritedBy(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
