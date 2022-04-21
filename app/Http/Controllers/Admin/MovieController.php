<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_movies')->only(['index', 'data', 'show']);
        $this->middleware('permission:delete_movies')->only(['delete', 'bulk_delete']);
    }

    public function index()
    {
        $genres = Genre::pluck('id', 'name');

        $actor = null;

        if (request()->actor_id) {
            $actor = Actor::find(request()->actor_id);
        }

        return view('admin.movies.index', compact('genres', 'actor'));
    }

    public function data()
    {
        $movies = Movie::query()
            ->whenGenreId(request()->genre_id)
            ->whenActorId(request()->actor_id)
            ->whenType(request()->type)
            ->withCount('favoredByUsers')
            ->with('genres:id,name');

        return DataTables::of($movies)
            ->addColumn('record_select', 'admin.movies.data_table.record_select')
            ->addColumn('poster', function (Movie $movie) {
                return view('admin.movies.data_table.poster', compact('movie'));
            })
            ->addColumn('genres', function (Movie $movie) {
                return view('admin.movies.data_table.genres', compact('movie'));
            })
            ->addColumn('vote', 'admin.movies.data_table.vote')
            ->editColumn('created_at', function (Movie $movie) {
                return $movie->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.movies.data_table.actions')
            ->rawColumns(['record_select', 'vote', 'actions'])
            ->toJson();

    }

    public function show(Movie $movie)
    {
        $movie->with('genres:id,name', 'actors', 'images');

        return view('admin.movies.show', compact('movie'));
    }

    public function destroy(Movie $movie)
    {
        $this->delete($movie);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $movie = Movie::FindOrFail($recordId);
            $this->delete($movie);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }

    private function delete(Movie $movie)
    {
        $movie->delete();

    }
}
