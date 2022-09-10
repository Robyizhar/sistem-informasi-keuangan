@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('siswa.store') : route('siswa.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="form-group mb-3">
        <label class="required">Nama Siswa</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('name') : old('name', $data['detail']->name) }}" type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="name" />
        @if($errors->has('name'))
            <div class="text-danger"> {{ $errors->first('name')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">NIPD</label>
        <input value="{{ !isset($data['detail']) ? old('nipd') : old('nipd', $data['detail']->nipd) }}" type="text" name="nipd" class="form-control mb-2 @error('nipd') is-invalid @enderror" placeholder="nipd" />
        @if($errors->has('nipd'))
            <div class="text-danger"> {{ $errors->first('nipd')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">NISN</label>
        <input value="{{ !isset($data['detail']) ? old('nisn') : old('nisn', $data['detail']->nisn) }}" type="text" name="nisn" class="form-control mb-2 @error('nisn') is-invalid @enderror" placeholder="nisn" />
        @if($errors->has('nisn'))
            <div class="text-danger"> {{ $errors->first('nisn')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Alamat Siswa</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('address') : old('address', $data['detail']->address) }}" type="text" name="address" class="form-control mb-2 @error('address') is-invalid @enderror" placeholder="address" />
        @if($errors->has('address'))
            <div class="text-danger"> {{ $errors->first('address')}} </div>
        @endif
    </div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <select name="gender" class="form-control">
            <option value="Laki - laki">Laki - laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>
    <div class="form-group">
        <label>Angkatan</label>
        <select name="angkatan_id" class="form-control">
            @foreach ($angkatans as $angkatan)
                <option value="{{ $angkatan->id }}">{{ $angkatan->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Jurusan</label>
        <select name="jurusan_id" class="form-control">
            @foreach ($jurusans as $jurusan)
                <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
            @endforeach
        </select>
    </div>
    @endslot
@endcomponent
@endsection
@push('script')
@endpush
