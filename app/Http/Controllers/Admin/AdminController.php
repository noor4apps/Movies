<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_admins')->only(['index']);
        $this->middleware('permission:create_admins')->only(['create', 'store']);
        $this->middleware('permission:update_admins')->only(['edit', 'update']);
        $this->middleware('permission:delete_admins')->only(['delete', 'bulk_delete']);
    }

    public function index()
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin', 'user'])->get();
        return view('admin.admins.index', compact('roles'));
    }

    public function data()
    {
        $admins = User::whereRoleIs('admin')
            ->whenRoleId(request()->role_id);

        return DataTables::of($admins)
            ->addColumn('record_select', 'admin.admins.data_table.record_select')
            ->addColumn('roles', function (User $admin) {
                return view('admin.admins.data_table.roles', compact('admin'));
            })
            ->editColumn('created_at', function (User $admin) {
                return $admin->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.admins.data_table.actions')
            ->rawColumns(['record_select', 'roles', 'actions'])
            ->toJson();
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();

        return view('admin.admins.create', compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $requestData = $request->all();
        $requestData['password'] = bcrypt($request->password);

        $admin = User::create($requestData);
        $admin->attachRoles(['admin', $request->role_id]);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.admins.index');
    }

    public function edit(User $admin)
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();

        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(AdminRequest $request, User $admin)
    {
        $admin->update($request->validated());
        $admin->syncRoles(['admin', $request->role_id]);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.admins.index');
    }

    public function destroy(User $admin)
    {
        $this->delete($admin);

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $admin = User::FindOrFail($recordId);
            $this->delete($admin);
        }

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }

    private function delete(User $admin)
    {
        $admin->delete();
    }
}
