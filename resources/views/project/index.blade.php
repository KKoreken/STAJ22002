
@extends('layouts.user.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('body')

<body class="relative h-screen overflow-y-auto overflow-x-hidden bg-light text-dark dark:bg-dark-2 dark:text-light">
    @endsection
    @section('content')
    <div class="mx-auto flex max-w-screen-2xl flex-col justify-between gap-4 p-4 lg:gap-6 lg:p-6">
            @include('layouts.user.topbar')
        <main class="grid grid-cols-1 gap-4  lg:gap-6">

            <!-- Başlık -->
            <div class="rounded-2xl bg-white p-6 shadow dark:bg-black dark:shadow-dark lg:col-span-3 lg:p-10">
                <div class="">
                    <h2 class="text-3xl font-semibold leading-tight text-dark dark:text-light lg:text-[40px] lg:leading-tight">
                        Kişisel Blog Sayfamda Paylaştığım İçerikleri <span class="text-primary">Keşfet</span>
                    </h2>
                </div>

                <!-- Blog -->
                <div class="mt-10 lg:mt-14">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-10 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($items as $i)
                            <div class="">
                            <div class="relative">
                                <a href="{{url('Blog/')}}/{{$i->url}}" class="group block aspect-6/4 overflow-hidden rounded-lg">
                                    <img src="{{$i->cover}}" alt="" class="h-full w-full rounded-lg object-cover transition duration-700 group-hover:scale-105" />
                                </a>

                                <!-- Tags -->
                                <div class="absolute bottom-4 left-4 flex flex-wrap gap-2">
                                    <a href="{{url('Blog/Kategori')}}/{{$i->category[0]->plug}}" class="inline-flex items-center justify-center gap-2 rounded bg-white px-2 py-1 text-center text-xs leading-none text-primary shadow transition hover:bg-primary hover:text-white">
                                        {{$i->category[0]->name}}
                                    </a>
                                </div>
                            </div>
                            <div class="mt-6">
                                <h2 class="text-xl font-medium xl:text-2xl">
                                    <a href="{{url('Blog/')}}/{{$i->url}}" class="inline-block text-dark transition hover:text-primary dark:text-light/70 dark:hover:text-primary">
                                        {{$i->baslik}}
                                    </a>
                                </h2>

                                <ul class="mt-4 flex flex-wrap items-center gap-2">
                                    <li class="relative text-sm text-muted/50 before:mr-1  dark:text-muted">
                                        {{$i->created_at}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-10 flex items-center justify-center gap-1.5">
                        <button type="button" class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border border-light text-center text-dark transition hover:border-primary hover:text-primary focus:outline-none focus:ring-2 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:text-muted dark:hover:border-primary dark:hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>

                            <span aria-hidden="true" class="sr-only">Previous</span>
                        </button>
                        <button type="button" class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border border-light text-center text-dark transition hover:border-primary hover:text-primary focus:outline-none focus:ring-2 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:text-muted dark:hover:border-primary dark:hover:text-primary" aria-current="page">
                            1
                        </button>
                        <button type="button" class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border border-light text-center text-dark transition hover:border-primary hover:text-primary focus:outline-none focus:ring-2 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:text-muted dark:hover:border-primary dark:hover:text-primary">
                            2
                        </button>
                        <button type="button" class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border border-light text-center text-dark transition hover:border-primary hover:text-primary focus:outline-none focus:ring-2 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:text-muted dark:hover:border-primary dark:hover:text-primary">
                            3
                        </button>
                        <div class="hs-tooltip inline-block">
                            <button type="button" class="hs-tooltip-toggle group inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border border-light text-center text-dark transition hover:border-primary hover:text-primary focus:outline-none focus:ring-2 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:text-muted dark:hover:border-primary dark:hover:text-primary">
                                <span class="text-xs group-hover:hidden">тАвтАвтАв</span>
                                <svg class="hidden h-5 w-5 flex-shrink-0 group-hover:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 17 5-5-5-5" />
                                    <path d="m13 17 5-5-5-5" />
                                </svg>
                                <span
										class="hs-tooltip-content invisible absolute z-10 inline-block rounded bg-gray-900 px-2 py-1 text-xs font-medium text-white opacity-0 shadow-sm transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:bg-slate-700"
										role="tooltip">
										Next 4 pages
									</span>
                            </button>
                        </div>
                        <button type="button" class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border border-light text-center text-dark transition hover:border-primary hover:text-primary focus:outline-none focus:ring-2 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:text-muted dark:hover:border-primary dark:hover:text-primary">
                            100
                        </button>
                        <button type="button" class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border border-light text-center text-dark transition hover:border-primary hover:text-primary focus:outline-none focus:ring-2 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:text-muted dark:hover:border-primary dark:hover:text-primary">
                            <span aria-hidden="true" class="sr-only">Next</span>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </nav>
                    <!-- End Pagination -->
                </div>
            </div>
        </main>
    </div>
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('public/build/js/app.js') }}"></script>
@endsection

    <script src="./assets/js/preline.js"></script>
    <script src="./assets/js/swiper-bundle.min.js"></script>
    <script src="./assets/js/venobox.min.js"></script>
    <script src="./assets/js/clipboard.min.js"></script>
    <script src="./assets/js/main.js"></script>

</body>

</html>
