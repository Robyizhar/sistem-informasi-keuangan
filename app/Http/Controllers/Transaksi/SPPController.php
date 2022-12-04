<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PembayaranSpp;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\PemasukanSppDsp;
use DB;

class SPPController extends Controller
{
    protected $model, $income;

    public function __construct(PembayaranSpp $PembayaranSpp, PemasukanSppDsp $PemasukanSppDsp) {
        $this->model = new BaseRepository($PembayaranSpp);
        $this->income = new BaseRepository($PemasukanSppDsp);
        $this->middleware('auth');
    }

    public function index() {
        $data['jurusans'] = Jurusan::get();
        $data['angkatans'] = Angkatan::get();
        return view('transaksi.spp.index', compact('data'));
    }

    public function getData(Request $request) {

        try {
            $this->validate($request, [
                'jurusan' => 'required|exists:App\Models\Jurusan,id,deleted_at,NULL',
                'angkatan' => 'required|exists:App\Models\Angkatan,id,deleted_at,NULL',
            ]);

            $data =  Siswa::where('angkatan_id', $request->angkatan)
                ->where('jurusan_id', $request->jurusan)
                ->with('angkatan', 'jurusan', 'spp')
                ->orderBy('name', 'asc')
                ->get();
            return DataTables::of($data)
            ->addColumn('Aksi', function ($data) {

                return view('layouts.component.action', [
                    'model' => $data,
                    'url_detail' => url('spp/create?siswa_id='.$data->id),
                    'menu' => 'PembayaranSpp'
                ]);

            })
            ->addColumn('Status', function ($data) {
                if ($data->angkatan->kelas == 1) {

                    $current_payments = array_sum(array_column($data->spp->toArray(), 'total_payment'));
                    $remains = (array) date_diff(date_create_from_format('Y-m-d', $data->angkatan->entry_year."-06-01"), date_create_from_format('Y-m-d', date('Y-m-d')));
                    $ideal_payoff = $remains['m'] * $data->angkatan->spp_cost;
                    $payment_arrears = $ideal_payoff - $current_payments;

                    if ($payment_arrears <= 0)
                        return view('layouts.component.badge', [ 'paid_off' => 'Lunas' ]);

                    return view('layouts.component.badge', [ 'arrears' => 'Rp. '.number_format($payment_arrears, 2) ]);

                } else if (($data->angkatan->kelas == 2)) {

                    $current_payments = array_sum(array_column($data->spp->toArray(), 'total_payment'));
                    $remains = (array) date_diff(date_create_from_format('Y-m-d', $data->angkatan->entry_year."-06-01"), date_create_from_format('Y-m-d', date('Y-m-d')));
                    $ideal_payoff = ($remains['m'] + 12) * $data->angkatan->spp_cost;
                    $payment_arrears = $ideal_payoff - $current_payments;

                    if ($payment_arrears <= 0)
                        return view('layouts.component.badge', [ 'paid_off' => 'Lunas' ]);

                    return view('layouts.component.badge', [ 'arrears' => 'Rp. '.number_format($payment_arrears, 2) ]);

                } else if (($data->angkatan->kelas == 3)) {
                    $current_payments = array_sum(array_column($data->spp->toArray(), 'total_payment'));
                    $remains = (array) date_diff(date_create_from_format('Y-m-d', $data->angkatan->entry_year."-06-01"), date_create_from_format('Y-m-d', date('Y-m-d')));
                    $ideal_payoff = ($remains['m'] + 24) * $data->angkatan->spp_cost;
                    $payment_arrears = $ideal_payoff - $current_payments;

                    if ($payment_arrears <= 0)
                        return view('layouts.component.badge', [ 'paid_off' => 'Lunas' ]);

                    return view('layouts.component.badge', [ 'arrears' => 'Rp. '.number_format($payment_arrears, 2) ]);
                }

            })
            ->addIndexColumn()
            ->rawColumns(['Aksi'])
            ->make(true);
        } catch (\Throwable $th) {
            // $data = [];
            // return DataTables::of($data)->addColumn('Aksi', function ($data) {})->addIndexColumn()->rawColumns(['Aksi'])->make(true);
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function filter(Request $request) {
        try {
            $this->validate($request, [
                'jurusan_id' => 'required|exists:App\Models\Jurusan,id,deleted_at,NULL',
                'angkatan_id' => 'required|exists:App\Models\Angkatan,id,deleted_at,NULL',
            ]);
            return redirect('spp?jurusan='.$request->jurusan_id.'&angkatan='.$request->angkatan_id);
        } catch (\Throwable $th) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('spp.index');
        }
    }

    public function getSiswa(Request $request) {
        try {
            $siswas = Siswa::with('angkatan', 'jurusan')
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

    public function getPayment(Request $request) {

        $payments = Kelas::whereHas('spp_payment', function ($query) use ($request) {
            $query->where('siswa_id', $request->siswa_id);
            if ($request->kelas == 1) {
                $query->where('kelas_id', 1);
            } else if (($request->kelas == 2)) {
                $query->whereIn('kelas_id', [1,2]);
            } else if (($request->kelas == 3)) {
                $query->whereIn('kelas_id', [1,2,3]);
            }
        })->with(['spp_payment' => function ($query) use ($request) {
            $query->where('siswa_id', $request->siswa_id);
            if ($request->kelas == 1) {
                $query->where('kelas_id', 1);
            } else if (($request->kelas == 2)) {
                $query->whereIn('kelas_id', [1,2]);
            } else if (($request->kelas == 3)) {
                $query->whereIn('kelas_id', [1,2,3]);
            }
        }])->get();

        return response()->json($payments, 200);

    }

    // $data['siswa'] = Siswa::with('angkatan', 'jurusan')->with('spp', function ($query) use ($siswa) {
        // if ($siswa->angkatan->kelas == 1) {
        //     $query->where('kelas_id', 1);
        // } else if (($siswa->angkatan->kelas == 2)) {
        //     $query->whereIn('kelas_id', [1,2]);
        // } else if (($siswa->angkatan->kelas == 3)) {
        //     $query->whereIn('kelas_id', [1,2,3]);
        // }
    // })->where('id', $request->siswa_id)->firstOrFail();

    public function create(Request $request) {

        try {
            $data['jurusans'] = Jurusan::get();
            $data['angkatans'] = Angkatan::get();
            if (isset($request->siswa_id)) {
                $data['siswa'] = Siswa::with('angkatan', 'jurusan', 'spp')->where('id', $request->siswa_id)->firstOrFail();
            }
            // return $data['siswa'];
            return view('transaksi.spp.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('spp.index');
        }

    }

    public function store(Request $request) {

        try {

            $data = $request->except(['_token', '_method', 'id', 'jurusan_id', 'angkatan_id', 'name', 'spp_total_cost_paymant']);

            DB::beginTransaction();
            $income_from_spp = 0;

            if (isset($data['payment'])) {

                $spp_cost_per_month = Angkatan::where('id', $request->angkatan_id)->firstOrFail();

                for ($i=0; $i < count($data['payment']); $i++) {

                    $data_payment = [ 'total_payment' => $spp_cost_per_month->spp_cost ];
                    $spp = $this->model->update($data['payment'][$i], $data_payment);
                    $income_from_spp = $income_from_spp + $spp_cost_per_month->spp_cost;

                }

                if ($income_from_spp > 0) {

                    $this->income->store([
                        'siswa_id' => $request->siswa_id,
                        'income_source' => 'spp',
                        'income_total' => $income_from_spp
                    ]);

                }

            }

            Alert::toast('Pembayaran '.$request->name.' Berhasil Disimpan', 'success');
            DB::commit();
            return redirect()->route('spp.index');

        } catch (\Throwable $e) {

            DB::rollback();
            Alert::toast($e->getMessage(), 'error');
            return back();

        }
    }

    public function destroy($id) {

        try {

            DB::beginTransaction();
            $spp = $this->model->softDelete($id);
            if ($spp) {
                $income = PemasukanSppDsp::where('pembayaran_spp_id', $id)->first();
                $income->delete();
            }
            DB::commit();
            return response()->json($spp, 200);

        } catch (\Throwable $e) {

            DB::rollback();
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('spp.index');

        }
    }
}
