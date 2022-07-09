<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    protected $model, $role;

    public function __construct(Jurusan $Jurusan) {
        $this->model = new BaseRepository($Jurusan);
        $this->middleware('auth');
    }

    public function index() {
        return view('master.jurusan.index');
    }

    public function getData() {
        $data = Jurusan::query()->orderBy('id', 'ASC');
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('jurusan.edit', $data->id),
                'url_destroy' => route('jurusan.destroy', $data->id),
                'menu' => 'Jurusan'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function create() {
        try {
            return view('master.jurusan.create');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('jurusan.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $jurusan = $this->model->store($data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('jurusan.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        try {
            $data['detail'] = $this->model->find($id);
            return view('master.jurusan.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('jurusan.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $jurusan = $this->model->update($request->id, $data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('jurusan.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('jurusan.index');
        }
    }

    public function destroy($id) {
        try {
            $jurusan = $this->model->softDelete($id);
            return response()->json($jurusan, 200);
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('jurusan.index');
        }
    }
}
