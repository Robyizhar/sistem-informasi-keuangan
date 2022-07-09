@extends('layouts.main')
@push('style')

@endpush
@section('content')
    @component('layouts.component.datatable')
        @slot('action', route('siswa.create'))
        @slot('content')
            <th width="5%">No</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Angkatan</th>
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
            url: "{!! url('siswa/get-data') !!}",
            type: "POST",
            dataType: "JSON"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'jurusan.code', name: 'jurusan.code'},
            {data: 'angkatan.code', name: 'angkatan.code'},
            {data: 'Aksi', name: 'Aksi'}

        ]
    });
});

</script>
@endpush
