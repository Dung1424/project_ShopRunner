@extends("layouts.customer.app")
@section("main")

    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Reviews</h4>
                    </div>
                    <div class="breadcrumb__links">
                        <a href="/my-order">My Order</a>
                        <span>{{$product->name}}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="product_image_area">
        <div class="container">
            @if(session()->has("success"))
                <div class="alert alert-success" role="alert">
                    {{ session("success") }}
                </div>
            @endif

            @if(session()->has("error"))
                <div class="alert alert-danger" role="alert">
                    {{ session("error") }}
                </div>
            @endif
        </div>
    </div>
    <!--================End Single Product Area =================-->
    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul  style="height: 50px;" class="nav nav-tabs" id="myTab" role="tablist">

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row total_rate">
                                <div class="col-6">
                                    <div class="box_total">
                                        <h5>Overall</h5>
                                        <h4>{{$avgRating}}</h4>
                                        <h6>({{$ratingCount}} Reviews)</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="rating_list">
                                        <h3>Based on 3 Reviews</h3>
                                        <ul class="list">
                                            @php
                                                $ratings = \App\Models\Review::all();
                                                    $starRatings = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                                    $productRatings = $ratings->where('product_id', $product->id);

                                                    foreach ($productRatings as $rating) {
                                                        $starRatings[$rating->rating]++;
                                                    }
                                            @endphp

                                            @foreach($starRatings as $rating => $count)
                                                <li>
                                                    <a href="#"  class="filter-rating" data-rating="{{ $rating }}">
                                                        {{$rating}} Star
                                                        @php
                                                            for ($i = 0; $i < $rating; $i++) {
                                                                echo '<i class="fa fa-star"></i>';
                                                            }
                                                        @endphp
                                                        {{$count}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="review_list">
                                @if(count($ratings)>0)
                                    @foreach($product->Reviews as $rating)
                                        <div class="review_item">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h4>{{$rating['user']['name']}}</h4>
                                                    @php
                                                        $count=1;
                                                        while ($count<= $rating['rating']){ @endphp
                                                    <span style="color: #ffc700">&#9733;</span>
                                                    @php $count++; } @endphp
                                                    <h4>{{ date("d-m-Y H:i:s", strtotime($rating->created_at))}}</h4>
                                                    <br>
                                                    <h4>{{$rating->message}}</h4>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    @endforeach
                                @else
                                    <p>Review are not available for this product!!!</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="review_box">
                                <h4>Add a Review</h4>
                                <hr>
                                <form class="row contact_form" name="ratingForm" id="ratingForm contactForm"
                                      action="{{url("/add-rating")}}" method="post" novalidate="novalidate">
                                    @csrf

                                    <input type="hidden" class="form-control" id="product_id" name="product_id" value="{{$product->id}}">
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rating" value="5" />
                                        <label for="star5">5 stars</label>
                                        <input type="radio" id="star4" name="rating" value="4" />
                                        <label for="star4">4 stars</label>
                                        <input type="radio" id="star3" name="rating" value="3" />
                                        <label for="star3">3 stars</label>
                                        <input type="radio" id="star2" name="rating" value="2" />
                                        <label for="star2">2 stars</label>
                                        <input type="radio" id="star1" name="rating" value="1" />
                                        <label for="star1">1 star</label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Review"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <hr>
                                        <button type="submit" value="submit" class="site-btn">Submit Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@stop()
@section("before_css")
    <style>
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }

    </style>
    <style>
        .item {
            display: flex;
        }

        .item img {
            margin-right: 25px;
        }
        .item img:last-child {
            margin-right: 0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy danh sách các ảnh thumb
            const thumbImages = document.querySelectorAll('.item img');

            // Lấy ảnh lớn
            const largeImage = document.getElementById('largeImage'); // Sử dụng id "largeImage"

            // Thêm sự kiện click cho từng ảnh thumb
            thumbImages.forEach(function(thumb) {
                thumb.addEventListener('click', function() {
                    // Lấy đường dẫn của ảnh lớn từ thuộc tính data-imgbigurl của ảnh thumb
                    const imgBigUrl = thumb.getAttribute('data-imgbigurl');

                    // Cập nhật ảnh lớn
                    largeImage.setAttribute('src', imgBigUrl);
                });
            });
        });


    </script>


@stop()


