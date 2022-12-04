{{-- @isset($status_pensiun)
    <span class="badge badge-pill badge-{{ $status_pensiun == 'Sudah Pensiun' ? 'danger' : 'warning' }}">{{ $status_pensiun }}</span>
@endisset

@isset($status_penilaian)
    <span class="badge badge-pill badge-{{ $status_penilaian == 'Sudah dinilai' ? 'success' : 'danger' }}">{{ $status_penilaian }}</span>
@endisset

@isset($lama_jabatan)
    <span class="badge badge-pill badge-info">{{ $lama_jabatan }}</span>
@endisset

@isset($akhir_kontrak)
    <a href="{{ route('penilaian-nki.create-new', $id) }}" class="badge badge-pill badge-info">{{ $akhir_kontrak }}</a>
@endisset --}}
@isset($arrears)
    <span class="badge badge-pill badge-danger">{{ $arrears }}</span>
@endisset
@isset($paid_off)
    <span class="badge badge-pill badge-success">{{ $paid_off }}</span>
@endisset
