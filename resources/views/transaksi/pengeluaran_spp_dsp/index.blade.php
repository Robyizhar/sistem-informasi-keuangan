@extends('layouts.main')
@push('style')

@endpush
@section('content')
    @component('layouts.component.datatable')
        @slot('action', route('pengeluaran_spp_dsp.create'))
        @slot('content')
            <th width="5%">No</th>
            <th>Nama Pengeluaran</th>
            <th>Harga Pengeluaran</th>
            <th>Jumlah Pengeluaran</th>
            <th>Total Pengeluaran</th>
            <th width="20%">Aksi</th>
        @endslot
    @endcomponent

@endsection
@push('script')
<script>

function numberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).ready( function () {
    let datatable = $('#state-saving-datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        orderable: false,
        method: "POST",
        sPaginationType: "full_numbers",
        ajax: {
            url: "{!! url('pengeluaran_spp_dsp/get-data') !!}",
            type: "POST",
            dataType: "JSON"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'name', name: 'name'},
            {
                "mRender": function ( data, type, row ) {
                    return numberWithCommas(row.unit_price);
                }
            },
            {
                "mRender": function ( data, type, row ) {
                    return numberWithCommas(row.unit_quantity);
                }
            },
            {
                "mRender": function ( data, type, row ) {
                    return numberWithCommas(row.unit_total_price);
                }
            },
            {data: 'Aksi', name: 'Aksi'}

        ]
    });
});

</script>
@endpush
