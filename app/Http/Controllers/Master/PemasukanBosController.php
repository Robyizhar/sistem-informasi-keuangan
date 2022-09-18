<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PemasukanBos;

class PemasukanBosController extends Controller
{
    protected $model, $role;

    public function __construct(PemasukanBos $PemasukanBos) {
        $this->model = new BaseRepository($PemasukanBos);
        $this->middleware('auth');
    }

    public function index() {
        return view('master.pemasukan_bos.index');
    }

    public function getData() {
        $data = PemasukanBos::orderBy('step', 'ASC')->get();
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('pemasukan_bos.edit', $data->id),
                'url_destroy' => route('pemasukan_bos.destroy', $data->id),
                'menu' => 'Bos'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function create() {
        return view('master.pemasukan_bos.create');
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $recent_data = PemasukanBos::where('year', $request->year)->where('step', $request->step)->first();
            if(!empty($recent_data)) {
                Alert::toast('Step '.$request->step.' Tahun '.$request->year.' Sudah ada', 'error');
                return back();
            }

            $this->model->store($data);
            Alert::toast('Pemasukan Bos Berhasil Disimpan', 'success');

            return redirect()->route('pemasukan_bos.index');
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
            return view('master.pemasukan_bos.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('pemasukan_bos.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $pemasukan_bos = $this->model->update($request->id, $data);
            Alert::toast('Pemasukan Bos Berhasil Diupdate', 'success');
            return redirect()->route('pemasukan_bos.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('pemasukan_bos.index');
        }
    }

    public function destroy($id) {
        //
    }
}
