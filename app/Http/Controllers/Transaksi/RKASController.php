<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\RKAS;
use App\Models\PemasukanBos;
use App\Models\GolonganRkas;
use App\Models\RKASDetail;
use DB;

class RKASController extends Controller {

    protected $model, $role;

    public function __construct(RKAS $RKAS) {
        $this->model = new BaseRepository($RKAS);
        $this->middleware('auth');
    }

    public function index() {
        return view('transaksi.rkas.index');
    }

    public function getData() {
        $data = PemasukanBos::query()->orderBy('id', 'DESC');
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_detail' => route('rkas.detail', $data->id),
                'menu' => 'RKAS'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function create() {
        try {
            // $data = [
            //     'pemasukan_bos' => PemasukanBos::where('year', now()->year)->orderBy('step', 'asc')->get(),
            //     'golongan_rkas' => GolonganRkas::with('sub_golongan')->orderBy('code', 'asc')->get(),
            // ];
            // return $data;
            return view('transaksi.rkas.create');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('rkas.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            DB::beginTransaction();
            $rkas = RKAS::updateOrCreate(
                [
                    'sub_golongan_rkas_id' => $request->sub_golongan_rkas_id,
                    'golongan_rkas_id' => $request->golongan_rkas_id,
                ],
                [
                    'amount_total' => $request->row_amount_total,
                    'golongan_rkas_name' => $request->golongan_rkas_name,
                    'sub_golongan_rkas_name' => $request->sub_golongan_rkas_name,
                    'volume' => $request->volume,
                    'unit' => $request->unit,
                    'unit_price' => $request->unit_price,
                ]
            );
            RKASDetail::updateOrCreate(
                [
                    'rkas_id' => $rkas->id,
                    'pemasukan_bos_detail_id' => $request->pemasukan_bos_detail_id,
                    'sub_golongan_rkas_id' => $request->sub_golongan_rkas_id,
                ],
                [
                    'description' => $request->description,
                    'amount_total' => $request->amount_total,
                    'sub_golongan_rkas_name' => $request->sub_golongan_rkas_name,
                ]
            );
            DB::commit();
            return response()->json($rkas, 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $data = PemasukanBos::with('pemasukan_detail', 'golongan_rkas.sub_golongan.rkas.rkas_detail')->find($id);
            // return $data;
            return view('transaksi.rkas.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('rkas.index');
        }
    }

    public function edit($id) {
        try {
            $data['detail'] = $this->model->find($id);
            return view('transaksi.rkas.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('rkas.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $golongan_rkas = $this->model->update($request->id, $data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('rkas.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('rkas.index');
        }
    }

    public function destroy($id) {
        try {
            $golongan_rkas = $this->model->softDelete($id);
            return response()->json($golongan_rkas, 200);
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('rkas.index');
        }
    }
}
