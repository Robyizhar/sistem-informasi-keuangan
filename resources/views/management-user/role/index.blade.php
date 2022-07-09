@extends('layouts.main')
@push('style')

@endpush
@section('content')
    @component('layouts.component.datatable')
        @slot('action', route('role.create'))
        @slot('content')
            <th width="12px;">No</th>
            <th>Nama</th>
            <th>Permision</th>
            <th width="20%">Aksi</th>
        @endslot
    @endcomponent
@endsection
@push('script')
<script>
$(document).ready( function () {
    let datatable = $('#state-saving-datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        method: "POST",
        sPaginationType: "full_numbers",
        ajax: {
            url: "{!! url('role/get-data') !!}",
            type: "POST",
            dataType: "JSON"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'permissions', name: 'permissions'},
            {data: 'Action', name: 'Action'}
        ]
    });
});
</script>
@endpush
