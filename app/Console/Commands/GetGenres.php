<?php

namespace App\Console\Commands;

use App\Models\Genre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all genres from TMDB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get(config('services.tmdb.base_url') . '/genre/movie/list?api_key=' . config('services.tmdb.api_key'));

        foreach ($response->json()['genres'] as $genre) {

            Genre::updateOrCreate(
                [
                    'e_id' => $genre['id'],
                ],
                [
                    'name' => $genre['name']
                ]);

        }

        $this->info('get genres was successful!');
    }
}
