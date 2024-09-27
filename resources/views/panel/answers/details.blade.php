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
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="chat-leftsidebar me-4">
                            <div class="card mb-0">
                                <div class="chat-leftsidebar-nav">
                                    <ul class="nav nav-pills nav-justified bg-light-subtle" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a href="#takvim" data-bs-toggle="tab" aria-expanded="true" class="nav-link active" aria-selected="true" role="tab" tabindex="-1">
                                                <i class="ri-group-line font-size-20"></i>
                                                <span class="mt-2 d-none d-sm-block">Cevaplar</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content pt-4">
                                <div class="tab-pane active" id="takvim" role="tabpanel">
                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Soru Adı</th>
                                            <th>Cevap</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $work)
                                            <tr>
                                                <td>{{$work->soru->title}}</td>
                                                <td>{{$work->cevap}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    @endsection
    @section('scripts')
        <!-- App js -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ URL::asset('staj/public/build/js/app.js') }}"></script>
        <script src="{{ URL::asset('staj/public/build/libs/fullcalendar/index.global.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>

@endsection
