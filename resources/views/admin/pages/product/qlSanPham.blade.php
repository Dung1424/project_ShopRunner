@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>List of products</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div  class="row">
            <div  class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-2">

                                <a class="btn btn-add btn-sm" href="{{url("admin/admin-add-san-pham")}}" title="Thêm"><i class="fas fa-plus"></i>

                                    Create new products</a>
                            </div>

                            <div class="col-sm-2">
                                <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                                        class="fas fa-print"></i>
                                    Print data</a>
                            </div>

                        </div>

                        <form style="display: flex" action="{{url("admin/admin-quan-ly-san-pham")}}" method="get">
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
                                <th> Name</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th width="70px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $item)
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                    <td> <img src="{{ $item->thumbnail }}" style="width: 100px; height: auto;" alt="">
                                    </td>
                                <td>{{$item->qty}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->Category->name}}</td>
                                <td style="display: flex">
                                    <form action="{{url("admin/admin-delete-san-pham",['products'=>$item->id])}}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button onclick="return confirm('Definitely want to delete the product: {{$item->name}}')" class="btn btn-primary btn-sm trash" type="submit"
                                               ><i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <button style="margin-left: 5px" class="btn btn-primary btn-sm edit" type="button" title="Sửa"  data-toggle="modal"
                                            data-target="#ModalUP"><a href="{{url("admin/admin-edit-san-pham",['products'=>$item->id])}}"><i class="fas fa-edit"></i></a></button>

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
