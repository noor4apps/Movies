<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ActorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_actors')->only(['index']);
        $this->middleware('permission:delete_actors')->only(['delete', 'bulk_delete']);
    }

    public function index()
    {
        if (request()->ajax()) {
            $actors = Actor::where('name', 'like', '%' . request()->search . '%')
                ->limit(10)
                ->get();

            $results[] = ['id' => '', 'text' => 'All Actors'];

            foreach ($actors as $actor) {
                $results[] = ['id' => $actor->id, 'text' => $actor->name];
            }

            return json_encode($results);
        }

        return view('admin.actors.index');
    }

    public function data()
    {
        $actors = Actor::withCount('movies');

        return DataTables::of($actors)
            ->addColumn('record_select', 'admin.actors.data_table.record_select')
            ->addColumn('related_movies', 'admin.actors.data_table.related_movies')
            ->addColumn('image', function (Actor $actor) {
                return view('admin.actors.data_table.image', compact('actor'));
            })
            ->editColumn('created_at', function (Actor $actor) {
                return $actor->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.actors.data_table.actions')
            ->rawColumns(['record_select', 'image', 'related_movies', 'actions'])
            ->toJson();
    }

    public function destroy(Actor $actor)
    {
        $this->delete($actor);

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $actor = Actor::FindOrFail($recordId);
            $this->delete($actor);
        }

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

    private function delete(Actor $actor)
    {
        $actor->delete();
    }
}
