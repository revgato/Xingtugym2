<!--Navbar-->
<nav class="navbar navbar-light bg-light" style="box-shadow: 0px 0px 8px #888888;">

    <!-- Navbar brand -->
    <div class="ml-auto order-0">
        <a class="navbar-brand mx-4" href="/">
            <span class="brand-name brand-name-light">Xingtu</span><span class="brand-name brand-name-bold">Gym</span>
        </a>
    </div>
    @guest
    @if(Route::has('login'))
    <div class="d-flex align-items-center ml-auto order-1">
        <div class=" order-1">
            <a class="nav-link mx-4" href="{{ route('login') }}">ログイン</a>
        </div>
        @endif
        @if(Route::has('signup'))
        <div class=" order-2">
            <a class="btn btn-primary  mx-4" href="{{ route('signup') }}">サインアップ</a>
        </div>
    </div>
    @endif
    @else
    <!-- Avatar and Name -->
    <div class="d-flex align-items-center ml-auto order-1">
        <!-- Avatar and Name -->
        <div class="nav-user mx-3">
            <span class="username mx-3" style="font-weight: 600px;">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->avatar }}" class="rounded-circle shadow-4" style="width: 50px;" alt="Avatar" onclick="toggleMenu()" />
        </div>
        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <a href="#" class="sub-menu-link">
                    <i class="fa-solid fa-user" style="font-size: 20px; margin-right: 6px"></i>
                    <span class="">プロファイル</span>
                </a>
                <hr />
                <a href="#" class="sub-menu-link">
                    <i class="fa-solid fa-lock" style="font-size: 20px; margin-right: 6px"></i>
                    <p>パスワードを変更する</p>
                    <span style="font-size: 20px; transform: 0.5s">></span>
                </a>
                <a href="{{ route('logout') }}" class="sub-menu-link">
                    <i class="fa-solid fa-right-from-bracket" style="font-size: 20px; margin-right: 6px"></i>
                    <span class="">ログアウト</span>
                </a>
            </div>
        </div>
        <!-- Collapse button -->
        <button class="btn btn-link" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation" onclick="Nav()" style="z-index: 2">
            <div class="animated-icon"><span></span><span></span><span></span></div>
        </button>
    </div>
    @if(Auth::user()->role == 'user')
    <div class="row">
        <div class="col-1 d-flex justify-content-center">
            <div id="mySidenav" class="sidenav">
                <a href="{{route('gym.index')}}">ジム検索</a>
                <a href="#">Services</a>
                <a href="#">Clients</a>
                <a href="{{ route('logout') }}">ログアウト</a>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->role == 'gym-owner')
    <div class="row">
        <div class="col-1 d-flex justify-content-center">
            <div id="mySidenav" class="sidenav">
                <a href="{{ route('my-gym') }}">私のジム</a>
            </div>
        </div>
    </div>
    @endif
    @endguest
</nav>
<!--/.Navbar-->

<style>
    .sub-menu-wrap {
        position: absolute;
        top: 100%;
        right: 4%;
        width: 250px;
        max-height: 0px;
        overflow: hidden;
        transition: max-height 0.5s;
    }

    .sub-menu-wrap.open-menu {
        max-height: 400px;
        z-index: 999;
    }

    .sub-menu {
        background: #fff;
        padding: 20px;
        margin: 10px;
        border: 1px solid #888888;
        margin: 0 0 0 0;
        border-radius: 10px;
    }

    .user-info {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sub-menu hr {
        height: 1;
        width: 100%;
        color: black;
        margin: 15px 0 10px;
    }

    .sub-menu-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: black;
        margin: 12px 0;
    }

    .sub-menu p {
        display: flex;
        width: 100%;
        margin-bottom: 0;
        align-items: center;
    }

    .sub-menu-link:hover span {
        transform: translateX(5px);
    }

    .sub-menu-link:hover p {
        font-weight: 600;
    }


    .brand-name {
        font-family: 'Architects Daughter';
        font-size: 28px;
        display: inline-block;
    }

    .brand-name-light {
        font-weight: lighter;

        /* tùy chỉnh khoảng cách giữa các phần tử */
    }

    .brand-name-bold {
        font-weight: bold;
    }

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        right: 0;
        background-color: #f8f9fa !important;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        box-shadow: 0px 0px 8px #888888;
    }

    .sidenav a {
        padding: 8px 8px 8px 16px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #5256ad;
    }

    .sidenav::-webkit-scrollbar {
        display: none;
    }


    .animated-icon {
        width: 30px;
        height: 20px;
        position: relative;
        margin: 0px;
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
        -webkit-transition: .5s ease-in-out;
        -moz-transition: .5s ease-in-out;
        -o-transition: .5s ease-in-out;
        transition: .5s ease-in-out;
        cursor: pointer;
        z-index: 100;
    }

    .animated-icon span {
        display: block;
        position: absolute;
        height: 3px;
        width: 100%;
        border-radius: 9px;
        opacity: 1;
        right: 8px;
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
        -webkit-transition: .25s ease-in-out;
        -moz-transition: .25s ease-in-out;
        -o-transition: .25s ease-in-out;
        transition: .25s ease-in-out;
    }

    .animated-icon span {
        background: #5256ad;
    }

    .animated-icon span:nth-child(1) {
        top: 0px;
        right: 8px;
        -webkit-transform-origin: right center;
        -moz-transform-origin: right center;
        -o-transform-origin: right center;
        transform-origin: right center;
    }

    .animated-icon span:nth-child(2) {
        top: 10px;
        right: 8px;
        -webkit-transform-origin: right center;
        -moz-transform-origin: right center;
        -o-transform-origin: right center;
        transform-origin: right center;
    }

    .animated-icon span:nth-child(3) {
        top: 20px;
        right: 8px;
        -webkit-transform-origin: right center;
        -moz-transform-origin: right center;
        -o-transform-origin: right center;
        transform-origin: right center;
    }

    .animated-icon.open span:nth-child(1) {
        top: 20px;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .animated-icon.open span:nth-child(2) {
        opacity: 0;
    }

    .animated-icon.open span:nth-child(3) {
        top: 0px;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }
</style>
<script>
    function Nav() {
        var width = document.getElementById("mySidenav").style.width;
        if (width === "0px" || width == "") {
            document.getElementById("mySidenav").style.width = "250px";
            $('.animated-icon').toggleClass('open');
        } else {
            document.getElementById("mySidenav").style.width = "0px";
            $('.animated-icon').toggleClass('open');
        }
    }
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
        subMenu.classList.toggle("open-menu");
    }
</script>
