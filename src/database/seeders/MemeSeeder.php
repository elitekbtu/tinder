<?php

namespace Database\Seeders;

use App\Models\Meme;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();
        $images = [
            '6fb726d46f5894ed0c67399b8b42f4c0.jpg',
            'AQAKRxkU2aN6P00br0cSbXcJIDY5Js8HQNN4db0f2_IBuf7N5ZOEIQrBxLPp-h0M3ftbQH_IIONp5pM6hWP_V37Kh5M.jpg',
            'dwlfjkekwirjm.jpg',
            'E6GAXzIqe7M.jpg',
            'fcjvbijkleweklegtjkbm.png',
            'fd5f2444b5493fc67e00d5f2ff2c8c39.jpg',
            'orig.png',
            'thumb_17628_articles_standard.png',
            'ьььу.jpg'
        ];

        $categories = ['Юмор', 'Кино', 'Игры', 'IT', 'Животные', 'Мемы'];

        foreach ($images as $image) {
            if (Storage::disk('public')->exists("memes/$image")) {
                Meme::create([
                    'user_id' => $user->id,
                    'title' => pathinfo($image, PATHINFO_FILENAME),
                    'description' => 'Автоматически сгенерированный мем из сидера',
                    'category' => $categories[array_rand($categories)],
                    'image_url' => asset(Storage::url("memes/$image"))
                ]);
            } else {
                $this->command->warn("Файл $image не найден в storage/app/public/memes");
            }
        }

        $this->command->info('Успешно создано ' . count($images) . ' мемов');
    }
}
