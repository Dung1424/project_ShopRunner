@extends("layouts.customer.loginweb")

@section('main')
    <body>
    <!-- NAVBAR CREATION -->
    <header class="header">
        <nav class="navbar">
            <a href="{{url("/")}}">Home</a>
            <a href="{{url("/category")}}">Shop</a>
            <a href="{{url("/about-us")}}">About Us</a>
            <a href="{{url("/contact")}}">Contact</a>
        </nav>

    </header>
    <!-- LOGIN FORM CREATION -->
    <div class="background"></div>
    <div class="container">
        <div class="item">
            <h2 class="logo"></h2>
            <div class="text-item">
                <h2 style="color:#ff5732;">Welcome! <br><span>
                    To Shop Runner
                </span></h2>
                <p style="color: #ff5732;">Running is not just exercise, but also a journey of self-discovery</p>
                <div class="social-icon">
                    <a  href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                    <a href="#"><i class='bx bxl-youtube'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                </div>
            </div>
        </div>
        <div class="login-section">

            <div class="form-box login">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h2 style="color: #ff5732;">Sign Up</h2>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <label >Name</label>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <label >Email</label>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                        <input  id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <label >Password</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                        <input  id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <label>Confirm Password</label>
                    </div>
                    <div class="remember-password">
                        <label for=""><input type="checkbox">I agree with this statment</label>
                    </div>
                    <button style="background-color:#ff5732;" class="btn"> {{ __('Register') }}</button>
                    <div class="create-account">
                        <p>Already Have An Account? <a style="color: #ff5732;" href="{{route("login")}}" class="login-link">Sign In</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- SIGN UP FORM CREATION -->


    </body>
@endsection
