<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActorResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::query()
            ->with('genres')
            ->whenType(request()->type)
            ->whenSearch(request()->search)
            ->whenGenreId(request()->genre_id)
            ->whenActorId(request()->actor_id)
            ->whenFavoredById(request()->favored_by_id)
            ->paginate(10);

        $data['movies'] = MovieResource::collection($movies)->response()->getData(true);

        return response()->api($data);
    }

    public function actors(Movie $movie)
    {
        return response()->api(ActorResource::collection($movie->actors));
    }

    public function images(Movie $movie)
    {
        return response()->api(ImageResource::collection($movie->images));
    }

    public function related(Movie $movie)
    {
        $movies = Movie::whereHas('genres', function ($q) use ($movie) {
            return $q->whereIn('name', $movie->genres()->pluck('name'));
        })
            ->with('genres')
            ->where('id', '!=', $movie->id)
            ->paginate(10);

        return response()->api(MovieResource::collection($movies));
    }

    public function toggleFavorite()
    {
        auth()->user()->favoredMovies()->toggle([request()->movie_id]);

        return response()->api([], 0, 'movie toggled successfully');
    }

    public function isFavored(Movie $movie)
    {
        $data['is_favored'] = $movie->isFavored();

        return response()->api($data);
    }
}
