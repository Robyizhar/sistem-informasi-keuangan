@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('pemasukan_bos.store') : route('pemasukan_bos.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="form-group mb-3">
        <label class="required">Tahun</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ now()->year }}" readonly type="text" name="year" class="form-control mb-2 @error('year') is-invalid @enderror" />
        @if($errors->has('year'))
            <div class="text-danger"> {{ $errors->first('year')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Tipe Pemasukan</label>
        <select name="type" class="form-control">
            <option value="REGULER">REGULER</option>
            <option value="LAINNYA">LAINNYA</option>
        </select>
        @if($errors->has('type'))
            <div class="text-danger"> {{ $errors->first('type')}} </div>
        @endif
    </div>
    <div class="form-group">
        <label>Tahap</label>
        <select name="step" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        @if($errors->has('step'))
            <div class="text-danger"> {{ $errors->first('step')}} </div>
        @endif
    </div>
    <div class="form-group">
        <label>Dana Yang Diterima</label>
        <input value="{{ !isset($data['detail']) ? old('received_funds') : old('received_funds', $data['detail']->received_funds) }}" type="text" name="received_funds" class="form-control mb-2 @error('received_funds') is-invalid @enderror" />
    </div>
    @endslot
@endcomponent
@endsection
@push('script')
@endpush
