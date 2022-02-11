<header class="main-header container-fluid" id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">

        <?php             
            $name = Auth::user()->name;
            $email = Auth::user()->email;
        ?>


        <!-- search form -->
        {{-- <div class="search-form d-none d-lg-inline-block">
            <div class="input-group">
                <button type="button" name="search" id="search-btn" class="btn btn-flat">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <input type="text" name="query" id="search-input" class="form-control"
                    placeholder="'button', 'chart' etc." autofocus autocomplete="off" />
            </div>
            <div id="search-results-container">
                <ul id="search-results"></ul>
            </div>
        </div> --}}

        <div class="navbar-right ">
            <ul class="nav navbar-nav ">

                <li>
                    <h3 class="ml-2 text-sm">Eazy Transfer</h3>
                </li>
                <!-- User Account -->
                <li class="dropdown user-menu ml-auto">
                    <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

                        <span class="d-none d-lg-inline-block">{{ $name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <!-- User image -->
                        <li class="dropdown-header">
                            <div class="d-inline-block">
                                {{ $name }} <small class="pt-1">{{ $email }}</small>
                            </div>
                        </li>
                        <li class="dropdown-footer">
                            <a href="{{ route('auth.logout') }}"> <i class="mdi mdi-logout"></i> Log Out </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </nav>


</header>