@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('angkatan.store') : route('angkatan.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="form-group mb-3">
        <label class="required">Kode Angkatan</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('code') : old('code', $data['detail']->code) }}" type="text" name="code" class="form-control mb-2 @error('code') is-invalid @enderror" placeholder="code" />
        @if($errors->has('code'))
            <div class="text-danger"> {{ $errors->first('code')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Nama Angkatan</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('name') : old('name', $data['detail']->name) }}" type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="name" />
        @if($errors->has('name'))
            <div class="text-danger"> {{ $errors->first('name')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Tahun Masuk</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('entry_year') : old('entry_year', $data['detail']->entry_year) }}" type="text" name="entry_year" class="form-control mb-2 @error('entry_year') is-invalid @enderror" placeholder="entry_year" />
        @if($errors->has('entry_year'))
            <div class="text-danger"> {{ $errors->first('entry_year')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Biaya Spp Per Bulan</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('spp_cost') : old('spp_cost', $data['detail']->spp_cost) }}" type="text" name="spp_cost" class="form-control mb-2 @error('spp_cost') is-invalid @enderror" placeholder="spp_cost" />
        @if($errors->has('spp_cost'))
            <div class="text-danger"> {{ $errors->first('spp_cost')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Biaya DSP</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('dsp_cost') : old('dsp_cost', $data['detail']->dsp_cost) }}" type="text" name="dsp_cost" class="form-control mb-2 @error('dsp_cost') is-invalid @enderror" placeholder="dsp_cost" />
        @if($errors->has('dsp_cost'))
            <div class="text-danger"> {{ $errors->first('dsp_cost')}} </div>
        @endif
    </div>
    @endslot
@endcomponent
@endsection
@push('script')
@endpush