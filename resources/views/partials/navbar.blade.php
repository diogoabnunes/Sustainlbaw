<nav style="z-index: 1;" class="navbar navbar-light navbar-expand-xxl w-100 container-default">
    <div class="container-fluid p-0 bg-white h-100">
        <a class="navbar-brand d-flex justify-content-center align-items-center fs-4 gap-2 " href="/">
            <img src="{{ asset('assets/logo.svg') }}" height="60" width="60" alt="logo">
            <h4 class="text-secondary m-0 fw-bolder">&nbsp;Sustainlbaw</h4>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="w-100 collapse navbar-collapse p-4" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item mx-2">
                    <a class="nav-link" href="/market">mercadinho</a>
                </li>
                <li class="nav-item  mx-2">
                    <a class="nav-link" href="/blog">blog</a>
                </li>
                <li class="nav-item  mx-2">
                    <a class="nav-link" href="/events">eventos e experiências</a>
                </li>


            </ul>

            <div class="d-flex flex-column flex-lg-row gap-4 loginBtn ">
                <div class="d-flex flex-row flex-wrap gap-4">
                    <form id="search-global" method="get" action="{{ route('search') }}"
                        class="d-flex justify-content-start align-items-center">
                        <div class="d-flex flex-row justify-content-start align-items-center gap-0">
                            <input id="search-input" type="search" name="keywords" id="form1" class="form-control"
                                placeholder="Pesquisar" />
                            <button id="search-button" type="submit" form="search-global" value="Search"
                                class="btn btn-primary rounded-0 rounded-end">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>


                    <div class="dropdown">
                        @if (Auth::check())
                            <button
                                class="btn btn-light  dropdown-toggle me-2 d-flex justify-content-start align-items-center gap-2"
                                type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">


                                <img src="{{ Auth::user()->getAdminAvatar() }}" alt="{{ Auth::user()->image_path }}"
                                    class="rounded-circle" width="35" height="35">
                                <span
                                    class="username">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>


                            </button>

                            <ul class="dropdown-menu dropdown-menu-lg-end me-2" style=""
                                aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item d-flex" href="/user">
                                        <!-- TO CHANGE -->
                                        Perfil
                                    </a></li>
                                @if (Auth::check() && Auth::user()->isAdmin())
                                    <li><a class="dropdown-item d-flex" href="/admin">
                                            Administração</a>
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        {{ __('Sair') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        @else
                            <a href="/login" class="btn btn-primary rounded rounded-end">Entrar</a>


                        @endif

                    </div>
                </div>
                <!-- <a href="signIn.php" class="btn btn-outline-success"><i class="fas fa-user"></i>&nbsp;&nbsp;Entrar</a> -->
            </div>
        </div>
    </div>
</nav>
