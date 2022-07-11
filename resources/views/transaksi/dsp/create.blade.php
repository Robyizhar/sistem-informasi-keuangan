@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('dsp.store') : route('dsp.update'))
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
                    <option value="">Pilih Jurusan</option>
                    @foreach ($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Angkatan</label>
                <select name="angkatan_id" class="form-control angkatan" id="angkatan">
                    <option value="">Pilih Angkatan</option>
                    @foreach ($angkatans as $angkatan)
                        <option value="{{ $angkatan->id }}">{{ $angkatan->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Siswa</label>
                <select name="siswa_id" class="form-control siswa" id="siswa">
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
                <label class="required">Jumlah Total DSP</label>
                <input style="background-color: #dfdfdf;" readonly type="text" class="form-control mb-2 dsp" placeholder="" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Jumlah Sisa DSP</label>
                <input style="background-color: #dfdfdf;" readonly type="text" class="form-control mb-2 sisa_dsp" placeholder="" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title dsp-label">Custom Elements</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Pembayaran Ke</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jumlah Pembarayan</th>
                            </tr>
                        </thead>
                        <tbody class="rekap-pembayaran">
                            
                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="3"><strong>Total Pembarayan</strong></td>
                                <td><strong>Rp. <strong class="total_pembayaran"></strong></strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Sisa Pembarayan</strong></td>
                                <td><strong>Rp. <strong class="sisa_pembayaran"></strong></strong></td>
                                <input type="hidden" id="sisa_pembayaran">
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Masukan Jumlah Pembayaran</label>
                <input name="total_payment" readonly type="text" onkeypress="return isNumber(event)" class="form-control mb-2 total_payment" placeholder="total_payment" />
            </div>
        </div>

    </div>

    @endslot
@endcomponent
@endsection
@push('script')
    <script>

        const actionUrl = `{{ url('dsp/get-siswa') }}`;

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
                    $('.sisa_pembayaran').html('0');
                    const siswa = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                    $("#siswa").append(`<option value="">Pilih Siswa</option>`);
                    siswa.forEach(index => {
                        let siswa_option = `<option 
                            value="${index.id}"
                            data-name="${index.name}"
                            data-address="${index.address}"
                            data-gender="${index.gender}"
                            data-nisn="${index.nisn}"
                            data-dsp="${index.angkatan.dsp_cost}"
                            data-rekap_dsp='${JSON.stringify(index.dsp)}'
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
                    $('.sisa_pembayaran').html('0');
                    const siswa = (typeof data == "string") ? jQuery.parseJSON(data) : data;
                    $("#siswa").append(`<option value="">Pilih Siswa</option>`);
                    siswa.forEach(index => {
                        let siswa_option = `<option 
                            value="${index.id}"
                            data-name="${index.name}"
                            data-address="${index.address}"
                            data-gender="${index.gender}"
                            data-nisn="${index.nisn}"
                            data-dsp="${index.angkatan.dsp_cost}"
                            data-rekap_dsp='${JSON.stringify(index.dsp)}'
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
            $('.sisa_pembayaran').html('0');

            $('.siswa_id').val($(this).val());
            $('.name').val($('option:selected', this).data('name'));
            $('.address').val($('option:selected', this).data('address'));
            $('.gender').val($('option:selected', this).data('gender'));
            $('.nisn').val($('option:selected', this).data('nisn'));
            let total_dsp = parseInt($('option:selected', this).data('dsp'));
            $('.dsp').val('Rp. ' + numberWithCommas(parseInt($('option:selected', this).data('dsp'))));
            $('.dsp-label').html('Total Dana Sumbangan Pendidikan Rp. ' + total_dsp);
            let rekap_dsp = $('option:selected', this).data('rekap_dsp');
            rekap_dsp = (typeof rekap_dsp == 'string') ? JSON.parse(rekap_dsp) : rekap_dsp;
            let total_pembayaran = 0;
            if (rekap_dsp.length > 0) {
                let number = 1;
                rekap_dsp.forEach(index => {
                    let row_dsp = `<tr>
                        <th>${number}</th>
                        <td>${number}</td>
                        <td>${index.created_at}</td>
                        <td>Rp. ${numberWithCommas(parseInt(index.total_payment))}</td>
                    </tr>`;
                    $('.rekap-pembayaran').append(row_dsp);
                    total_pembayaran = total_pembayaran+parseInt(index.total_payment);
                    number++;
                });

            }
            $('.total_pembayaran').html(numberWithCommas(total_pembayaran))
            let sisa_pembayaran = parseInt(total_dsp) - parseInt(total_pembayaran)
            $('.sisa_pembayaran').html(numberWithCommas(sisa_pembayaran))
            $('#sisa_pembayaran').val(sisa_pembayaran)
        });

        $('.total_payment').keyup(function (e) { 
            e.preventDefault();
            $('.limit_payment').remove();
            let limit_payment = $('#sisa_pembayaran').val()
            let this_val = $(this).val();
            if (parseInt(this_val) > parseInt(limit_payment)) {
                $(this).parent().append(`<span style="color: #ff4040; font-size: 0.9rem;" class='limit_payment'>Maksimal Pembayaran ${numberWithCommas(limit_payment)}</span>`);
                return false;
            } else {
                $('.limit_payment').remove();
            }
        });

        function numberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).ready(function () {
            let limit_payment = $('#sisa_pembayaran').val()
            $("#form-save-update").validate({
                rules: {
                    name: { required: true },
                    total_payment: { 
                        required: true, 
                        max: function() {
                            return parseInt($('#sisa_pembayaran').val());
                        },
                        min: function() {
                            return 1;
                        }
                    }
                },
                messages: {
                    name: { required: "pilih siswa" },
                    total_payment: { 
                        required: "masukan total pembayaran", 
                        max: "melebihi maksimal sisa pembayaran " + limit_payment,
                        min: "pembayaran tidak valid "
                    },
                }, 
                ignore: "", 
            });

            $("#form-save-update").submit(function( event ) {
                $('.limit_payment').remove();
            });
        });
    </script>
@endpush 