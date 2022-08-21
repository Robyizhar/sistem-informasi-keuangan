@extends('layouts.main')
@push('style')

@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('pengeluaran_spp_dsp.store') : route('pengeluaran_spp_dsp.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div class="row">

        <div class="col-md-7">
            <div class="form-group mb-3">
                <label class="required">Total Dana Tersedia</label>
                @php $funds_available = $data['income'] - $data['expenditure']; @endphp
                <input style="background-color: #dfdfdf;" value="Rp. {{ number_format($funds_available) }}" readonly type="text" class="form-control mb-2 funds_available_label" placeholder="" />
                <input value="{{ $funds_available }}" readonly type="hidden" class="form-control mb-2 funds_available" placeholder="" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Nama Pengeluaran</label>
                <input type="text" name="name" class="form-control mb-2 name">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Harga Per Pengeluaran</label>
                <input name="unit_price" type="text" class="form-control mb-2 unit_price" onkeypress="return isNumber(event)" placeholder="" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Jumlah Pengeluaran</label>
                <input name="unit_quantity" type="text" class="form-control mb-2 unit_quantity" onkeypress="return isNumber(event)" placeholder="" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="required">Jumlah Total</label>
                <input style="background-color: #dfdfdf;" readonly type="text" class="form-control mb-2 unit_total_price" placeholder="" />
                <input readonly type="hidden" name="unit_total_price_hidden" class="form-control mb-2 unit_total_price_hidden" placeholder="" />
            </div>
        </div>

    </div>

    @endslot
@endcomponent
@endsection
@push('script')
    <script>
        function numberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        const isNumber = (evt) => {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        $('.unit_price').keyup(function (e) {

            let unit_price = $(this).val() || 0;
            let unit_qty = $('.unit_quantity').val() || 0;
            let funds_available = $('.funds_available').val();

            let unit_total_price = parseInt(unit_price) * parseInt(unit_qty)
            $('.unit_total_price').val('Rp. '+numberWithCommas(unit_total_price));
            $('.unit_total_price_hidden').val(unit_total_price);

        });

        $('.unit_quantity').keyup(function (e) {

            let unit_qty = $(this).val() || 0;
            let unit_price = $('.unit_price').val() || 0;
            let funds_available = $('.funds_available').val();

            let unit_total_price = parseInt(unit_price) * parseInt(unit_qty)
            $('.unit_total_price').val('Rp. '+numberWithCommas(unit_total_price));
            $('.unit_total_price_hidden').val(unit_total_price);

        });

        $(document).ready(function () {
            let funds_available = $('.funds_available_label').val()
            $("#form-save-update").validate({
                rules: {
                    name: { required: true },
                    unit_price: {
                        required: true,
                        min: function() {
                            return 1;
                        }
                    },
                    unit_quantity: {
                        required: true,
                        min: function() {
                            return 1;
                        }
                    },
                    unit_total_price_hidden: {
                        required: true,
                        min: function() {
                            return 1;
                        },
                        max: function() {
                            return parseInt($('.funds_available').val());
                        }
                    }
                },
                messages: {
                    name: { required: "masukan nama pengeluaran" },
                    unit_price: {
                        required: "masukan total pembayaran",
                        min: "masukan harga"
                    },
                    unit_quantity: {
                        required: "masukan total pembayaran",
                        min: "masukan jumlah"
                    },
                    unit_total_price_hidden: {
                        required: "masukan total pembayaran",
                        min: "jumlah tidak valid",
                        max: "melebihi maksimal sisa pembayaran " + funds_available
                    }
                },
                ignore: "",
            });

        });

    </script>
@endpush
