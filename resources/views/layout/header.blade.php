<div class="row">
    <div class="col-1 d-flex justify-content-center">
        <div id="mySidenav" class="sidenav">
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
        </div>
    </div>
</div>
<!--Navbar-->
<nav class="navbar navbar-light bg-light" style="box-shadow: 0px 0px 8px #888888;">

    <!-- Navbar brand -->
    <div class="ml-auto order-0">
        <a class="navbar-brand mx-4" href="/">
            <span class="brand-name brand-name-light">Xingtu</span><span class="brand-name brand-name-bold">Gym</span>
        </a>
    </div>
    <!-- Avatar and Name -->
    <div class="d-flex align-items-center ml-auto order-1">
        <!-- Avatar and Name -->
        <div class="nav-user mx-3">
            <span class="username  mx-3">John Doe</span>
            <img src="/images/avatar/avatar1.webp" class="rounded-circle shadow-4" style="width: 50px;" alt="Avatar" />
        </div>
        <!-- Collapse button -->
        <button class="btn btn-link" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation" onclick="Nav()" style="z-index: 2">
            <div class="animated-icon"><span></span><span></span><span></span></div>
        </button>
    </div>
</nav>
<!--/.Navbar-->

<style>
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
</script>