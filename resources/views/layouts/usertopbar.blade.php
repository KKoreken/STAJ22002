
    <div class="sm:fixed bg-dark py-3  d-flex  bg-auth sm:top-0 sm:right-0 p-6 text-right">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @auth
            <a href="{{ url('/home') }}" class="font-semibold text-white mx-2 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Anasayfa</a>
            @if( Auth::user()->role_id=='0')<a href="{{route('ticket.show')}}" class="font-semibold text-white hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 mx-3">Ticketlarim</a>@endif
            <div class="w-100" >
                @if( Auth::user())
                <a class="dropdown-item float-end mx-2" style="width: max-content" href="javascript:void();"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="mdi text-danger mdi-lock text-muted font-size-16 align-middle me-1"></i> <span
                        class="align-middle text-danger">Çıkış Yap</span></a>
                    @if( Auth::user()->role_id!='0')
                        <a class="font-semibold float-end text-white hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 mx-3" href="{{url('panel')}}">Panele Git</a> @endif
                @endif

            </div>


        @else
            <div class="float-right">
                <a href="{{ route('login') }}" class="font-semibold mx-3 text-white hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Giris Yap</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-white hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Kayit Ol</a>
                @endif
            </div>

        @endauth
    </div>
