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
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2 style="color: #ff5732;">Sign In</h2>
                    <div class="input-box">

                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input  id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <label >Email</label>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <label >Password</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="remember-password">
                        <label for="">
                            <input style="margin-top: -12px;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forget Password?') }}
                        </a>
                        @endif
                    </div>
                    <button style="background-color:#ff5732;" type="submit" class="btn"> {{ __('Login') }}</button>
                    <div class="create-account">
                        <p>Create A New Account? <a style="color: #ff5732;" href="{{route("register")}}" class="register-link">Sign Up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- SIGN UP FORM CREATION -->


    </body>
@endsection
