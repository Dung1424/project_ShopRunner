@extends("layouts.customer.app")
@section("main")
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="/customer/img/hero/runner1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.</p>
                                <a href="#" class="site-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="/customer/img/hero/runner2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.</p>
                                <a href="#" class="site-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="/customer/img/banner/banner1.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Clothing Collections 2030</h2>
                            <a href="{{url("/category")}}">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__pic">
                            <img src="/customer/img/banner/banner2.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Accessories</h2>
                            <a href="{{url("/category")}}">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner__item banner__item--last">
                        <div class="banner__item__pic">
                            <img src="/customer/img/banner/banner3.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Shoes Spring 2030</h2>
                            <a href="{{url("/category")}}">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Best Sellers</li>
                        <li data-filter=".new-arrivals">New Arrivals</li>
                        <li data-filter=".hot-sales">Discounted products</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">

                @foreach($products->take(4) as $item)
                    <div class="col-lg-3 col-md-6 col-sm-6 mix best-sellers">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset($item->thumbnail) }}">
                                <ul class="product__hover">

                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{$item->name}}</h6>
                                <a href="{{url("/details",["product"=>$item->slug])}}" class="add-cart">+ Add To Cart</a>
                                <div class="rating">
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <h5>${{ $item->price }}</h5>

                            </div>
                        </div>
                    </div>
                @endforeach
                    @foreach($products->skip(2)->take(2) as $item)
                        <div class="col-lg-3 col-md-6 col-sm-6 mix  new-arrivals">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ asset($item->thumbnail) }}">
                                    <ul class="product__hover">

                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{$item->name}}</h6>
                                    <a href="{{url("/details",["product"=>$item->slug])}}" class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <h5>${{ $item->price }}</h5>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach($products->skip(2)->take(2) as $item)
                        <div class="col-lg-3 col-md-6 col-sm-6 mix  hot-sales">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ asset($item->thumbnail) }}">
                                    <ul class="product__hover">

                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{$item->name}}</h6>
                                    <a href="{{url("/details",["product"=>$item->slug])}}" class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <h5>${{ $item->price }}</h5>

                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </section>

    <!-- Product Section End -->

    <!-- Categories Section Begin -->
    <section class="categories spad">
        @foreach($products->take(1) as $item)
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>Clothings Hot <br /> <span>Shoe Collection</span> <br /> Accessories</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="{{ asset($item->thumbnail) }}" alt="">
                        <div class="hot__deal__sticker">
                            <span>Sale Of</span>
                            <h5>${{$item->price}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <span>Deal Of The Week</span>
                        <h2>{{$item->name}}</h2>
                        <div class="categories__deal__countdown__timer" id="countdown">
                            <div class="cd-item">
                                <span>3</span>
                                <p>Days</p>
                            </div>
                            <div class="cd-item">
                                <span>1</span>
                                <p>Hours</p>
                            </div>
                            <div class="cd-item">
                                <span>50</span>
                                <p>Minutes</p>
                            </div>
                            <div class="cd-item">
                                <span>18</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <a href="{{url("/details",["product"=>$item->slug])}}" class="site-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </section>
    <!-- Categories Section End -->



    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Latest News</span>
                        <h2>Fashion New Trends</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="/customer/img/about/testimonial-pic1.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="/customer/img/icon/calendar.png" alt=""> 16 February 2020</span>
                            <h5>What Curling Irons Are The Best Ones</h5>
                            <a href="{{url("/about-us")}}">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="/customer/img/about/aboutus.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="/customer/img/icon/calendar.png" alt=""> 21 February 2020</span>
                            <h5>Eternity Bands Do Last Forever</h5>
                            <a href="{{url("/about-us")}}">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="/customer/img/blog/blog-3.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="/customer/img/icon/calendar.png" alt=""> 28 February 2020</span>
                            <h5>The Health Benefits Of Sunglasses</h5>
                            <a href="{{url("/about-us")}}">Read More</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- Latest Blog Section End -->

@endsection
