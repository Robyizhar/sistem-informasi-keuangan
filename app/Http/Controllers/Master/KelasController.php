<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Kelas;

class KelasController extends Controller
{
    protected $model, $role;

    public function __construct(Kelas $Kelas) {
        $this->model = new BaseRepository($Kelas);
        $this->middleware('auth');
    }

    public function index() {
        return view('master.kelas.index');
    }

    public function getData() {
        $data = Kelas::query()->orderBy('id', 'ASC');
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('kelas.edit', $data->id),
                'url_destroy' => route('kelas.destroy', $data->id),
                'menu' => 'Kelas'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function create() {
        try {
            return view('master.kelas.create');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('kelas.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $kelas = $this->model->store($data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('kelas.index');
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
            return view('master.kelas.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('kelas.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $kelas = $this->model->update($request->id, $data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('kelas.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('kelas.index');
        }
    }

    public function destroy($id) {
        try {
            $kelas = $this->model->softDelete($id);
            return response()->json($kelas, 200);
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('kelas.index');
        }
    }
}
