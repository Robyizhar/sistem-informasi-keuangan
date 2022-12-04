@extends('layouts.main')
@push('style')

@endpush
@section('content')
    @component('layouts.component.datatable')
        @slot('filter')
        <div class="col-md-12">
            <form action="{{ route('spp.filter') }}" method="post" id="form-filter">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label>Jurusan</label>
                    <select name="jurusan_id" class="form-control jurusan" id="jurusan">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($data['jurusans'] as $jurusan)
                            <option {{ app('request')->input('jurusan') == $jurusan->id ? 'selected' : ''}} value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Angkatan</label>
                    <select name="angkatan_id" class="form-control angkatan" id="angkatan">
                        <option value="">Pilih Angkatan</option>
                        @foreach ($data['angkatans'] as $angkatan)
                            <option {{ app('request')->input('angkatan') == $angkatan->id ? 'selected' : ''}} value="{{ $angkatan->id }}">{{ $angkatan->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success btn-add waves-effect waves-light mb-2">Filter</button>
            </form>
        </div>

        <input type="hidden" value="{{ app('request')->input('angkatan') != "" ? app('request')->input('angkatan') : '' }}" id="angkatan_get">
        <input type="hidden" value="{{ app('request')->input('jurusan') != "" ? app('request')->input('jurusan') : '' }}" id="jurusan_get">
        @endslot
        @slot('action', route('spp.create'))
        @slot('content')
            <th width="5%">No</th>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Jurusan</th>
            <th>Angkatan</th>
            <th>Jumlah Pembayaran</th>
            <th>Sisa Pembayaran</th>
            <th>Aksi</th>
        @endslot
    @endcomponent

@endsection
@push('script')
<script>
$(document).ready( function () {

    $('#form-filter').validate({
        ignore: [],
        errorClass: "text-danger",
        errorElement: 'div',
        validClass: "form-success",
        rules: {
            jurusan_id: { required: true },
            angkatan_id: { required: true },
        },
        messages: {
            jurusan_id: {
                required: "silahkan pilih jurusan"
            },
            angkatan_id: {
                required: "silahkan pilih angkatan"
            },
        },
        errorPlacement: function (error, element) {
            if (element.parent('.inline-form').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        onError: function () {
            $('.input-group.error-class').find('.help-block.text-danger').each(function () {
                $(this).closest('.inline-form').addClass('error-class').append($(this));
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.inline-form').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.inline-form').removeClass("has-error");
        }
    });

    let jurusan = $('#jurusan_get').val();
    let angkatan = $('#angkatan_get').val();
    if (jurusan !== '' && angkatan !== '') {
        let datatable = $('#state-saving-datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            orderable: false,
            method: "POST",
            sPaginationType: "full_numbers",
            ajax: {
                url: "{!! url('spp/get-data') !!}",
                type: "POST",
                dataType: "JSON",
                data: {
                    angkatan: angkatan,
                    jurusan: jurusan
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'nisn', name: 'nisn'},
                {data: 'name', name: 'name'},
                {data: 'jurusan.name', name: 'jurusan.name'},
                {
                    render: function(data, type, row, meta) {
                        return row.angkatan.kelas_label + ' - ' + row.angkatan.name
                    }
                },
                {data: 'angkatan.spp_cost', name: 'angkatan.spp_cost'},
                {data: 'Status', name: 'Status'},
                {data: 'Aksi', name: 'Aksi'}
            ]
        });
    } else {

    }
});

</script>
@endpush
