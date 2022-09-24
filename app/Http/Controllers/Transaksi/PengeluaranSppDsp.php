<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PemasukanSppDsp;
use App\Models\PengeluaranSppDsp AS Pengeluaran;
use DB;

class PengeluaranSppDsp extends Controller
{
    protected $model, $income;

    public function __construct(Pengeluaran $Pengeluaran, PemasukanSppDsp $PemasukanSppDsp) {
        $this->model = new BaseRepository($Pengeluaran);
        $this->income = new BaseRepository($PemasukanSppDsp);
        $this->middleware('auth');
    }

    public function index(Request $request){
        return view('transaksi.pengeluaran-spp-dsp.index');
    }

    public function getData() {
        $data = Pengeluaran::orderBy('name', 'asc')->get();
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_detail' => url('pengeluaran-spp-dsp/create?id='.$data->id),
                'menu' => 'PengeluaranSppDsp'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);

    }

    public function create() {
        try {

            $data['income'] = PemasukanSppDsp::sum('income_total');
            $data['expenditure'] = Pengeluaran::sum('unit_total_price');

            return view('transaksi.pengeluaran-spp-dsp.create', compact('data'));
        } catch (\Throwable $e) {

            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('pengeluaran-spp-dsp.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id', 'unit_total_price_hidden']);
            DB::beginTransaction();
            $data['unit_total_price'] = $data['unit_price'] * $data['unit_quantity'];
            $this->model->store($data);
            Alert::toast('Pembayaran '.$request->name.' Berhasil Disimpan', 'success');
            DB::commit();
            return redirect()->route('pengeluaran-spp-dsp.index');
        } catch (\Throwable $e) {
            DB::rollback();
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

}
