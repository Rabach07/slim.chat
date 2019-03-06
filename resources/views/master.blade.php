<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/solid.css" integrity="sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/fontawesome.css" integrity="sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+" crossorigin="anonymous">

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    <!-- Chat -->
    <script>
        window.slimchat = {
            app_id: '12345'
        };

        (function(d, w, t, f) {
            t = d.createElement('script');
            t.async = 1;
            t.src = w;
            f = d.getElementsByTagName('script')[0];
            f.parentNode.insertBefore(t, f);
        })(document, '{{ mix('/js/widget.js') }}');
    </script>
</head>
<body>
    <div>
        <nav class="bg-white text-green">
            <div class="container flex mx-auto">
                <div class="flex-1 py-1 px-2">
                    <a href="{{ url('/') }}" class="inline-block py-3 px-2 text-2xl text-green hover:text-green focus:text-green font-bold">
                        <i class="fas fa-fw fa-comment"></i>
                        {{ config('app.name') }}
                    </a>
                </div>

                <div>
                    <!-- Right Side Of Navbar -->
                    <ul class="list-reset flex">
                        <li class="p-2">
                            <a href="{{ route('login') }}" class="inline-block py-3 px-2 text-lg text-grey-darkest hover:underline">
                                Why Slim Chat?
                            </a>
                        </li>
                        <li class="p-2">
                            <a href="{{ route('login') }}" class="inline-block py-3 px-2 text-lg text-grey-darkest hover:underline">
                                Pricing
                            </a>
                        </li>
                        <li class="p-2">
                            <a href="{{ route('login') }}" class="inline-block py-3 px-2 text-lg text-grey-darkest hover:underline">
                                Blog
                            </a>
                        </li>
                        <li class="p-2">
                            <a href="{{ route('login') }}" class="inline-block py-3 px-2 text-lg text-grey-darkest hover:underline">
                                Developers
                            </a>
                        </li>
                        @guest
                            <li class="p-2">
                                <a href="{{ route('login') }}" class="inline-block p-3 text-lg text-grey-darkest hover:underline">
                                    Log in
                                </a>
                            </li>
                            <li class="p-2">
                                <a href="{{ route('register') }}" class="button blue">
                                    Start Free Trial
                                </a>
                            </li>
                        @else
                            <li class="p-2">
                                <a href="{{ url('/app') }}" class="button blue">
                                    <i class="fas fa-fw fa-user-circle"></i>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                                {{-- <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form> --}}
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pb-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
