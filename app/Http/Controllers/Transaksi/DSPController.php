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
use App\Models\PemasukanSppDsp;
use DB;

class DSPController extends Controller
{
    protected $model, $income;

    public function __construct(PembayaranDsp $PembayaranDsp, PemasukanSppDsp $PemasukanSppDsp) {
        $this->model = new BaseRepository($PembayaranDsp);
        $this->income = new BaseRepository($PemasukanSppDsp);
        $this->middleware('auth');
    }

    public function index() {
        return view('transaksi.dsp.index');
    }

    public function getData() {
        $data = Siswa::with('angkatan')->orderBy('name', 'asc')->get();
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_detail' => url('dsp/create?siswa_id='.$data->id),
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

    public function create(Request $request) {
        try {
            $data['jurusans'] = Jurusan::get();
            $data['angkatans'] = Angkatan::get();
            if (isset($request->siswa_id)) {
                $data['siswa'] = Siswa::with('angkatan', 'jurusan', 'dsp')->where('id', $request->siswa_id)->firstOrFail();
            }
            return view('transaksi.dsp.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('dsp.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id', 'jurusan_id', 'angkatan_id', 'name']);
            DB::beginTransaction();
            $dsp = $this->model->store($data);
            if ($dsp) {
                $this->income->store([
                    'pembayaran_dsp_id' => $dsp->id,
                    'siswa_id' => $request->siswa_id,
                    'income_source' => 'dsp',
                    'income_total' => $data['total_payment']
                ]);
            }
            Alert::toast('Pembayaran '.$request->name.' Berhasil Disimpan', 'success');
            DB::commit();
            return redirect()->route('dsp.index');
        } catch (\Throwable $e) {
            DB::rollback();
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $dsp = $this->model->softDelete($id);
            if ($dsp) {
                $income = PemasukanSppDsp::where('pembayaran_dsp_id', $id)->first();
                $income->delete();
            }
            DB::commit();
            return response()->json($dsp, 200);
        } catch (\Throwable $e) {
            DB::rollback();
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('dsp.index');
        }
    }
}
