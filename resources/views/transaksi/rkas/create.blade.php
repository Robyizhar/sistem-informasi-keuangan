@extends('layouts.main')
@push('style')
<style>


</style>
@endpush
@section('content')
@component('layouts.component.form')
    @slot('isfile', false)
    @slot('action', !isset($data['detail']) ? route('rkas.store') : route('rkas.update'))
    @isset ($data['detail'])
        @slot('method','PUT')
    @else
        @slot('method','POST')
    @endisset
    @slot('content')
    <div id="form-rkas">

    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 form-group mb-3">
            <button type="button" class="btn btn-secondary create-rkas btn-submit waves-effect waves-light float-right">Tambah RKAS</button>
        </div>
    </div>
    @endslot
@endcomponent
<div style="display: none;">
    <div class="template-rkas-selected-list" childidx="0">
        <div class="row">
            <div class="col-md-12">
                <hr style="border-top: 3px solid lightgrey;">
                <p>Input RKAS </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label>Pemasukan Bos</label>
                    <select class="form-control pemasukan_bos">
                        <option value="">Pilih Pemasukan Bos</option>
                        @foreach ($data['pemasukan_bos'] as $pemasukan_bos)
                            <option data-funds="{{ $pemasukan_bos->received_funds }}" value="{{ $pemasukan_bos->id }}">Tahun {{ $pemasukan_bos->year}} Tahap {{ $pemasukan_bos->step}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="rkas[0][pemasukan_bos]">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-info create-gol btn-sm float-right" data-bos="" style="margin-top: 30px;">
                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah Gol
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
@push('script')

    <script>

        const PEMASUKAN_BOS = `{!! $data['pemasukan_bos'] !!}`;
        const GOLONGAN_RKAS = `{!! $data['golongan_rkas'] !!}`;
        // console.log(JSON.parse(GOLONGAN_RKAS));

        // JSON.parse(GOLONGAN_RKAS).map(function (index) {
        //     console.log(index);
        // })

        $(".create-rkas").click(function (e) {

            e.preventDefault();

            if (jQuery.parseJSON(PEMASUKAN_BOS).length > $(".rkas-selected-list").length) {
                var tr_clone = $(".template-rkas-selected-list").clone();
                tr_clone.removeClass('template-rkas-selected-list');
                tr_clone.addClass('rkas-selected-list');
                $("#form-rkas").append(tr_clone);
                resetDataRKAS();
            } else {
                Swal.fire({
                    text: `Jangan lebih dari ${jQuery.parseJSON(PEMASUKAN_BOS).length} dong !`,
                    target: '.wrapper',
                    customClass: {
                        container: 'position-fixed'
                    },
                    toast: true,
                    position: 'top-right'
                })
            }

        });

        $(document).on('click', '.create-gol', function () {

            let parent = $(this).closest(".rkas-selected-list");
            let index = parent.attr("childidx");
            let id = $(this).attr("data-bos");

            const gol = JSON.parse(GOLONGAN_RKAS);

            let current_count = $('.golongan_rkas').length;

            if (id == '' || id == undefined) {
                Swal.fire({
                    text: `Pilih dana nya dulu !`,
                    target: '.wrapper',
                    customClass: {
                        container: 'position-fixed'
                    },
                    toast: true,
                    position: 'top-right'
                });
            } else {
                if (current_count >= gol.length) {
                    Swal.fire({
                        text: `Jumlah max gol ${gol.length} !`,
                        target: '.wrapper',
                        customClass: {
                            container: 'position-fixed'
                        },
                        toast: true,
                        position: 'top-right'
                    });
                } else {
                    addGolongan(parent, index);
                }
            }

        });

        $(document).on('click', '.create-sub', function () {

            let parent = $(this).closest(".golongan-rkas-row");
            let index = parent.attr("childidx");
            let id = $(this).attr("data-gol");

            const sub_golongan = JSON.parse(GOLONGAN_RKAS).find(function (index) {
                return parseInt(index.id) === parseInt(id);
            });

            let current_count = $('.sub_golongan_rkas').length;

            // console.log(`current : ${current_count}, gol : ${sub_golongan.sub_golongan.length}`);

            if (id == '' || id == undefined) {
                Swal.fire({
                    text: `Pilih golongannya dulu !`,
                    target: '.wrapper',
                    customClass: {
                        container: 'position-fixed'
                    },
                    toast: true,
                    position: 'top-right'
                });
            } else {
                if (current_count >= sub_golongan.sub_golongan.length) {
                    Swal.fire({
                        text: `Jumlah max sub untuk gol ini ${sub_golongan.sub_golongan.length} !`,
                        target: '.wrapper',
                        customClass: {
                            container: 'position-fixed'
                        },
                        toast: true,
                        position: 'top-right'
                    });
                } else {
                    addSubGolongan(parent, index, id)
                }
            }

        });

        $(document).on('change', '.pemasukan_bos', function () {

            let current = [];
            let parent = $(this).closest(".rkas-selected-list");
            let id = $(this).val();
            let childidx = parent.attr("childidx");
            $(".rkas-selected-list").each(function () {
                let row = $(this).find('.pemasukan_bos');
                if (childidx != $(this).attr("childidx")) {
                    current.push(row.val());
                }
            });

            if (current.includes(id)) {
                Swal.fire({
                    text: `Tadi kan udah milih yang ini, gimana sih !`,
                    target: '.wrapper',
                    customClass: {
                        container: 'position-fixed'
                    },
                    toast: true,
                    position: 'top-right'
                });
                $('option:selected', this).remove();
            } else {
                $(this).attr('disabled',true)
                // $(`.pemasukan_bos-${childidx}`).val(id)
                $(this).next().val(id);
                parent.find('.create-gol').attr("data-bos", id);

            }

        });

        $(document).on('change', '.golongan_rkas', function (e) {
            e.stopImmediatePropagation();
            let parent = $(this).closest(".rkas-selected-list");
            let id = $(this).val();

            parent.find('.create-sub').attr("data-gol", id);
            $(this).attr('readonly',true)

        });

        function resetDataRKAS() {
            let index = 0;
            $(".rkas-selected-list").each(function () {
                var another = this;
                search_index = $(this).attr("childidx");
                console.log(search_index);
                $(this).find('input,select').each(function () {
                    this.name = this.name.replace('[' + search_index + ']', '[' + index + ']');
                    $(another).attr("childidx", index);
                });
                index++;
            });
        }

        function addGolongan(parent, index) {
            let option = '';
            $.map(JSON.parse(GOLONGAN_RKAS), function (value, key) {
                option += `<option value="${value.id}">${value.name}</option>`;
            });
            parent.append(
                `<div class="row golongan-rkas-row" childidx="${index}">
                    <div class="col-md-10 pl-5">
                        <div class="form-group">
                            <label>Golongan RKAS</label>
                            <select class="form-control golongan_rkas">
                                <option value="">Pilih Golongan</option>
                                ${option}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-light create-sub btn-sm float-right" data-gol="" style="margin-top: 30px;">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Sub
                        </button>
                    </div>
                </div>`
            );
        }

        function addSubGolongan(parent, index, id) {

            let option = '';
            $.map(JSON.parse(GOLONGAN_RKAS), function (value, key) {
                if (value.id == id) {
                    value.sub_golongan.forEach(element => {
                        option += `<option class="sub_golongan_rkas_option" value="${element.id}">${element.name}</option>`;
                    });
                }
            });

            parent.append(
                `<div class="col-md-10" style="padding-left: 90px;">
                    <div class="form-group sub_golongan_rkas_id">
                        <label>Sub Golongan RKAS</label>
                        <select name="rkas[${index}][golongan_rkas][${id}][]" class="form-control sub_golongan_rkas">
                            <option value="">Pilih Golongan</option>
                            ${option}
                        </select>
                    </div>
                </div>`
            );
        }

    </script>
@endpush


