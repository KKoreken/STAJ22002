@extends('layouts.master-without-nav')
@section('title')
    Login
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
                                    <a href="{{route('index')}}" class="">
                                        <h3>Anasayfa</h3>
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
                                                        <h4 class="font-size-18">Hoşgeldin !</h4>
                                                    </div>

                                                    <form method="POST" action="{{ route('login') }}" class="auth-input">
                                                        @csrf
                                                        <div class="mb-2">
                                                            <label for="email" class="form-label">Eposta Adresi</label>
                                                            <input id="email" type="email"
                                                                   class="form-control @error('email') is-invalid @enderror"
                                                                   name="email"  required
                                                                   autocomplete="email" autofocus>
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label" for="password-input">Şifre</label>
                                                            <input type="password"
                                                                   class="form-control @error('password') is-invalid @enderror"
                                                                   placeholder="Enter password" id="password-input"
                                                                   name="password" required autocomplete="current-password">
                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-check d-flex justify-content-between">
                                                            <div>
                                                                <input class="form-check-input" type="checkbox"
                                                                       name="remember" id="remember"
                                                                    {{ old('remember') ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="remember">Oturumumu Açık Tut</label>
                                                            </div>
                                                            <a href="{{ url('forgot-password') }}" class="text-end">Şifreni Mi Unuttun?</a>
                                                        </div>

                                                        <div class="mt-4">
                                                            <button class="btn btn-primary w-100" type="submit">Giriş Yap</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <p class="mb-0">Hesabın Yok mu ? <a
                                                            href="{{ route('register') }}" class="fw-medium text-primary">
                                                            Kayıt OL! </a> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
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
    <script src="{{ URL::asset('public/build/js/app.js') }}"></script>
@endsection
