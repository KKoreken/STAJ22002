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
                    <form action="{{route('panel-work-update',['id'=>$work->id])}}" enctype="multipart/form-data" method="post">@csrf
                        <input type="hidden" name="project_id" value="{{$work->proje->id}}">
                    <div class="card-body">
                        <div class="d-flex mb-4 justify-content-between" >
                            <h5 class="card-title "> @if($work->proje){{$work->proje->baslik}} / @endif {{$work->baslik}}</h5>
                            <button class="btn px-5 btn-primary">Onayla</button>
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
                                                <span class="mt-2 d-none d-sm-block">İşler</span>
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
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="baslik" id="floatingFirstnameInput" value="{{$work->baslik}}" placeholder="Enter Your First Name">
                                                    <label for="floatingFirstnameInput">İş Adı</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class=" mb-3">
                                                    <label for="proje_id">Proje</label>
                                                    <select   style="width: 100%" class="js-example-basic-single form-control" name="proje_id" id="proje_id">
                                                        @foreach($projects  as $p)
                                                            <option @if($work->proje_id == $p->id) selected @endif  value="{{$p->id}}">{{$p->baslik}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class=" mb-3">
                                                    <label for="oncelik">Öncelik</label>
                                                    <select name="oncelik" class="form-select" id="oncelik" aria-label="Default select example">
                                                        <option @if($work->oncelik == '1') selected @endif style='background-color:#264653; color: white ' value="1">1</option>
                                                        <option @if($work->oncelik == '2') selected @endif style='background-color:#2a9d8f ' value="2">2</option>
                                                        <option @if($work->oncelik == '3') selected @endif style='background-color:#e9c46a ' value="3">3</option>
                                                        <option @if($work->oncelik == '4') selected @endif style='background-color:#f4a261 ' value="3">4</option>
                                                        <option @if($work->oncelik == '5') selected @endif style='background-color:#e76f51 ' value="3">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class=" mb-3">
                                                    <label for="durum">Öncelik</label>
                                                    <select name="durum" class="form-select" id="durum" aria-label="Default select example">
                                                        <option @if($work->durum == '0') selected @endif value="0">Pasif</option>
                                                        <option @if($work->durum == '1') selected @endif value="1">Aktif</option>
                                                        <option @if($work->durum == '2') selected @endif value="2">Tamamlandı</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane active show" id="isler" role="tabpanel">
                                    <h5 class="font-size-14 mb-2">İşler</h5>
                                    <div class="card-body">
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Kullanıcı Adı</th>
                                                <th>Başlangıç Tarihi</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-floating mb-3">
                                                                <select   style="width: 100%" class="js-example-basic-single form-control" name="katilimci">
                                                                    <option selected disabled> Kullanıcı Seç</option>
                                                                    @foreach($users as $user)
                                                                        <option  value="{{$user->id}}">{{$user->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <p class="text-center" >Tarih Otomatik Atanır</p>
                                                </td>
                                                <td>
                                                </td>

                                            </tr>

                                            @foreach($work->isSahipligi as $is)
                                                <tr>
                                                    <td>{{$is->user->name}}</td>
                                                    <td>01.01.2020</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <button type="button" class="btn btn-primary waves-effect waves-light">
                                                                    İşlemler <i class="mdi mdi-dots-vertical"></i>
                                                                </button>
                                                            </a>

                                                            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-40px, 30px, 0px);" data-popper-placement="bottom-end">
                                                                <a class="dropdown-item" href="{{route('panel-user-details',['id'=>$is->user->id])}}">İncele</a>
                                                                <a class="dropdown-item" href="{{route('panel-user-edit',['id'=>$is->user->id])}}">Düzenle</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#">İşten Al</a>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <div class="tab-pane" id="contact" role="tabpanel">
                                    <h5 class="font-size-14 mb-2">Dosyalar</h5>

                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Dosya Adı</th>
                                            <th>Ekleyen Kullanıcı</th>
                                            <th>Eklenme Tarihi</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="Dosyaadi" name="dosyaAdi" placeholder="Dosya Adı Giriniz.">
                                                            <label for="Dosyaadi">Dosya Adı</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <input name="dosya" class="form-control" type="file">
                                            </td>
                                            <td> </td>
                                            <td></td>
                                        </tr>
                                        @foreach($work->dosya as $dosya)
                                            <tr>
                                                <td><a href="{{url('storage/app/'.$dosya->path)}}"><i class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>
                                                        {{$dosya->name}}</a></td>
                                                <td>{{$dosya->user->name}}</td>
                                                <td>{{$dosya->created_at}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <button type="button" class="btn btn-primary waves-effect waves-light">
                                                                İşlemler <i class="mdi mdi-dots-vertical"></i>
                                                            </button>
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-40px, 30px, 0px);" data-popper-placement="bottom-end">
                                                            <a class="dropdown-item" href="#">Sil</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
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
        <script src="{{ URL::asset('public/build/js/app.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
@endsection
