@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>  List of products</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div  class="row">
            <div  class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-2">
                                <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                                        class="fas fa-print"></i> Print data</a>
                            </div>

                        </div>

                        <form style="display: flex" action="{{url("admin/admin-rating")}}" method="get">
                            <div class="input-group input-group-sm mr-2" style="width: 150px; margin-left: 5px;">
                                <select value="{{app("request")->input("category_id")}}" style="height: 45px;" name="category_id" class="form-control">
                                    <option value="0">Filter by category</option>
                                    @foreach($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group input-group-sm mr-2" style="width: 100px; float:left">
                                <input value="{{app("request")->input("price_from")}}" class="form-control" type="number" name="price_from" placeholder="Price from"/>
                            </div>
                            <div class="input-group input-group-sm mr-2" style="width: 100px; float:left">
                                <input value="{{app("request")->input("price_to")}}" class="form-control" type="number" name="price_to" placeholder="Price to"/>
                            </div>
                            <div class="input-group input-group-sm mr-2" style="width: 100px; float:left">
                                <input value="{{ app('request')->input('rate') }}" class="form-control" type="text" name="rate" placeholder="Rating"/>
                            </div>
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input  value="{{app("request")->input("search")}}" type="text" name="search" class="form-control float-right" placeholder="Search">

                                <button style="height: 45px; margin-left: 3px;"  type="submit" class="btn btn-default">
                                    <i   class="fas fa-search"></i>
                                </button>

                            </div>
                        </form>

                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="all"></th>
                                <th>Id</th>
                                <th>
                                    Product's name</th>
                                <th>image</th>
                                <th>Price</th>
                                <th>Catagory</th>
                                <th>Number of rating stars</th>
                                <th width="70px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td width="10">
                                        <input type="checkbox" name="selected_products[]" value="{{ $product->id }}">
                                    </td>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <img src="{{ $product->thumbnail }}" style="width: 100px; height: auto;" alt="">
                                    </td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ number_format($product->averageRating(), 1) }} </td>
                                    <td >
                                        <button style="padding: 8px 8px;" class="site-btn"  type="submit">
                                            <a href="{{ route('admin-rating-details', ['product_id' => $product->id]) }}">
                                                Review
                                            </a>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--
      MODAL
    -->

    <style>
        table {
            width: 100%;
            table-layout: fixed;
        }

        td {
            overflow: hidden;
        }

        img {
            max-width: 100%;
            height: auto;
        }

    </style>
    <!--
    MODAL
    -->
    @include("admin.layouts.scripts")
@endsection

