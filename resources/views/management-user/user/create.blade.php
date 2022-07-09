@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('user.store') : route('user.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="form-group mb-3">
        <label class="required">Nama</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('name') : old('name', $data['detail']->name) }}" type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="name" />
        @if($errors->has('name'))
            <div class="text-danger"> {{ $errors->first('name')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Email</label>
        <input value="{{ !isset($data['detail']) ? old('email') : old('email', $data['detail']->email) }}" type="text" name="email" class="form-control mb-2" placeholder="email" />
        @if($errors->has('email'))
            <div class="text-danger"> {{ $errors->first('email')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="{{ !isset($data['detail']) ? 'required' : '' }}">Password</label>
        <input autocomplete="off" type="password" name="password" class="form-control mb-2" placeholder="password" />
        @if($errors->has('password'))
            <div class="text-danger"> {{ $errors->first('password')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="{{ !isset($data['detail']) ? 'required' : '' }}">Konfirmasi Password</label>
        <input autocomplete="off" type="password" name="password_confirm" class="form-control mb-2" placeholder="konfirmasi password" />
        @if($errors->has('password_confirm'))
            <div class="text-danger"> {{ $errors->first('password_confirm')}} </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="required">Roles</label>
        {!! Form::select('role', $roles, $user_role->id??'' ,[ 'class'=>'form-control select2', 'placeholder' => 'Pilih Role','id' => 'role', 'required' => 'required']) !!}
    </div>
    @endslot
@endcomponent
@endsection
@push('script')
@endpush
