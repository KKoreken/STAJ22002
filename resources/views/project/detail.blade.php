
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

            <!-- Services -->
            <div class="rounded-2xl bg-white p-6 shadow dark:bg-black dark:shadow-dark lg:col-span-2 lg:p-10">
                <figure class="aspect-video overflow-hidden rounded-lg">
                    <img src="{{$item->cover}}" alt="" class="h-full w-full object-cover" />
                </figure>

                <ul class="mt-4 flex flex-wrap items-center gap-4 md:gap-6">
                    <li class="relative text-sm text-muted/50 before:mr-1 before:content-['\2022'] dark:text-muted">
                        {{$item->created_at}}
                    </li>
                </ul>

                <article class=" mt-6 dark:prose-invert xl:prose-lg prose-headings:font-medium prose-blockquote:border-primary lg:mt-10">
                    <h2 class="">{{$item->baslik}}</h2>
                    <?=$item->body?>
                </article>

                <div class="mt-10 flex flex-wrap justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-5">
                        <h6 class="text-lg font-medium text-dark dark:text-light">Kategori:</h6>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{url('Blog/Kategori')}}/{{$item->category[0]->plug}}" class="inline-flex items-center justify-center gap-2 rounded border border-light bg-white px-2 py-1 text-center text-xs font-medium leading-none text-dark transition hover:bg-primary hover:text-white dark:border-dark dark:bg-dark-2 dark:text-light/70 dark:hover:bg-primary dark:hover:text-white">
                                {{$item->category[0]->name}}
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-5">
                        <h6 class="text-lg font-medium text-dark dark:text-light">Etiketler:</h6>

                        <div class="flex flex-wrap gap-2">
                            @foreach($item->label as $i)
                                <a href="{{url('Blog/Etiket')}}/{{$i->plug}}" class="inline-flex items-center justify-center gap-2 rounded border border-light bg-white px-2 py-1 text-center text-xs font-medium leading-none text-dark transition hover:bg-primary hover:text-white dark:border-dark dark:bg-dark-2 dark:text-light/70 dark:hover:bg-primary dark:hover:text-white">
                                    {{$i->name}}
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="mt-10 lg:mt-14">
                    <h3 class="text-2xl font-semibold leading-tight text-dark dark:text-light lg:text-3xl lg:leading-tight">
                        Son Paylaşımlar
                    </h3>
                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 md:grid-cols-2 lg:mt-8">
                        @foreach($sonposts as $i)
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
                                        <li class="relative text-sm text-muted/50 before:mr-1 before:content-['\2022'] dark:text-muted">
                                            {{$i->created_at}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="mt-10 lg:mt-14">
                    <h3 class="text-2xl font-semibold leading-tight text-dark dark:text-light lg:text-3xl lg:leading-tight">
                        Bu Paylaşıma Bir Yorum Bırak
                    </h3>

                    <form action="#" class="mt-6 space-y-6 rounded-lg bg-light p-6 dark:bg-dark-2 lg:mt-8 xl:p-12">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="">
                                <label for="name" class="mb-2 block text-sm font-medium text-dark dark:text-light">
                                    Name
                                </label>
                                <input type="text" id="name" name="Name" placeholder="Enter your name" class="block w-full rounded-lg border border-gray-200 bg-white px-6 py-4 text-base outline-none transition focus:border-dark focus:ring focus:ring-dark/20 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:bg-black dark:text-white dark:focus:border-muted dark:focus:ring-white/20" />
                            </div>
                            <div class="">
                                <label for="email" class="mb-2 block text-sm font-medium text-dark dark:text-light">
                                    Email
                                </label>
                                <input type="email" id="email" name="Email" placeholder="Enter your email" class="block w-full rounded-lg border border-gray-200 bg-white px-6 py-4 text-base outline-none transition focus:border-dark focus:ring focus:ring-dark/20 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:bg-black dark:text-white dark:focus:border-muted dark:focus:ring-white/20" />
                            </div>
                        </div>

                        <div class="">
                            <label for="comment" class="mb-2 block text-sm font-medium text-dark dark:text-light">
                                Comment
                            </label>

                            <textarea name="Comment" id="comment" placeholder="Type details about your inquiry" rows="4" class="block w-full rounded-lg border border-gray-200 bg-white px-6 py-4 text-base outline-none transition focus:border-dark focus:ring focus:ring-dark/20 disabled:pointer-events-none disabled:opacity-50 dark:border-dark dark:bg-black dark:text-white dark:focus:border-muted dark:focus:ring-white/20"></textarea>
                        </div>

                        <button type="submit" class="inline-flex w-full items-center justify-center gap-x-2 rounded-lg border border-transparent bg-primary px-6 py-4 text-center font-medium text-white transition hover:bg-blue-600 focus:outline-none focus:ring disabled:pointer-events-none disabled:opacity-50">
                            <span>Post Comment</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" class="h-5 w-5">
                                <path d="M17.5 11.667v-5h-5" />
                                <path d="m17.5 6.667-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('public/build/js/app.js') }}"></script>
@endsection

    <script src="{{url('public')}}/assets/js/preline.js"></script>
    <script src="{{url('public')}}/assets/js/swiper-bundle.min.js"></script>
    <script src="{{url('public')}}/assets/js/venobox.min.js"></script>
    <script src="{{url('public')}}/assets/js/clipboard.min.js"></script>
    <script src="{{url('public')}}/assets/js/main.js"></script>

</body>

</html>
