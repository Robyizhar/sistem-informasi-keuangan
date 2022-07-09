@extends('layouts.main')
@push('style')

@endpush
@section('content')
    @component('layouts.component.datatable')
        @slot('action', route('angkatan.create'))
        @slot('content')
            <th width="5%">No</th>
            <th>Nama Angkatan</th>
            <th>Tahun Masuk</th>
            <th>Biaya Spp / Bulan</th>
            <th>Biaya DSP</th>
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
            url: "{!! url('angkatan/get-data') !!}",
            type: "POST",
            dataType: "JSON"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'entry_year', name: 'entry_year'},
            {data: 'SPP', name: 'SPP'},
            {data: 'DSP', name: 'DSP'},
            {data: 'Aksi', name: 'Aksi'}

        ]
    });
});

</script>
@endpush
