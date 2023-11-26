@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">DList of employee</li>
                <li class="breadcrumb-item"><a href="#">
                        Edit staff</a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Edit staff</h3>
                    <div class="tile-body">
                        <form class="row"  action="{{url("admin/admin-edit-nhan-vien",['user'=>$user->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="form-group col-md-3">
                                <label class="control-label">Full name</label>
                                <input type="text" name="name" value="{{$user->name}}" class="form-control"  placeholder="Enter Name" required>
                                @error("name")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group  col-md-3">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="text" value="{{$user->email}}" name="email" class="form-control"  placeholder="Price">
                                @error("email")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 ">
                                <label>Telephone</label>
                                <input type="text" value="{{$user->tel}}" name="tel" class="form-control"  placeholder="Telephone">
                                @error("tel")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 ">
                                <label>Address</label>
                                <input type="text" value="{{$user->address}}" name="address" class="form-control"  placeholder="Address">
                                @error("address")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label">Thumbnail</label>
                                <input type="file" name="thumbnail" class="form-control-file" id="employeeImage" accept="image/*">
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





    @include("admin.layouts.scripts-formAdd")
    @include("admin.layouts.js_formAddSanPham")
    @include("admin.layouts.scripts")
@endsection

