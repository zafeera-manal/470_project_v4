<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-woox-travel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        

        <!-- ***** Header Area Start ***** -->
        <header class="header-area header-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <nav class="main-nav">
                            <!-- ***** Logo Start ***** -->
                            <!--<a href="{{ url('/') }}" class="logo">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="">
                            </a>-->
                            <h1><span class="logo" style="color: #fcbad3;">TravelBuddy</span></h1>
                            <!-- ***** Logo End ***** -->
                            <!-- ***** Menu Start ***** -->
                            <ul class="nav">
                                <!--<li><a href="{{ route('friends.index') }}">Friends</a></li>
                                <li><a href="{{ route('itineraries.index')}}">Itineraries</a></li>
                                <li><a href="{{ route('group_trips.index') }}">Group Trips</a></li>-->

                                <li>
                                    @auth
                                        @if (Auth::user()->role == 1) <!-- Check if the user is an admin -->
                                            <a href="#">Friends</a>
                                        @else
                                            <a href="{{ route('friends.index') }}">Friends</a>
                                        @endif
                                    @endauth
                                </li>

                                <li>
                                    @auth
                                        @if (Auth::user()->role == 1) <!-- Check if the user is an admin -->
                                            <a href="#">Itineraries</a>
                                        @else
                                            <a href="{{ route('itineraries.index') }}">Itineraries</a>
                                        @endif
                                    @endauth
                                </li>

                                <li>
                                    @auth
                                        @if (Auth::user()->role == 1) <!-- Check if the user is an admin -->
                                            <a href="#">Group Trips</a>
                                        @else
                                            <a href="{{ route('group_trips.index') }}">Group Trips</a>
                                        @endif
                                     @endauth
                                </li>
                                
                                
                                @guest
                                    @if (Route::has('login'))
                                        <li><a href="{{ route('login') }}">Login</a></li>
                                    @endif
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                    @endif
                                @else
                                    <li>
                                        @auth
                                            @if (Auth::user()->role == 1) <!-- Check if the user is an admin -->
                                                <a href="{{ route('admin.dashboard') }}">Hi, {{ Auth::user()->name }}!</a>
                                            @else
                                                <a href="{{ route('home') }}">Hi, {{ Auth::user()->name }}!</a>
                                            @endif
                                        @endauth
                                    </li>

                                    <!--<li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Hi, {{ Auth::user()->name }}!
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>-->
                                    <li>
                                        <a  href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                        </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                    </li>
                                @endguest
                            </ul>   
                            <a class='menu-trigger'>
                                <span>Menu</span>
                            </a>
                            <!-- ***** Menu End ***** -->
                        </nav>
                            
                    </div>
                </div>
            </div>
        </header>
        <!-- ***** Header Area End ***** -->

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <p>Copyright © 2036 <a href="#">WoOx Travel</a> Company. All rights reserved. 
                <br>Design: <a href="https://templatemo.com" target="_blank" title="free CSS templates">TemplateMo</a> Distribution: <a href="https://themewagon.com target="_blank" >ThemeWagon</a></p>
                </div>
            </div>
        </div>
    </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- <script src="https://unpkg.com/@popperjs/core@2"></script> 

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>-->

    <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/tabs.js') }}"></script>
    <script src="{{ asset('assets/js/popup.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        function bannerSwitcher() {
        next = $('.sec-1-input').filter(':checked').next('.sec-1-input');
        if (next.length) next.prop('checked', true);
        else $('.sec-1-input').first().prop('checked', true);
        }

        var bannerTimer = setInterval(bannerSwitcher, 5000);

        $('nav .controls label').click(function() {
        clearInterval(bannerTimer);
        bannerTimer = setInterval(bannerSwitcher, 5000)
        });
    </script>

</body>
</html>