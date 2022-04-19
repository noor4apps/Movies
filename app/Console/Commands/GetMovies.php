<?php

namespace App\Console\Commands;

use App\Models\Actor;
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

        $this->getNowPlayingMovies();

        $this->getUpcomingMovies();

        $this->info('all commands were successful!');
    }

    private function getPopularMovies()
    {
        for ($i = 1 ; $i <= config('services.tmdb.max_pages'); $i++) {

            $response = Http::get(config('services.tmdb.base_url') . '/movie/popular?region=us&api_key=' . config('services.tmdb.api_key') . '&page=' . $i);

            foreach ($response->json()['results'] as $result) {

                $movie = Movie::updateOrCreate(
                    [
                        'e_id' => $result['id'],
                        'title' => $result['title'],
                    ],
                    [
                        'description' => $result['overview'],
                        'poster' => $result['poster_path'],
                        'banner' => $result['backdrop_path'],
                        'release_date' => $result['release_date'],
                        'vote' => $result['vote_average'],
                        'vote_count' => $result['vote_count'],
                    ]);

                $this->attachGenres($movie, $result);

                $this->getAndAttachActors($movie);

                $this->getImages($movie);
            }

        }

        $this->info('get Popular Movies was successful!');
    }

    private function getNowPlayingMovies()
    {
        for ($i = 1 ; $i <= config('services.tmdb.max_pages'); $i++) {

            $response = Http::get(config('services.tmdb.base_url') . '/movie/now_playing?region=us&api_key=' . config('services.tmdb.api_key') . '&page=' . $i);

            foreach ($response->json()['results'] as $result) {

                $movie = Movie::updateOrCreate(
                    [
                        'e_id' => $result['id'],
                        'title' => $result['title'],
                    ],
                    [
                        'description' => $result['overview'],
                        'poster' => $result['poster_path'],
                        'banner' => $result['backdrop_path'],
                        'type' => 'now_playing',
                        'release_date' => $result['release_date'],
                        'vote' => $result['vote_average'],
                        'vote_count' => $result['vote_count'],
                    ]);

                $this->attachGenres($movie, $result);

                $this->getAndAttachActors($movie);

                $this->getImages($movie);
            }

        }

        $this->info('get Now Playing Movies was successful!');
    }

    private function getUpcomingMovies()
    {
        for ($i = 1 ; $i <= config('services.tmdb.max_pages'); $i++) {

            $response = Http::get(config('services.tmdb.base_url') . '/movie/upcoming?region=us&api_key=' . config('services.tmdb.api_key') . '&page=' . $i);

            foreach ($response->json()['results'] as $result) {

                $movie = Movie::updateOrCreate(
                    [
                        'e_id' => $result['id'],
                        'title' => $result['title'],
                    ],
                    [
                        'description' => $result['overview'],
                        'poster' => $result['poster_path'],
                        'banner' => $result['backdrop_path'],
                        'type' => 'upcoming',
                        'release_date' => $result['release_date'],
                        'vote' => $result['vote_average'],
                        'vote_count' => $result['vote_count'],
                    ]);

                $this->attachGenres($movie, $result);

                $this->getAndAttachActors($movie);

                $this->getImages($movie);
            }

        }

        $this->info('get Upcoming Movies was successful!');
    }


    private function attachGenres(Movie $movie, $result)
    {
        foreach ($result['genre_ids'] as $genre_id) {
            $genre = Genre::select('id')->where('e_id', $genre_id)->first();
            $movie->genres()->syncWithoutDetaching($genre->id);
        }
    }

    private function getAndAttachActors(Movie $movie)
    {
        $response = Http::get(config('services.tmdb.base_url') . '/movie/' . $movie->e_id . '/credits?api_key=' . config('services.tmdb.api_key'));

        foreach ($response->json()['cast'] as $index => $cast) {

            if ($cast['known_for_department'] != 'Acting') continue;

            if ($index == 12) break;

            $actor = Actor::where('e_id', $cast['id'])->first();

            if (!$actor) {
                $actor = Actor::create([
                    'e_id' => $cast['id'],
                    'name' => $cast['name'],
                    'image' => $cast['profile_path'],
                ]);
            }

            $movie->actors()->syncWithoutDetaching($actor->id);
        }

    }

    public function getImages(Movie $movie)
    {
        $response = Http::get(config('services.tmdb.base_url') . '/movie/' . $movie->e_id . '/images?api_key=' . config('services.tmdb.api_key'));

        $movie->images()->delete();

        foreach ($response->json()['backdrops'] as $index => $image) {

            if ($index == 8) break;

            $movie->images()->create([
                'image' => $image['file_path']
            ]);

        }
    }

}
