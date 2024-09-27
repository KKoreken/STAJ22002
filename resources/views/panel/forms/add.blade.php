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
                <form action="{{route('form.store')}}" method="post" enctype="multipart/form-data">@csrf

                    <div class="card">
                            <div class="mt card-body">
                                <div class="d-flex mb-4 justify-content-between">
                                    <h5 class="card-title">Yeni İş Ekle</h5>
                                    <button class="btn px-5 btn-primary" id="submitForm">Onayla</button>
                                </div>

                                    <div class="chat-leftsidebar me-4">
                            <div class="card mb-0">
                                <div class="chat-leftsidebar-nav">
                                    <ul class="nav nav-pills nav-justified bg-light-subtle" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a href="#genelbilgi" data-bs-toggle="tab" aria-expanded="true" class="nav-link" aria-selected="false" role="tab" tabindex="-1">
                                                <i class="ri-message-2-line font-size-20"></i>
                                                <span class="mt-2 d-none d-sm-block">Genel Bilgiler</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#isler" data-bs-toggle="tab" aria-expanded="false" class="nav-link active" aria-selected="true" role="tab">
                                                <i class="ri-group-line font-size-20"></i>
                                                <span class="mt-2 d-none d-sm-block">Sorular</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                             <div class="tab-content pt-4">
                                <div class="tab-pane" id="genelbilgi" role="tabpanel">
                                    <div>
                                        <h5 class="font-size-14 mb-3">Genel Bilgiler</h5>
                                        <div class="row">
                                            <div class="col-xl-7 my-2 col-md-12 ">
                                                <div class="form-floating mb-3">
                                                    <input required type="text" class="form-control" name="baslik" id="floatingFirstnameInput" placeholder="Enter Your First Name">
                                                    <label for="floatingFirstnameInput">Form Adı</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane active show" id="isler" role="tabpanel">
                                    <div class="my-2">
                                        <h6>Soru Seç</h6>
                                        <select  multiple style="width: 100%" class="js-example-basic-single form-control" name="soru[]">
                                            @foreach($sorular as $soru)
                                                <option value="{{$soru->id}}">{{$soru->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                            </div>

                    <!-- end card body -->
                </div>
                </form>

                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    @endsection
    @section('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- App js -->
        <script >
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>



        <script src="{{ URL::asset('public/build/js/app.js') }}"></script>
@endsection
