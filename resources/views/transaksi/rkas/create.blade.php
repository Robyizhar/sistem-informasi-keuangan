@extends('layouts.main')
@push('style')
<style>

    .rkas-format-text-8 {
        font-size: 0.8rem;
        margin: 0;
    }

    .error-message {
        font-size: 0.7rem;
        margin: 0;
        display: none;
        color: rgb(252, 48, 48);
    }

</style>
@endpush
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="form-rkas">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="2" class="text-center rkas-format-text-8 align-middle">Uraian</th>
                                        <th scope="col" rowspan="2" class="text-center rkas-format-text-8 align-middle">Vol</th>
                                        <th scope="col" rowspan="2" class="text-center rkas-format-text-8 align-middle">Unit</th>
                                        <th scope="col" rowspan="2" class="text-center rkas-format-text-8 align-middle">Harga</th>
                                        <th scope="col" rowspan="2" class="text-center rkas-format-text-8 align-middle">Jumlah</th>
                                        <th scope="col" colspan="3" class="text-center rkas-format-text-8 align-middle">Sumber Dana</th>
                                        <th scope="col" rowspan="2" class="text-center rkas-format-text-8 align-middle">Sisa Alokasi</th>
                                    </tr>
                                    <tr>
                                        @foreach ($data->pemasukan_detail as $pemasukan_detail)
                                            <td class="text-center rkas-format-text-8">
                                                <p class="rkas-format-text-8">{{ $pemasukan_detail->name }}</p>
                                                <span style="font-size: 0.8rem;">( {{ number_format($pemasukan_detail->received_funds, 2) }} )</span>
                                            </td>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->golongan_rkas as $golongan)
                                        <tr>
                                            <th class="text-center align-middle rkas-format-text-8" style="background-color: #d6d6d6;" colspan="{{ count($data->pemasukan_detail) + 6 }}" >{{ $golongan->name }}</th>
                                        </tr>
                                        @foreach ($golongan->sub_golongan as $sub_golongan)
                                        <tr>
                                            @php

                                                $sum_amount_total = 0;
                                                $amount_total = 0;
                                                $unit = 1;
                                                $unit_price = 0;

                                                if (count($sub_golongan->rkas) > 0){
                                                    $sum_amount_total = array_sum(array_column($sub_golongan->rkas->toArray(), 'amount_total'));
                                                    $unit = $sub_golongan->rkas[0]->unit;
                                                    $unit_price = $sub_golongan->rkas[0]->unit_price;

                                                    foreach ($sub_golongan->rkas as $rkas) {
                                                        $amount_total += $rkas->unit * $rkas->unit_price;
                                                    }

                                                }

                                            @endphp
                                            <td class="rkas-format-text-8 align-middle">{{ $loop->iteration }} - {{ $sub_golongan->name }}</td>
                                            <td class="rkas-format-text-8 align-middle"> {{ $sub_golongan->volume }} </td>
                                            <td class="rkas-format-text-8 align-middle"> <input class="unit" value="{{ $unit }}" type="number" min="1" id=""> </td>
                                            <td class="rkas-format-text-8 align-middle"> <input class="withseparator unit_price" value="{{ number_format($unit_price, 2) }}" type="text" id=""> </td>
                                            <td class="rkas-format-text-8 align-middle"> <input class="amount_total" value="{{ number_format($amount_total, 2) }}" readonly style="background-color: #d7d7d7;" type="text" id=""> </td>
                                            @foreach ($data->pemasukan_detail as $pemasukan_detail)
                                            <td class="rkas-format-text-8 text-center align-middle">
                                                @if (count($sub_golongan->rkas) > 0)
                                                    @php
                                                        $rkas_detail = null;
                                                        $pemasukan_bos_detail_id_list = array_column($sub_golongan->rkas->toArray(), 'pemasukan_bos_detail_id');
                                                        $pemasukan_bos_detail_id_index = array_search($pemasukan_detail->id, $pemasukan_bos_detail_id_list);
                                                        $rkas_detail = $sub_golongan->rkas[$pemasukan_bos_detail_id_index]
                                                    @endphp
                                                    <input data-received_funds="{{ $pemasukan_detail->received_funds }}" index="{{ $pemasukan_bos_detail_id_index }}" value="{{ $pemasukan_bos_detail_id_index === 0 || $pemasukan_bos_detail_id_index === 1 || $pemasukan_bos_detail_id_index === 2 ? number_format($rkas_detail->amount_total, 2) : '' }}" class="rkas rkas-{{$loop->iteration}} withseparator" type="text">
                                                @else
                                                    <input data-received_funds="{{ $pemasukan_detail->received_funds }}" class="rkas rkas-{{$loop->iteration}} withseparator" type="text">
                                                @endif

                                                <input type="hidden" class="pemasukan_detail_id" value="{{ $pemasukan_detail->id }}">
                                                <input type="hidden" class="golongan_rkas_id" value="{{ $golongan->id }}">
                                                <input type="hidden" class="golongan_rkas_name" value="{{ $golongan->name }}">
                                                <input type="hidden" class="sub_golongan_rkas_id" value="{{ $sub_golongan->id }}">
                                                <input type="hidden" class="sub_golongan_rkas_name" value="{{ $sub_golongan->name }}">
                                                <input type="hidden" class="description" value="description">
                                                <input type="hidden" class="volume" value="{{ $sub_golongan->volume }}">
                                                <p class="error-message"></p>
                                            </td>
                                            @endforeach
                                            <td class="rkas-format-text-8 align-middle alocation"> </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <button type="button" class="btn btn-secondary create-rkas btn-submit waves-effect waves-light float-right">Tambah RKAS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/rkas.js') }}"></script>
@endpush
