<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_genres')->only(['index']);
        $this->middleware('permission:delete_genres')->only(['delete', 'bulk_delete']);
    }

    public function index()
    {
        return view('admin.genres.index');
    }

    public function data()
    {
        $genres = Genre::select();

        return DataTables::of($genres)
            ->addColumn('record_select', 'admin.genres.data_table.record_select')
            ->editColumn('created_at', function (Genre $genre) {
                return $genre->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.genres.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();
    }

    public function destroy(Genre $genre)
    {
        $this->delete($genre);

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $genre = Genre::FindOrFail($recordId);
            $this->delete($genre);

        }

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

    private function delete(Genre $genre)
    {
        $genre->delete();
    }
}
