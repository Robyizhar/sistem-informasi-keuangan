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
        $data = RKAS::query()->orderBy('id', 'ASC');
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('rkas.edit', $data->id),
                'url_destroy' => route('rkas.destroy', $data->id),
                'menu' => 'RKAS'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function create() {
        try {
            $data = [
                'pemasukan_bos' => PemasukanBos::where('year', now()->year)->orderBy('step', 'asc')->get(),
                'golongan_rkas' => GolonganRkas::with('sub_golongan')->orderBy('code', 'asc')->get(),
            ];
            // return $data;
            return view('transaksi.rkas.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('rkas.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            return $data;
            DB::beginTransaction();
            foreach ($data['rkas'] as $value) {
                $rkas = RKAS::create([
                    'name' => 'RKAS TAHUN INI'
                ]);
                foreach ($value->golongan_rkas as $golongan_rkas => $value) {
                    RKASDetail::create([
                        'rkas_id' => $rkas->id,
                        'pemasukan_bos_id' => $value->pemasukan_bos,
                        'golongan_rkas_id' => $golongan_rkas,
                        'sub_golongan_rkas_id' => $golongan_rkas
                    ]);
                }
            }
            // $golongan_rkas = $this->model->store($data);
            // if ($golongan_rkas && !empty($request->sub_golongan)) {
            //     for ($i=0; $i < sizeOf($request->sub_golongan); $i++) {
            //         SubGolonganRkas::create([
            //             'golongan_rkas_id' => $golongan_rkas->id,
            //             'name' => $request->sub_golongan[$i]
            //         ]);
            //     }
            // }
            DB::commit();
            // Alert::toast($request->name.' Berhasil Disimpan', 'success');
            // return redirect()->route('rkas.index');
        } catch (\Throwable $e) {
            DB::rollback();
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
