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
        //
    }

    public function store(Request $request) {
        //
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
