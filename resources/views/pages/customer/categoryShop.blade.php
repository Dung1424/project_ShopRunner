@extends("layouts.customer.app")
@section("main")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="{{url("/")}}">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                @include("layouts.customer.sidebar")
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <h6><span>{{$products->total()}}</span> Products found</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form style="display: flex" action="{{url("/category/")}}" method="get">
                        <div class="input-group input-group-sm mr-2" style="width: 150px; margin-left: 5px;">
                            <select value="{{ app("request")->input("category_id") }}" style="height: 45px;" name="category_id" class="form-control">
                                <option value="0">Filter by category</option>
                                @foreach($categories as $item)
                                    <option value="{{ $item->id }}" {{ app("request")->input("category_id") == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-sm mr-2" style="width: 150px; margin-left: 5px;">
                            <input  type="number" name="price_from" class="form-control" placeholder="Price from">
                        </div>

                        <div class="input-group input-group-sm mr-2" style="width: 150px;">
                            <input  type="number" name="price_to" class="form-control" placeholder="Price to">
                        </div>


                        <div class="input-group input-group-sm" style="width: 150px;float:left">
                            <div class="input-group-append">
                                <button style="background-color: #ff5732; color: whitesmoke" type="submit" class="btn btn-default">
                                    Lọc
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">

                        @foreach($products as $item)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ asset($item->thumbnail) }}">
                                        <ul class="product__hover">

                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6 >{{$item->name}}</h6>
                                        <a href="{{url("/details",["product"=>$item->slug])}}" class="add-cart">+ Add To Cart</a>
                                        <div class="rating">
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>

                                        <h5>${{$item->price}}</h5>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                                @if ($products->lastPage() > 1)
                                    @if ($products->currentPage() > 3)
                                        <a href="{{ $products->url(1) }}">1</a>
                                        @if ($products->currentPage() > 4)
                                            <span>...</span>
                                        @endif
                                    @endif
                                    @for ($i = max(1, $products->currentPage() - 2); $i <= min($products->lastPage(), $products->currentPage() + 2); $i++)
                                        @if ($i == $products->currentPage())
                                            <a class="active" href="{{ $products->url($i) }}">{{ $i }}</a>
                                        @else
                                            <a href="{{ $products->url($i) }}">{{ $i }}</a>
                                        @endif
                                    @endfor
                                    @if ($products->currentPage() < $products->lastPage() - 2)
                                        @if ($products->currentPage() < $products->lastPage() - 3)
                                            <span>...</span>
                                        @endif
                                        <a href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection

