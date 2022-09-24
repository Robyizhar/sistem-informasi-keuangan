<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\GolonganRkas;
use App\Models\SubGolonganRkas;
use Illuminate\Support\Facades\DB;

class GolonganRKASController extends Controller {

    protected $model, $role;

    public function __construct(GolonganRkas $GolonganRkas) {
        $this->model = new BaseRepository($GolonganRkas);
        $this->middleware('auth');
    }

    public function index() {
        return view('master.golongan-rkas.index');
    }

    public function getData() {
        $data = GolonganRkas::query()->orderBy('id', 'ASC');
        return DataTables::of($data)
        ->addColumn('Aksi', function ($data) {

            return view('layouts.component.action', [
                'model' => $data,
                'url_edit' => route('golongan-rkas.edit', $data->id),
                'url_destroy' => route('golongan-rkas.destroy', $data->id),
                'menu' => 'GolonganRkas'
            ]);

        })
        ->addIndexColumn()
        ->rawColumns(['Aksi'])
        ->make(true);
    }

    public function create() {
        try {
            return view('master.golongan-rkas.create');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('golongan-rkas.index');
        }
    }

    public function store(Request $request) {

        try {
            $data = $request->except(['_token', '_method', 'id']);
            DB::beginTransaction();
            $golongan_rkas = $this->model->store($data);
            if ($golongan_rkas && !empty($request->sub_golongan)) {
                for ($i=0; $i < sizeOf($request->sub_golongan); $i++) {
                    SubGolonganRkas::create([
                        'golongan_rkas_id' => $golongan_rkas->id,
                        'name' => $request->sub_golongan[$i]
                    ]);
                }
            }
            DB::commit();
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('golongan-rkas.index');
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
            return view('master.golongan-rkas.create', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('golongan-rkas.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->except(['_token', '_method', 'id']);
            $golongan_rkas = $this->model->update($request->id, $data);
            Alert::toast($request->name.' Berhasil Disimpan', 'success');
            return redirect()->route('golongan-rkas.index');
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('golongan-rkas.index');
        }
    }

    public function destroy($id) {
        try {
            $golongan_rkas = $this->model->softDelete($id);
            return response()->json($golongan_rkas, 200);
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('golongan-rkas.index');
        }
    }
}
