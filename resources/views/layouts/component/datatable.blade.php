<div class="content-wrapper">
    @include('layouts.component.breadcumb')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @isset($filter)
                    {{ $filter }}
                @endisset
                <div class="col-12">
                    <div class="card" style="padding: 2%;">
                        <div class="card-header">
                            <h3 class="card-title">List</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    @isset($action )
                                        <a href="{{ $action }}" class="btn btn-success btn-add waves-effect waves-light float-right mb-2">Add</a>
                                    @endisset
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table" id="state-saving-datatable">
                                <thead>
                                    <tr>
                                        {{ $content }}
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('script-datatable')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endpush
