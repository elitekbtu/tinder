<?php

namespace Database\Seeders;

use App\Models\Meme;
use App\Models\User;
use App\Models\Swipe;
use App\Models\Favorite;
use App\Models\Matches;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Favorite::query()->delete();
        Swipe::query()->delete();
        Matches::query()->delete();
        User::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $users = User::factory()
            ->count(10)
            ->create();

        $this->call(MemeSeeder::class);

        $allMemes = Meme::all();

        foreach ($users as $user) {
            $memesToSwipe = $allMemes->random(min(15, $allMemes->count()));
            foreach ($memesToSwipe as $meme) {
                Swipe::create([
                    'user_id' => $user->id,
                    'meme_id' => $meme->id,
                    'action' => rand(0, 1) ? 'like' : 'dislike'
                ]);
            }

            $memesToFavorite = $allMemes->random(min(3, $allMemes->count()));
            foreach ($memesToFavorite as $meme) {
                Favorite::create([
                    'user_id' => $user->id,
                    'meme_id' => $meme->id
                ]);
            }
        }

        if ($users->count() > 1) {
            for ($i = 0; $i < min(5, $users->count() * 2); $i++) {
                $user1 = $users->random();
                $user2 = $users->where('id', '!=', $user1->id)->random();

                Matches::create([
                    'user1_id' => $user1->id,
                    'user2_id' => $user2->id,
                    'match_score' => rand(70, 100)
                ]);
            }
        }

        $this->command->info('Создано:');
        $this->command->info('- '.User::count().' пользователей');
        $this->command->info('- '.Meme::count().' мемов');
        $this->command->info('- '.Swipe::count().' свайпов');
        $this->command->info('- '.Favorite::count().' избранных мемов');
        $this->command->info('- '.Matches::count().' совпадений');
    }
}
