@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-md flex-shrink-0">
                                <span class="avatar-title bg-subtle-primary text-primary rounded fs-2">
                                    <span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em"><path class="uim-quinary" d="M13.5,9A1.5,1.5,0,1,1,15,7.5,1.50164,1.50164,0,0,1,13.5,9Z"></path><path class="uim-tertiary" d="M19,2H5A3.00879,3.00879,0,0,0,2,5v8.86L5.88,9.98a3.07531,3.07531,0,0,1,4.24,0l2.87139,2.887.88752-.88751a3.00846,3.00846,0,0,1,4.24218,0L22,15.8584V5A3.00879,3.00879,0,0,0,19,2ZM13.5,9A1.5,1.5,0,1,1,15,7.5,1.50164,1.50164,0,0,1,13.5,9Z"></path><path class="uim-primary" d="M10.12,9.98a3.07531,3.07531,0,0,0-4.24,0L2,13.86V19a3.00882,3.00882,0,0,0,3,3H19a2.9986,2.9986,0,0,0,2.16-.92Z"></path><path class="uim-quaternary" d="M22,15.8584l-3.87891-3.87891a3.00849,3.00849,0,0,0-4.24218,0l-.88752.88751,8.16425,8.20856A2.96485,2.96485,0,0,0,22,19Z"></path></svg></span>
                                </span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden ms-4">
                                <p class="text-muted text-truncate font-size-15 mb-2"> Toplam Form</p>
                                <h3 class="fs-4 flex-grow-1 mb-3">425,34 </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('kk/public/build/js/app.js') }}"></script>
@endsection
