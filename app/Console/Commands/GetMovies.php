<?php

namespace App\Console\Commands;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all movies from TMDB';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getPopularMovies();

        $this->info('The commands were successful!');
    }

    private function getPopularMovies()
    {
        for ($i = 1 ; $i <= config('services.tmdb.max_pages'); $i++) {

            $response = Http::get(config('services.tmdb.base_url') . '/movie/popular?region=us&api_key=' . config('services.tmdb.api_key') . '&page=' . $i);

            foreach ($response->json()['results'] as $result) {
                $movie = Movie::create([
                    'e_id' => $result['id'],
                    'title' => $result['title'],
                    'description' => $result['overview'],
                    'poster' => $result['poster_path'],
                    'banner' => $result['backdrop_path'],
                    'release_date' => $result['release_date'],
                    'vote' => $result['vote_average'],
                    'vote_count' => $result['vote_count'],
                ]);

                foreach ($result['genre_ids'] as $genre_id) {
                    $genre = Genre::select('id')->where('e_id', $genre_id)->first();
                    $movie->genres()->attach($genre->id);
                }
            }

        }

        $this->info('get Popular Movies was successful!');
    }
}
