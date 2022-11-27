@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('golongan-rkas.store') : route('golongan-rkas.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="row">
        <div class="col-md-4 form-group mb-3">
            <label class="required">Kode Golongan</label>
            <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
            <input value="{{ !isset($data['detail']) ? old('code') : old('code', $data['detail']->code) }}" type="text" name="code" class="form-control mb-2 @error('code') is-invalid @enderror" placeholder="code" />
            @if($errors->has('code')) <div class="text-danger"> {{ $errors->first('code')}} </div> @endif
        </div>
        <div class="col-md-4 form-group mb-3">
            <label class="required">Nama Golongan</label>
            <input value="{{ !isset($data['detail']) ? old('name') : old('name', $data['detail']->name) }}" type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="name" />
            @if($errors->has('name')) <div class="text-danger"> {{ $errors->first('name')}} </div> @endif
        </div>
        <div class="col-md-4 form-group mb-3">
            <label class="required">Pemasukan Bos</label>
            <select name="pemasukan_bos_id" class="form-control">
                @foreach ($pemasukan_bos as $pemasukan)
                    <option value="{{ $pemasukan->id }}">{{ $pemasukan->name }}</option>
                @endforeach
            </select>
            @if($errors->has('pemasukan_bos_id'))
                <div class="text-danger"> {{ $errors->first('pemasukan_bos_id')}} </div>
            @endif
        </div>
        <div class="col-md-6 form-group mb-3">
            <button type="button" class="btn btn-secondary create-sub-golongan btn-submit waves-effect waves-light">Tambah Sub Golongan</button>
        </div>
        <div class="col-md-6 form-group mb-3 sub_golongan">
            @isset($data['detail']->sub_golongan)

                @foreach ($data['detail']->sub_golongan as $sub_golongan)
                    <input value="{{ $sub_golongan->name }}" type="text" name="sub_golongan[]" class="form-control mb-2" placeholder="sub_golongan" />
                    <input value="{{ $sub_golongan->volume }}" type="text" name="volume[]" class="form-control mb-2" placeholder="volume" />
                    <hr>
                @endforeach

            @endisset
        </div>
    </div>
    @endslot
@endcomponent
@endsection
@push('script')
    <script>
        $('.create-sub-golongan').click(function (e) {
            e.preventDefault();
            $(".sub_golongan").append(`
                <input value="" type="text" name="sub_golongan[]" class="form-control mb-2" placeholder="sub_golongan" />
                <input value="" type="text" name="volume[]" class="form-control mb-2" placeholder="volume" />
                <hr>
            `);
        });
    </script>
@endpush
