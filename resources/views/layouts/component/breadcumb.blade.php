<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ ucwords(str_replace("-"," ",Request::segment(1))) }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    @isset($segment)
                        <li class="breadcrumb-item"><a href="{{ url('/'.Request::segment(1)) }}">{{ ucwords(str_replace("-"," ",Request::segment(1))) }}</a></li>
                        <li class="breadcrumb-item active">{{ $segment }}</li>
                    @else
                        <li class="breadcrumb-item active">{{ ucwords(str_replace("-"," ",Request::segment(1))) }}</li>
                    @endisset
                </ol>
            </div>
        </div>
    </div>
</section>
@include('layouts.component.session')
