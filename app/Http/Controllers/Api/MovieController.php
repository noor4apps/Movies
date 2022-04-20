<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::query()
            ->whenType(request()->type)
            ->whenSearch(request()->search)
            ->paginate(10);

        $data['movies'] = MovieResource::collection($movies)->response()->getData(true);

        return response()->api($data);
    }
}
