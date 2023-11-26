<!-- Header Section Begin -->
<header class="header">

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="{{url("/")}}"><img src="/customer/img/logor.jpg" style="width: 170px;" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="active"><a href="{{url("/")}}">Home</a></li>
                        <li><a href="{{url("/category")}}">Shop</a></li>
                        <li><a href="{{url("/about-us")}}">About Us</a></li>
                        <li><a href="{{url("/contact")}}">Contacts</a></li>
                    </ul>
                </nav>
            </div>

            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <div class="dropdown">
                        <form class="spacial-controls" role="search" method="get" id="search" action="{{url('search-product')}}">
                            <input type="text" name="key" id="searchInput" placeholder="Search...">
                            <ul id="searchResults"></ul>
                            <i class="fas fa-search" type="submit" id="searchIcon"></i>
                        </form>
                        <a class="dropbtn" onclick="showDropdown()"><img src="/customer/img/icon/user.png" style="width:20px;" alt=""></a>
                        <div class="dropdown-content" id="myDropdown">
                            @auth()
                            <div class="top-icon">
                                <a href="{{url("profile")}}"><i class="fa fa-user"></i> {{auth()->user()->name}}</a>
                            </div>

                            <a href="{{url("my-order")}}"><i class="fa-brands fa-shopify"></i>My order</a>
                            <form id="form-logout" action="{{route("logout")}}" method="post">
                                @csrf
                            </form>
                            <a href="javascript:void(0);" onclick="$('#form-logout').submit();">
                                <i class="fa fa-align-right"></i>Logout</a>
                            @endauth
                                @guest()
                                    <a href="{{route("login")}}"><i class="fa-solid fa-right-to-bracket"></i>Login</a>
                                    <a href="{{route("register")}}"><i class="fa fa-user"></i>Register</a>
                                @endguest
                        </div>
                        <a href="{{url("/cart")}}">
                            <img src="/customer/img/icon/cart.png" alt="">
                            <span>{{session()->has("cartShop")?count(session("cartShop")):0}}</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>
<!-- Header Section End -->
