<header class="navbar navbar-expand-lg navbar-light bg-light py-0">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
        aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto mt-2">
            <li class="nav-item ml-5 mt-1">
                <a href="{{ url('/') }}"><i class="fa fa-arrow-left mt-3" aria-hidden="true"></i></a>
            </li>
            <li class="nav-item active ml-3 mt-2">
                <h4 class="nav-link">Membuat Berita</h4>
            </li>
        </ul>
        @if (Auth::user())
            <img src="{{ Auth::user()->avatar }}" class="preload-image mr-5"
                style="border-radius: 30px !important;width: 32px;height: auto;"
                onerror="this.onerror=null; this.src='{{ asset('img/profil/' . Auth::user()->avatar) }}'">
        @endif
    </div>
</header>
