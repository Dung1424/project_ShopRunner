@extends("admin.layouts.app")
@section("main")
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>
                            List of products</b></a></li>
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
                        <form style="display: flex" action="{{ route('admin-rating-details', ['product_id' => $product_id]) }}" method="get">
                            <div class="input-group input-group-sm mr-2" style="width: 100px; float:left">
                                <input value="{{ app('request')->input('customer_name') }}" type="text" name="customer_name" class="form-control float-right" placeholder="Customer Name">
                            </div>
                            <div class="input-group input-group-sm mr-2" style="width: 100px; float:left">
                                <input value="{{ app('request')->input('star_rating') }}" type="number" name="star_rating" class="form-control float-right" placeholder="Star Rating">
                            </div>
                            <div class="input-group input-group-sm mr-2" style="width: 150px; float:left">
                                <input value="{{ app('request')->input('email') }}" type="email" name="email" class="form-control float-right" placeholder="Email">
                            </div>
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input value="{{ app('request')->input('search') }}" type="text" name="search" class="form-control float-right" placeholder="Search">
                                <button style="height: 45px; margin-left: 3px;" type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="all"></th>
                                <th>Id</th>
                                <th>Customer name</th>
                                <th>Email</th>
                                <th>message</th>
                                <th>Number of rating stars </th>
                                <th>Created_at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reviews as $review)
                                <tr>
                                    <td width="10">
                                        <input type="checkbox" name="selected_reviews[]" value="{{ $review->id }}">
                                    </td>
                                    <td>{{ $review->id }}</td>
                                    <td>{{ $review->User->name }}</td>
                                    <td>{{ $review->User->email }}</td>
                                    <td>{{ $review->message }}</td>
                                    <td>{{ $review->rating }}</td>
                                    <td>{{ $review->created_at }}</td>
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

