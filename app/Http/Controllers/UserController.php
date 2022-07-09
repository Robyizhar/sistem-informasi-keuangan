<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller {

    protected $model, $role;

    public function __construct(User $user) {
        $this->model = new BaseRepository($user);
        $this->middleware('auth');
    }

    public function index() {
        return view('management-user.user.index');
    }

    public function getData() {
        $data = User::query()->orderBy('id', 'ASC');
        return DataTables::of($data)
        ->addColumn('Roles', function($data){
            $roles = $data->getRoleNames()->toArray();
            $badge = '';
            if($roles){
                $badge .= '<span class="badge badge-secondary m-1">'.implode(' , ', $roles).'</span>';
            }
            return $badge;
        })
        ->addColumn('Aksi', function ($data) {
            if(implode(' , ', $data->getRoleNames()->toArray()) == 'Developer')
                return '-';

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('user.edit', $data->id),
                'url_destroy' => route('user.destroy', $data->id),
                'menu' => 'User'
            ]);
        })
        ->addIndexColumn()
        ->rawColumns(['Aksi', 'Roles'])
        ->make(true);
    }

    public function create() {
        try {
            $roles = Role::pluck('name','id');
            return view('management-user.user.create', compact('roles'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('user.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id', 'password_confirm', 'role']);
            $data['password'] = Hash::make($request->password);
            $data['role_id'] = $request->role;
            $user = $this->model->store($data);
            $user->syncRoles($request->role);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('user.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function edit($id) {
        try {
            $data['detail'] = $this->model->find($id);
            $user_role = $data['detail']->roles->first();
            $roles     = Role::pluck('name','id');
            return view('management-user.user.create', compact('data','user_role','roles'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('user.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $data['password'] = Hash::make($request->password);
            $user = $this->model->update($request->id, $data);
            $user->syncRoles($request->role);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('user.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('user.index');
        }
    }

    public function destroy($id) {
        try {
            $this->model->softDelete($id);
            Alert::toast($request->name.' Berhasil Dihapus', 'success');
            return redirect()->route('user.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('user.index');
        }
    }
}
