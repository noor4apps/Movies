<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function topStatistics()
    {
        $genresCount = number_format(Genre::count(), 1);
        $moviesCount = number_format(Movie::count(), 1);
        $actorsCount = number_format(Actor::count(), 1);

        return response()->json([
            'genres_count' => $genresCount,
            'movies_count' => $moviesCount,
            'actors_count' => $actorsCount,
        ]);

    }
}
