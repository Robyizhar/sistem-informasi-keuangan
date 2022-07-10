@extends('layouts.main')
@push('style')

@endpush
@section('content')
    @component('layouts.component.datatable')
        @slot('action', route('dsp.create'))
        @slot('content')
            <th width="5%">No</th>
            <th>Nama Siswa</th>
            <th>Jumlah Pembayaran</th>
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
            url: "{!! url('dsp/get-data') !!}",
            type: "POST",
            dataType: "JSON"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'siswa.name', name: 'siswa.name'},
            {data: 'total_payment', name: 'total_payment'}, 
            {data: 'Aksi', name: 'Aksi'}

        ]
    });
});

</script>
@endpush
