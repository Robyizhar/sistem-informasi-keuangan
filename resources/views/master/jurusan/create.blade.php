@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('jurusan.store') : route('jurusan.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="form-group mb-3">
        <label class="required">Kode Jurusan</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('code') : old('code', $data['detail']->code) }}" type="text" name="code" class="form-control mb-2 @error('code') is-invalid @enderror" placeholder="code" />
        @if($errors->has('code'))
            <div class="text-danger"> {{ $errors->first('code')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Nama Jurusan</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('name') : old('name', $data['detail']->name) }}" type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="name" />
        @if($errors->has('name'))
            <div class="text-danger"> {{ $errors->first('name')}} </div>
        @endif
    </div>
    @endslot
@endcomponent
@endsection
@push('script')
@endpush
