@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile',false)
    @slot('action', !isset($data['detail']) ? route('role.store') : route('role.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')

    <div class="form-group mb-3">
        <label class="required form-label">Judul</label>
        <input type="hidden" value="{{ !isset($data['detail']) ? '' : $data['detail']->id }}" name="id">
        <input value="{{ !isset($data['detail']) ? old('name') : old('name', $data['detail']->name) }}" type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="Role" />
        @if($errors->has('name'))
            <div class="text-danger">
                {{ $errors->first('name')}}
            </div>
        @endif
    </div>

    {{-- @foreach ($data['menus'] as $menu) --}}

    <div class="form-group mb-3">
        @foreach ($data['permissions'] as $permission)


        @php $permission_name = explode("-", $permission->name) @endphp

        <label class="mr-3">
            <input type="checkbox" class="" id="item_checkbox" name="permissions[]" value="{{$permission->id}}"
            {{ isset($data['role_permission']) && in_array($permission->id, $data['role_permission']) ? 'checked' : '' }}>
            <span class=""> {{ $permission_name[0] }} </span>
        </label>


        @endforeach
        <div id="bar" class="progress mb-3" style="height: 7px;">
            <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 0%;"></div>
        </div>

    </div>

    {{-- @endforeach --}}
    @endslot
@endcomponent
@endsection
@push('script')
@endpush
