@extends('layouts.main')
@push('style')

@endpush
@section('content')
    @component('layouts.component.datatable')
        @slot('action', route('pemasukan_bos.create'))
        @slot('content')
            <th width="5%">No</th>
            <th>Step</th>
            <th>Tipe</th>
            <th>Tahun</th>
            <th>Penerimaan Dana</th>
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
            url: "{!! url('pemasukan_bos/get-data') !!}",
            type: "POST",
            dataType: "JSON"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'step', name: 'step'},
            {data: 'type', name: 'type'},
            {data: 'year', name: 'year'},
            {data: 'received_funds', name: 'received_funds'},
            {data: 'Aksi', name: 'Aksi'}

        ]
    });
});

</script>
@endpush
