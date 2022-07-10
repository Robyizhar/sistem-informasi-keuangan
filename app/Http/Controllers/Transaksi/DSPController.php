<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PembayaranDsp;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\Siswa;

class DSPController extends Controller
{
    protected $model, $role;

    public function __construct(PembayaranDsp $PembayaranDsp) {
        $this->model = new BaseRepository($PembayaranDsp);
        $this->middleware('auth');
    }

    public function index() {
        return view('transaksi.dsp.index');
    }

    public function getData() {
        $data = PembayaranDsp::with('siswa')->orderBy('id', 'DESC')->get();
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('dsp.edit', $data->id),
                'url_detail' => route('dsp.detail', $data->id),
                'url_destroy' => route('dsp.destroy', $data->id),
                'menu' => 'PembayaranDsp'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function getSiswa(Request $request) {
        try {
            $siswas = Siswa::with('angkatan', 'jurusan', 'dsp')
            ->when($request->jurusan_id != '', function($query) use ($request){
                return $query->where('jurusan_id', $request->jurusan_id);
            })
            ->when($request->angkatan_id != '', function($query) use ($request){
                return $query->where('angkatan_id', $request->angkatan_id);
            })
            ->orderBy('id', 'DESC')->get();
            return response()->json($siswas, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function create() {
        try {
            $jurusans = Jurusan::get();
            $angkatans = Angkatan::get();
            return view('transaksi.dsp.create', compact('jurusans', 'angkatans'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('dsp.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id', 'jurusan_id', 'angkatan_id', 'name']);
            $dsp = $this->model->store($data);
            Alert::toast('Pembayaran '.$request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('dsp.index');
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
            return view('transaksi.dsp.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('dsp.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $dsp = $this->model->update($request->id, $data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('dsp.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('dsp.index');
        }
    }

    public function destroy($id) {
        try {
            $dsp = $this->model->softDelete($id);
            return response()->json($dsp, 200);
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('dsp.index');
        }
    }
}
