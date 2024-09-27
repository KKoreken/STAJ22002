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
                <form action="{{route('work.store')}}" method="post" enctype="multipart/form-data">@csrf

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
                                                <span class="mt-2 d-none d-sm-block">Katılımcılar</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#contact" data-bs-toggle="tab" aria-expanded="false" class="nav-link" aria-selected="false" tabindex="-1" role="tab">
                                                <i class="ri-contacts-book-2-line font-size-20"></i>
                                                <span class="mt-2 d-none d-sm-block">Dosyalar</span>
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
                                                    <label for="floatingFirstnameInput">İş Adı</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-7 my-2 col-md-12">
                                                <label for="oncelik">Proje </label>
                                                <select  style="width: 100%" class="js-example-basic-single form-control" name="proje">
                                                    <option value="0"  selected>Proje Seçin (Projeden bağımsız iş için seçili bırakın)</option>
                                                    @foreach($projects as $p)
                                                        <option value="{{$p->id}}">{{$p->baslik}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-7 my-2 col-md-12 ">
                                                <label for="baslangic_tarihi">Başlangıç Tarihi</label>
                                                <input class="form-control" id="baslangic_tarihi" type="date" name="baslangic_tarihi">
                                            </div>
                                            <div class="col-xl-7 my-2 col-md-12 ">
                                                <label for="bitis_tarihi">Bitiş Tarihi</label>
                                                <input class="form-control" id="bitis_tarihi" type="date" name="bitis_tarihi">
                                            </div>
                                                <div class="col-xl-7 my-2 col-md-12">
                                                    <label for="oncelik">Öncelik</label>
                                                    <select name="oncelik" class="form-select" id="oncelik" aria-label="Default select example">
                                                        <option disabled selected="">Öncelik Seçiniz</option>
                                                        <option style='background-color:#264653; color: white ' value="1">1</option>
                                                        <option style='background-color:#2a9d8f ' value="2">2</option>
                                                        <option style='background-color:#e9c46a ' value="3">3</option>
                                                        <option style='background-color:#f4a261 ' value="3">4</option>
                                                        <option style='background-color:#e76f51 ' value="3">5</option>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane active show" id="isler" role="tabpanel">
                                    <div class="my-2">
                                        <h6>Departman Seç</h6>
                                        <select  multiple style="width: 100%" class="js-example-basic-single form-control" name="katilimcilar[departman][]">
                                            @foreach($departmants as $p)
                                                <option value="{{$p->id}}">{{$p->baslik}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="my-2">
                                        <h6>Ekip Seç</h6>
                                        <select  multiple style="width: 100%" class="js-example-basic-single form-control" name="katilimcilar[ekip][]">
                                            @foreach($ekipler as $p)
                                                <option value="{{$p->id}}">{{$p->baslik}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="my-2">
                                        <h6>Kullanıcı Seç</h6>
                                        <select  multiple style="width: 100%" class="js-example-basic-single form-control" name="katilimcilar[kullanici][]">
                                            @foreach($users as $p)
                                                <option value="{{$p->id}}">{{$p->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                </div>

                                <div class="tab-pane" id="contact" role="tabpanel">
                                    <h5 class="font-size-14 mb-2">Dosyalar</h5>

                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Dosya Adı</th>
                                            <th>Dosya Yükleme Alanı</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" name="Dosyaadi" id="Dosyaadi" placeholder="Dosya Adı Giriniz.">
                                                            <label for="Dosyaadi">Dosya Adı</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input class="form-control" name="dosya" type="file">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

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
