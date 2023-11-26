@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>
                            List of customers</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered js-copytextarea" cellpadding="0" cellspacing="0" border="0"
                               id="sampleTable">
                            <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="all"></th>

                                <th width="20">ID </th>
                                <th>Full name</th>
                                <th width="250px" >Email</th>
                                <th >Thumbnail</th>
                                <th>Address</th>
                                <th>Telephone</th>
                                <th width="60">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user as $item)
                                <tr>
                                    <td width="10"><input type="checkbox" name="check1" value="1"></td>

                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td><img class="img-card-person" src="{{$item->thumbnail}}" alt=""></td>
                                    <td>{{$item->address}}</td>
                                    <td>{{$item->tel}}</td>
                                    <td>  <button style="padding: 7px 7px;"  class="site-btn" type="submit"> <a href="{{url("admin/admin-order-user", ['user' => $item->id])}}">
                                                Order</a>
                                        </button></td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <style>
        table {
            width: 100%;
            table-layout: fixed;
        }



    </style>

    @include("admin.layouts.scripts")

@endsection
