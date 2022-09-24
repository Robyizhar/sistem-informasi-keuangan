<div class="content-wrapper">
    @include('layouts.component.breadcumb', ['segment' => Request::segment(2) != '' ? ucwords(str_replace("-"," ",Request::segment(2))) : 'Form Input'])
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default" style="padding: 2%;">
                        <div class="card-body p-0">
                            <div class="bs-stepper">
                                @if($isfile == true)
                                <form id="form-save-update" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method($method)
                                    {{ $content }}
                                    <button type="submit" class="btn btn-primary btn-submit waves-effect waves-light">Submit</button>
                                </form>
                                @else
                                <form id="form-save-update" action="{{ $action }}" method="POST">
                                    @csrf
                                    @method($method)
                                    {{ $content }}
                                    <button type="submit" class="btn btn-primary btn-submit waves-effect waves-light">Submit</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
