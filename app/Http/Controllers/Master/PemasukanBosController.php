<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PemasukanBos;
use App\Models\PemasukanBosDetail;
use DB;

class PemasukanBosController extends Controller
{
    protected $model, $role;

    public function __construct(PemasukanBos $PemasukanBos, PemasukanBosDetail $PemasukanBosDetail) {
        $this->model = new BaseRepository($PemasukanBos);
        $this->PemasukanBosDetail = new BaseRepository($PemasukanBosDetail);
        $this->middleware('auth');
    }

    public function index() {
        return view('master.pemasukan-bos.index');
    }

    public function getData() {
        $data = PemasukanBos::orderBy('year', 'DESC')->get();
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('pemasukan-bos.edit', $data->id),
                'url_destroy' => route('pemasukan-bos.destroy', $data->id),
                'menu' => 'Bos'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function getDetail(Request $request) {
        $detail = PemasukanBosDetail::where('m_pemasukan_bos_id', $request->id)->get();
        return $detail;
    }

    public function create() {
        return view('master.pemasukan-bos.create');
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id', 'sub']);
            $recent_data = PemasukanBos::where('year', $request->year)->first();

            if(!empty($recent_data)) {
                Alert::toast(' Tahun '.$request->year.' Sudah ada, silahkan untuk membuat lagi tahun depan', 'warning');
                return back();
            }

            $data['name'] = 'Pemasukan Bos Tahun '.$data['year'];

            DB::beginTransaction();
            $master = $this->model->store($data);

            if (!empty($request->sub)) {
                foreach ($request->sub as $sub) {
                    $this->PemasukanBosDetail->store([
                        "m_pemasukan_bos_id"        => $master->id,
                        "name"                      => $sub['name'],
                        "received_funds"            => str_replace(",", "", $sub['received_funds']),
                        "start_date"                => date("Y-M-d", strtotime($sub['start_date'])),
                        "end_date"                  => date("Y-M-d", strtotime($sub['end_date']))
                    ]);
                }
            }
            DB::commit();

            Alert::toast('Pemasukan Bos Berhasil Disimpan', 'success');

            return redirect()->route('pemasukan-bos.index');
        } catch (\Throwable $e) {
            DB::rollback();
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function edit($id) {
        try {
            $detail = $this->model->find($id);
            return view('master.pemasukan-bos.create', compact('detail'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('pemasukan-bos.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id', 'sub']);

            DB::beginTransaction();
            $master = $this->model->update($request->id, $data);
            if (!empty($request->sub)) {
                foreach ($request->sub as $sub) {
                    PemasukanBosDetail::updateOrCreate(
                        [
                            "m_pemasukan_bos_id"        => $master->id,
                            "name"                      => $sub['name'],
                        ],
                        [
                            "received_funds"            => str_replace(",", "", $sub['received_funds']),
                            "start_date"                => date("Y-M-d", strtotime($sub['start_date'])),
                            "end_date"                  => date("Y-M-d", strtotime($sub['end_date']))
                        ]
                    );
                }
            }
            DB::commit();

            Alert::toast('Pemasukan Bos Berhasil Diupdate', 'success');
            return redirect()->route('pemasukan-bos.index');
        } catch (\Throwable $e) {
            DB::rollback();
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('pemasukan-bos.index');
        }
    }

    public function destroy($id) {
        $data = PemasukanBos::findOrFail($id);
        if (!$data)
            return redirect()->route('pemasukan-bos.index');

        DB::beginTransaction();
        try {
            $data->delete();
            DB::commit();
            return response()->json('Berhasil Menghapus Data', 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json('Gagal Menghapus Data', 500);
        }

    }
}
