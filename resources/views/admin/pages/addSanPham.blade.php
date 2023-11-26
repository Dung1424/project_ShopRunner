@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">Danh sách nhân viên</li>
                <li class="breadcrumb-item"><a href="#">Thêm nhân viên</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tạo mới bhaan viên</h3>
                    <div class="tile-body">
                        <form class="row" action="{{url("admin/admin-add-nhan-vien")}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-3">
                                <label class="control-label">Full name</label>
                                <input type="text" name="name" value="{{old("name")}}" class="form-control"  placeholder="Enter Name" required>
                                @error("name")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group  col-md-3">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="text" value="{{old("email")}}" name="email" class="form-control"  placeholder="Email">
                                @error("email")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 ">
                                <label>Telephone</label>
                                <input type="text" value="{{old("tel")}}" name="tel" class="form-control"  placeholder="Telephone">
                                @error("tel")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 ">
                                <label>Address</label>
                                <input type="text" value="{{old("address")}}" name="address" class="form-control"  placeholder="Address">
                                @error("address")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 ">
                                <label>Password</label>
                                <input type="text" value="{{old("password")}}" name="password" class="form-control"  placeholder="Password">
                                @error("password")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Thumbnail</label>
                                <input type="file" name="thumbnail" class="form-control-file" id="employeeImage" accept="image/*" required>
                                <button class="btn btn-delete-image" type="button" id="deleteImage" style="display: none;"><i class="fas fa-times"></i></button>
                                <div id="imageContainer" class="mt-2" style="display: none;">
                                    <img src="" id="previewImage" width="100" height="100">
                                </div>
                            </div>

                            <button class="btn btn-save" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--
    MODAL
    -->
    @include("admin.layouts.scripts-formAdd")

@endsection
