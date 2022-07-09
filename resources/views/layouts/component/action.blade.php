<div class="text-center">
    @if (isset($url_show))
        <a href="{{ $url_show }}" class="btn-show" title="Detail">

        </a>
    @endif

    @if (isset($url_edit))
        <a href="{{ $url_edit }}" class="btn btn-primary" title="Edit">
            EDIT
        </a>

    @endif
    @if (isset($url_destroy))
        <a href="{{ $url_destroy }}" class="btn btn-danger btn-delete" title="Hapus">
            HAPUS
        </a>

    @endif
</div>
