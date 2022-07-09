<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Siswa;
use App\Models\Angkatan;
use App\Models\Jurusan;

class SiswaController extends Controller
{
    protected $model, $role;

    public function __construct(Siswa $Siswa) {
        $this->model = new BaseRepository($Siswa);
        $this->middleware('auth');
    }

    public function index() {
        return view('master.siswa.index');
    }

    public function getData() {
        $data = Siswa::with('jurusan', 'angkatan')->orderBy('id', 'DESC')->get();
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('siswa.edit', $data->id),
                'url_destroy' => route('siswa.destroy', $data->id),
                'menu' => 'Siswa'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function create() {
        try {
            $angkatans = Angkatan::get();
            $jurusans = Jurusan::get();
            return view('master.siswa.create', compact('angkatans', 'jurusans'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('siswa.index');
        }
    }

    public function store(Request $request) {
        // return $request;
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $siswa = $this->model->store($data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('siswa.index');
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
            return view('master.siswa.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('siswa.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $siswa = $this->model->update($request->id, $data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('siswa.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('siswa.index');
        }
    }

    public function destroy($id) {
        try {
            $siswa = $this->model->softDelete($id);
            return response()->json($siswa, 200);
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('siswa.index');
        }
    }
}
