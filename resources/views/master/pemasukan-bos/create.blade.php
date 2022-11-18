@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($detail) ? route('pemasukan-bos.store') : route('pemasukan-bos.update'))
    @isset ($detail)
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="form-group mb-3">
        <label class="required">Tahun</label>
        <input type="hidden" value="{{ !isset($detail) ? '' : $detail->id }}" id="id" name="id">
        <input value="{{ isset($detail->year) ? $detail->year : now()->year }}" readonly type="text" id="year" name="year" class="form-control mb-2 @error('year') is-invalid @enderror" />
        @if($errors->has('year'))
            <div class="text-danger"> {{ $errors->first('year')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Tipe Pemasukan</label>
        <select name="type" class="form-control">
            <option value="REGULER" {{ isset($detail->type) && $detail->type === 'REGULER' && 'selected' }}>REGULER</option>
            <option value="LAINNYA" {{ isset($detail->type) && $detail->type === 'LAINNYA' && 'selected' }}>LAINNYA</option>
        </select>
        @if($errors->has('type'))
            <div class="text-danger"> {{ $errors->first('type')}} </div>
        @endif
    </div>
    <a class="triggerSub btn btn-primary btn-submit waves-effect waves-light float-right mb-4">Tambah Tahap Penerimaan</a>
    <table class="table" id="table-data-sub">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama</th>
                <th>Penerimaan Dana</th>
                <th>Periode Mulai</th>
                <th>Periode Akhir</th>
                <th width="10%">Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    @endslot
@endcomponent
@endsection
@push('script')
<table class="template-sub" style="display: none;">
    <tr class="template-sub-list" childidx="0" style="position: relative;">
        <td class="text-center">
			<span class="index"></span>
        </td>
		<td class="text-center">
			<input required readonly class="form-control form-white text-left sub_name" type="text" name="sub[0][name]" autocomplete="off" />
			<input readonly class="form-control form-white text-left sub_id" type="hidden" name="sub[0][id]" autocomplete="off" />
        </td>
		<td class="text-center">
			<input required class="form-control form-white text-left sub_received_funds withseparator" type="text" name="sub[0][received_funds]" autocomplete="off" />
        </td>
		<td class="text-center">
			<input required class="form-control form-white text-left sub_start_date" type="date" name="sub[0][start_date]" autocomplete="off" />
        </td>
		<td class="text-center">
			<input required class="form-control form-white text-left sub_end_date" type="date" name="sub[0][end_date]" autocomplete="off" />
        </td>
        <td class="action-buton">
            <button class='btn btn-sm btn-danger removesub' type='button'>HAPUS</button>
			<input class="data-id" type="hidden" autocomplete="off" />
        </td>
    </tr>
</table>

<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/pemasukan_bos.js') }}"></script>
@isset($detail)
    <script>
        getDataDetail();
    </script>
@endisset
@endpush
