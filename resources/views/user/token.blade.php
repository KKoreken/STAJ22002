@extends('layouts.master-without-nav')
@section('title')
    Anket Eposta Onay
@endsection
@section('content')
    <div class="auth-maintenance d-flex align-items-center min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100 py-0 py-xl-3">
                                <div class="text-center mb-4">
                                    <a href="index" class="">
                                        <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="22"
                                             class="auth-logo logo-dark mx-auto">
                                        <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="22"
                                             class="auth-logo logo-light mx-auto">
                                    </a>
                                </div>

                                <div class="card my-auto overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="bg-overlay bg-primary"></div>
                                            <div class="h-100 bg-auth align-items-end">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4">
                                                <div>
                                                    <div class="text-center mt-1">
                                                        <h4 class="font-size-18">Eposta Giriniz</h4>
                                                        <p class="text-muted">Ankete Girmek İçin Epostanızı Onaylayınız</p>
                                                    </div>

                                                    <div class="alert alert-success mt-4 pt-2" role="alert">
                                                        Epostanıza ankete girebileceğiniz bir link gönderilecektir
                                                    </div>

                                                    <form action="{{route('anket-token-create')}}" method="post" class="auth-input"> @csrf
                                                        <div class="mb-2">
                                                            <label for="useremail" class="form-label">Email</label>
                                                            <input type="email" class="form-control"  name="email" id="email">
                                                            <input type="hidden" name="formid" value="{{$id}}">
                                                        </div>

                                                        <div class="mt-4">
                                                            <button class="btn btn-primary w-100"
                                                                    type="submit">Gönder</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
@endsection
@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
