<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Angkatan;

class AngkatanController extends Controller
{
    protected $model, $role;

    public function __construct(Angkatan $Angkatan) {
        $this->model = new BaseRepository($Angkatan);
        $this->middleware('auth');
    }

    public function index() {
        return view('master.angkatan.index');
    }

    public function getData() {
        $data = Angkatan::query()->orderBy('id', 'ASC');
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('angkatan.edit', $data->id),
                'url_destroy' => route('angkatan.destroy', $data->id),
                'menu' => 'Angkatan'
            ]);

        })
        ->addColumn('SPP', function ($data) {

            return 'Rp. '.number_format($data->spp_cost,2,",",".");

        })
        ->addColumn('DSP', function ($data) {

            return 'Rp. '.number_format($data->dsp_cost,2,",",".");

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi', 'SPP', 'DSP'])
        ->make(true);
    }

    public function create() {
        try {
            return view('master.angkatan.create');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('angkatan.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $angkatan = $this->model->store($data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('angkatan.index');
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
            return view('master.angkatan.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('angkatan.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $angkatan = $this->model->update($request->id, $data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('angkatan.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('angkatan.index');
        }
    }

    public function destroy($id) {
        try {
            $angkatan = $this->model->softDelete($id);
            return response()->json($angkatan, 200);
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('angkatan.index');
        }
    }
}
