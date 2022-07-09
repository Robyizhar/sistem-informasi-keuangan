<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests\Master\RoleRequest;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\Menu;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        try{
            return view('management-user.role.index');
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function getData () {
        $data = Role::query()->latest();
        return DataTables::of($data)
        ->addColumn('permissions', function($data){
            $roles = $data->permissions()->get();
            $badges = '';
            if($data->name == 'Maintener'){
                $badges .= '<span class="badge badge-secondary m-1">'.'All Permissions'.'</span>';
            } else {
                foreach ($roles as $key => $role) {
                    $badges .= '<span class="badge badge-secondary m-1">'.$role->name.'</span>';
                }
            }
            return $badges;
        })
        ->addColumn('Action', function ($data) {
            if ($data->name == 'Maintener')
                return '';

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('role.edit', $data->id),
                'url_destroy' => route('role.destroy', $data->id),
                'menu' => 'Role'
            ]);
        })
        ->addIndexColumn()
        ->rawColumns(['Action', 'permissions'])
        ->make(true);
    }

    public function create() {
        try{
            $data['menus'] = Menu::all();
            $data['permissions'] = Permission::select('name','id', 'menu_id')->orderBy('name','asc')->get();
            return view('management-user.role.create', compact('data'));
        }catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('role.index');
        }
    }

    public function store(Request $request) {
        try{
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            $role->syncPermissions($request->permissions);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('role.index');
        }catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function edit($id) {
        try{
            $data['detail']  = Role::where('id',$id)->first();
            if(!$data['detail'])
                return redirect()->route('role.index')->with('error', 'Role tidak ditemukan!');

            $data['role_permission'] = $data['detail']->permissions()->pluck('id')->toArray();
            $data['menus'] = Menu::all();
            $data['permissions'] = Permission::select('name','id', 'menu_id')->orderBy('name','asc')->get();
            return view('management-user.role.create', compact('data'));
        }catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('role.index');
        }
    }

    public function update(Request $request) {
        try{

            $role = Role::find($request->id);

            if(!$role) {
                Alert::toast('Role tidak ditemukan!', 'error');
                return redirect()->back();
            }

            $update = $role->update([ 'name' => $request->name, 'guard_name' => 'web' ]);
            $role->syncPermissions($request->permissions);
            Alert::toast($request->name.' Berhasil Dirumah', 'success');
            return redirect()->route('role.index');
        }catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy($id) {
        $role = Role::find($id);
        $users = User::role($role->name)->get();
        if($role){
            if (count($users) <= 0) {
                $delete = $role->delete();
                $perm   = $role->permissions()->delete();
                // Alert::toast('Role berhasil dihapus!', 'success');
                return response()->json($delete, 200);
            } else {
                // Alert::toast('Role sudah dipakai oleh user', 'error');
                return 'false';
            }
        }else{
            // Alert::toast('Role Tidak Ditemukan', 'error');
            return 'false';
        }
    }
}
