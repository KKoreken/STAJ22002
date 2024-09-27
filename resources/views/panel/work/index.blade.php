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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('work.add')}}"><button  class="btn btn-success" id="btn-save-event">Yeni Ekle</button></a>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>İş Adı</th>
                                <th>Proje Adı</th>
                                <th>Başlangıç Tarihi</th>
                                <th>Bitiş Tarihi</th>
                                <th>Katılımcı</th>
                                <th>Öncelik</th>
                                <th>Durumu</th>
                                <th>İşlem</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($works as $work)
                                <tr>
                                    <td>{{$work->baslik}}</td>
                                    <td>{{$work->proje->baslik}}</td>
                                    <td>{{$work->baslangic_tarihi}}</td>
                                    <td>{{$work->bitis_tarihi}}</td>
                                    <td>
                                        <div class="avatar-group">
                                            @php $i=0; @endphp
                                                @foreach($work->users as $user)
                                                    @while($i<2)
                                                        <div class="avatar-group-item">
                                                            <a href="{{route('panel-user-details',['id'=>$user->id])}}" class="d-inline-block">
                                                                <img  data-bs-toggle="tooltip" data-bs-placement="top" title="{{$user->name}}" src="{{url('public/build/images/users/avatar-1.png')}}" alt="" class="rounded-circle avatar-xs">
                                                            </a>
                                                        </div>
                                                        @php $i+=1; @endphp
                                                    @endwhile
                                                @endforeach
                                            @if($work->user_count>0)
                                                <div class="avatar-group-item">
                                                    <a href="#" class="d-inline-block">
                                                        <div class="avatar-xs">

                                                            <span class="avatar-title rounded-circle bg-danger text-white font-size-16">
                                                                +{{$work->user_count}}
                                                            </span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif

                                        </div>
                                    </td>
                                    <td><div style="background-color:#2a9d8f; color: white;" class="w-75  text-center fa-1x py-1" >{{$work->oncelik}}</div></td>
                                    <td>
                                        @switch($work->durum)
                                            @case('0')
                                                <span class="badge badge-soft-danger font-size-12">Pasif</span>
                                                @break
                                            @case('1')
                                                <span class="badge badge-soft-info font-size-12">Devam Ediyor</span>
                                                @break
                                            @case('2')
                                                <span class="badge badge-soft-success font-size-12">Tamamlandı</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <button type="button" class="btn btn-primary waves-effect waves-light">
                                                    İşlemler <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-40px, 30px, 0px);" data-popper-placement="bottom-end">
                                                <a class="dropdown-item" href="{{route('panel-work-details',['id'=>$work->id])}}">İncele</a>
                                                <a class="dropdown-item" href="{{route('panel-work-edit',['id'=>$work->id])}}">Düzenle</a>
                                                <div class="dropdown-divider"></div>
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
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endsection
    @section('scripts')
        <!-- App js -->
        <link href="{{ url('public/build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/build/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{ url('public/build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ url('public/build/js/app.js') }}"></script>
        <script src="{{ url('public/build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ url('public/build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ url('public/build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ url('public/build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ url('public/build/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ url('public/build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ url('public/build/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ url('public/build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ url('public/build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ url('public/build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

        <script src="{{ url('public/build/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ url('public/build/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="{{ url('public/build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ url('public/build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ url('public/build/js/pages/datatables.init.js') }}"></script>
    @include('includes.js.toastr')
@endsection
