@extends('layouts.master-without-navside')
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
        <div class="row p-5">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$form->title}}</h5>
                        <form method="post" action="{{route('send.answers')}}" >
                            @csrf
                            <input type="hidden" name="formid" value="{{$form->id}}">
                            <input type="hidden" name="token" value="{{$token}}">
                            <div class="row">


                                @foreach($form->sorular as $soru)

                                    @if($soru->soru->type=='select')
                                        <div class="col-md-9">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="cevap[{{ $soru->soru->id }}]" @if($soru->soru->required == 'Zorunlu') required @endif id="soru{{ $soru->soru->id }}">
                                                    @php
                                                        $options = json_decode($soru->soru->options, true); // options JSON'u çözüldü
                                                    @endphp


                                                        @foreach($options as $index => $option)
                                                            @if(is_array($option))
                                                                {{-- Eğer $option bir array ise, dizi haline getir --}}
                                                                <option value="{{ implode(',', $option) }}" >{{ implode(',', $option) }}</option>
                                                            @else
                                                                {{-- Eğer $option bir string ise, doğrudan kullan --}}
                                                                <option value="{{ $option }}" >{{ $option }}</option>
                                                            @endif
                                                        @endforeach
                                                </select>
                                            <label for="soru{{ $soru->soru->id }}">{{ $soru->soru->title }}</label>@if($soru->soru->required == 'Zorunlu')<span style="color: red"> *</span>@endif
                                            </div>
                                        </div>

                                   @endif
                                    @if($soru->soru->type=='text')
                                        <div class="col-md-9">
                                            <div class="form-floating mb-3">
                                                <input  name="cevap[{{ $soru->soru->id }}]" type="text" class="form-control" id="soru{{ $soru->soru->id }}">
                                                <label for="soru{{ $soru->soru->id }}">{{ $soru->soru->title }}</label>@if($soru->soru->required == 'Zorunlu')<span style="color: red"> *</span></div>@endif
                                            </div>
                                        </div>
                                    @endif
                                    @if($soru->soru->type=='email')
                                        <div class="col-md-9">
                                            <div class="form-floating mb-3">
                                                <input  name="cevap[{{ $soru->soru->id }}]" type="email" class="form-control" id="soru{{ $soru->soru->id }}">
                                                <label for="soru{{ $soru->soru->id }}">{{ $soru->soru->title }}</label>@if($soru->soru->required == 'Zorunlu')<span style="color: red"> *</span>@endif
                                            </div>
                                        </div>
                                    @endif
                                    @if($soru->soru->type=='checkbox')
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="cevap[{{ $soru->soru->id }}]" id="soru{{ $soru->soru->id }}">
                                                <label for="soru{{ $soru->soru->id }}">{{ $soru->soru->title }}</label>@if($soru->soru->required == 'Zorunlu')<span style="color: red"> *</span>@endif
                                            </div>
                                        </div>
                                    @endif

                            @endforeach



                            <hr>
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Cevapları Gönder</button>
                            </div>
                        </form>
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


