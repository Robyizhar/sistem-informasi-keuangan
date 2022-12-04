@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Jurusan</label>
                <select name="jurusan_id" class="form-control jurusan" id="jurusan">
                    @if (isset($data['siswa']))
                        <option selected value="{{ $data['siswa']->jurusan->id }}">{{ $data['siswa']->jurusan->name }}</option>
                    @else
                        <option value="">Pilih Jurusan</option>
                        @foreach ($data['jurusans'] as $jurusan) <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option> @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Angkatan</label>
                <select name="angkatan_id" class="form-control angkatan" id="angkatan">
                    @if (isset($data['siswa']))
                        <option selected value="{{ $data['siswa']->angkatan->id }}">{{ $data['siswa']->angkatan->name }}</option>
                    @else
                        <option value="">Pilih Angkatan</option>
                        @foreach ($data['angkatans'] as $angkatan) <option value="{{ $angkatan->id }}">{{ $angkatan->name }}</option> @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Siswa</label>
                <select name="siswa_id" class="form-control siswa" id="siswa">
                    @isset($data['siswa'])
                        <option
                            value="{{ $data['siswa']->id }}"
                            data-name="{{ $data['siswa']->name }}"
                            data-address="{{ $data['siswa']->address }}"
                            data-gender="{{ $data['siswa']->gender }}"
                            data-nisn="{{ $data['siswa']->nisn }}"
                            data-spp="{{ $data['siswa']->angkatan->spp_cost }}"
                            data-rekap_spp="{{ json_encode($data['siswa']->spp) }}" >{{ $data['siswa']->nisn }}, {{ $data['siswa']->name }}
                        </option>
                    @endisset
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Nama Siswa</label>
                <input type="hidden" name="siswa_id" class="siswa_id">
                <input name="name" style="background-color: #dfdfdf;" readonly type="text" class="form-control mb-2 name" placeholder="" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">No Induk Siswa</label>
                <input style="background-color: #dfdfdf;" readonly type="text" class="form-control mb-2 nisn" placeholder="" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Jenis Kelamin</label>
                <input style="background-color: #dfdfdf;" readonly type="text" class="form-control mb-2 gender" placeholder="" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group mb-3">
                <label class="required">Alamat</label>
                <input style="background-color: #dfdfdf;" readonly type="text" class="form-control mb-2 address" placeholder="" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Total SPP Per Bulan</label>
                <input style="background-color: #dfdfdf;" readonly type="text" class="form-control mb-2 spp" placeholder="" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Total Yang harus dibayar</label>
                <input style="background-color: #dfdfdf;" readonly type="text" name="spp_total_cost_paymant" class="form-control mb-2 spp_total_cost_paymant" placeholder="" />
            </div>
        </div>

        <div class="col-md-12">
            <div id="accordion">

            </div>
        </div>
    </div>

    @endslot
@endcomponent
<div style="display: none;">

</div>
@endsection
@push('script')
    <script>

        $('.btn-spp').click(function (e) {
            e.preventDefault();
        });

        const actionUrl = `{{ url('spp/get-siswa') }}`;
        const paymentUrl = `{{ url('spp/get-payment') }}`;

        const isNumber = (evt) => {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        const numberFormater = (params) => {
            let number_value = Number(params).toLocaleString('en', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2,
                currency: 'INR'
            });
            return number_value;
        }

        function numberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function getPayment(data) {

            $('.siswa_id').val(data.siswa_id);
            $('.name').val(data.name);
            $('.address').val(data.address);
            $('.gender').val(data.gender);
            $('.nisn').val(data.nisn);
            let total_spp = parseInt(data.total_spp);
            $('.spp').val('Rp. ' + numberWithCommas(parseInt(total_spp)));
            $('.spp-label').html('Total Sumbangan Pembinaan Pendidikan Rp. ' + total_spp);

            $("#loading").show();

            $.ajax({
                type: "POST",
                url: paymentUrl,
                data: {
                    angkatan_id: 1,
                    siswa_id: data.siswa_id
                },
                success: function(data) {
                    $('#accordion').empty()
                    const payments = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                    let spp_cost = parseInt($('option:selected', '#siswa').data('spp'));
                    payments.forEach(key => {
                        let spp_payment = key.spp_payment;
                        let card = `
                        <div class="card card-payment">
                            <div class="card-header" id="${key.id}">
                                <h5 class="mb-0">
                                    <a class="btn btn-secondary btn-spp" data-toggle="collapse" data-target="#colapse${key.id}" aria-expanded="true" aria-controls="colapse${key.id}">
                                        SPP #${key.code}
                                    </a>
                                </h5>
                            </div>
                            <div id="colapse${key.id}" class="collapse" aria-labelledby="${key.id}" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header" style="background-color: #6C757D; color: #FFF;">Semester Ganjil</div>
                                                <ul class="list-group list-group-flush" id="list-ganjil-${key.id}">

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header" style="background-color: #6C757D; color: #FFF;">Semester Genap</div>
                                                <ul class="list-group list-group-flush" id="list-genap-${key.id}">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        $('#accordion').append(card);
                        spp_payment.forEach(index => {

                            if (index.semester == 'ganjil') {
                                if (parseInt(index.total_payment) > 0) {
                                    $(document).find('#list-ganjil-'+key.id).append(
                                        `<li class="list-group-item">${index.bulan}
                                            <button type="button" class="btn btn-success btn-sm float-right">${numberWithCommas(index.total_payment)}</button>
                                        </li>`
                                    )
                                } else {
                                    $(document).find('#list-ganjil-'+key.id).append(
                                        `<li class="list-group-item">${index.bulan}
                                            <div class="icheck-primary d-inline float-right">
                                                <input disabled class="spp_payment" type="checkbox" data-spp_cost="${spp_cost}" value="${index.id}" name="payment[]" id="${index.id}">
                                                <label for="${index.id}"></label>
                                            </div>
                                        </li>`
                                    )
                                }

                            } else {
                                if (parseInt(index.total_payment) > 0) {
                                    $(document).find('#list-genap-'+key.id).append(
                                        `<li class="list-group-item">${index.bulan}
                                            <button type="button" class="btn btn-success btn-sm float-right">${numberWithCommas(index.total_payment)}</button>
                                        </li>`
                                    )
                                } else {
                                    $(document).find('#list-genap-'+key.id).append(
                                        `<li class="list-group-item">${index.bulan}
                                            <div class="icheck-primary d-inline float-right">
                                                <input disabled class="spp_payment" type="checkbox" data-spp_cost="${spp_cost}" value="${index.id}" name="payment[]" id="${index.id}">
                                                <label for="${index.id}"></label>
                                            </div>
                                        </li>`
                                    )
                                }
                            }

                        })

                    });
                    $("#loading").hide();
                }
            });
        }

        $('#angkatan').change(function (e) {
            e.preventDefault();
            $(".total_payment").prop('readonly', true);
            let angkatan_id = $(this).val();
            let jurusan_id = $('#jurusan').val();

            $("#loading").show();

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: {
                    angkatan_id: angkatan_id,
                    jurusan_id: jurusan_id
                },
                success: function(data) {
                    $("#siswa").empty();
                    $('.rekap-pembayaran').empty();
                    $('.total_pembayaran').html('0');
                    const siswa = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                    $("#siswa").append(`<option value="">Pilih Siswa</option>`);
                    siswa.forEach(index => {
                        let siswa_option = `<option
                            value="${index.id}"
                            data-name="${index.name}"
                            data-address="${index.address}"
                            data-gender="${index.gender}"
                            data-nisn="${index.nisn}"
                            data-spp="${index.angkatan.spp_cost}"
                            data-rekap_spp='${JSON.stringify(index.spp)}'
                            >${index.nipd}, ${index.name}, ${index.jurusan.code}, ${index.angkatan.code}</option>`;
                        $("#siswa").append(siswa_option);
                    });
                    $("#loading").hide();
                    $("#siswa").attr("disabled", false);
                    $("#siswa").css("background-color", "#FFFF").css("cursor", "pointer");
                }
            });

        });

        $('#jurusan').change(function (e) {
            e.preventDefault();
            $(".total_payment").prop('readonly', true);
            let jurusan_id = $(this).val();
            let angkatan_id = $('#angkatan').val();

            $("#loading").show();

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: {
                    angkatan_id: angkatan_id,
                    jurusan_id: jurusan_id
                },
                success: function(data) {
                    $("#siswa").empty();
                    $('.rekap-pembayaran').empty();
                    $('.total_pembayaran').html('0');
                    const siswa = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                    $("#siswa").append(`<option value="">Pilih Siswa</option>`);
                    siswa.forEach(index => {
                        let siswa_option = `<option
                            value="${index.id}"
                            data-name="${index.name}"
                            data-address="${index.address}"
                            data-gender="${index.gender}"
                            data-nisn="${index.nisn}"
                            data-spp="${index.angkatan.spp_cost}"
                            data-rekap_spp='${JSON.stringify(index.spp)}'
                            >${index.nipd}, ${index.name}, ${index.jurusan.code}, ${index.angkatan.code}</option>`;
                        $("#siswa").append(siswa_option);
                    });
                    $("#loading").hide();
                    $("#siswa").attr("disabled", false);
                    $("#siswa").css("background-color", "#FFFF").css("cursor", "pointer");
                }
            });

        });

        $(document).on('change', '#siswa', function (e) {
            e.preventDefault();
            $(".total_payment").prop('readonly', false);
            if ($(this).val() == "")
                return false;

            $('.rekap-pembayaran').empty();
            $('.total_pembayaran').html('0');

            const data = {
                siswa_id: $(this).val(),
                name: $('option:selected', this).data('name'),
                address: $('option:selected', this).data('address'),
                gender: $('option:selected', this).data('gender'),
                nisn: $('option:selected', this).data('nisn'),
                total_spp: parseInt($('option:selected', this).data('spp'))
            }

            getPayment(data)

        });

        $(document).ready(function () {

            $("#form-save-update").validate({
                rules: {
                    name: { required: true },
                    spp_total_cost_paymant: { required: true }
                },
                messages: {
                    name: { required: "pilih siswa" },
                    spp_total_cost_paymant: { required: "masukan pembayaran" }
                },
                ignore: "",
            });

            $("#form-save-update").submit(function( event ) {
                $('.limit_payment').remove();
            });

        });

        $(document).on('change', '.spp_payment', function () {

            let spp_cost = 0;

            let parent = $(this).parent().parent();

            let element_before = parent.prevAll();

            element_before.each(function( index ) {
                $(this).find('input').prop('checked', true);
            });

            let element_after = parent.nextAll();

            element_after.each(function( index ) {
                $(this).find('input').prop('checked', false);
            });

            let all_month_cost = $(document).find('.spp_payment:checkbox:checked');

            all_month_cost.each(function (params) {
                spp_cost = spp_cost + $(this).data("spp_cost")
            });

            if (spp_cost <= 0) {
                $('.spp_total_cost_paymant').val('');
            } else {
                spp_cost = numberWithCommas(spp_cost);
                $('.spp_total_cost_paymant').val(`Rp. ${spp_cost}`);
            }

        });

    </script>

    @isset($data['siswa'])
    <script>

        $(".total_payment").prop('readonly', false);

        $('.rekap-pembayaran').empty();
        $('.total_pembayaran').html('0');

        const data = {
            siswa_id: $('#siswa').val(),
            name: $('option:selected', '#siswa').data('name'),
            address: $('option:selected', '#siswa').data('address'),
            gender: $('option:selected', '#siswa').data('gender'),
            nisn: $('option:selected', '#siswa').data('nisn'),
            total_spp: parseInt($('option:selected', '#siswa').data('spp'))
        }
        console.log(data);

        getPayment(data);

    </script>
    @endisset

@endpush
