@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    List of products</li>
                <li class="breadcrumb-item"><a href="#">
                        product editing</a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title"> Create new products</h3>
                    <div class="tile-body">
                        <form class="row"  action="{{url("admin/admin-edit-san-pham",['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="form-group col-md-3">
                                <label class="control-label">
                                    Product's name</label>
                                <input type="text" name="name" value="{{$product->name}}" class="form-control"  placeholder="Enter Name" required>
                                @error("name")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group  col-md-3">
                                <label for="exampleInputPassword1">Price</label>
                                <input type="number" value="{{$product->price}}" name="price" class="form-control"  placeholder="Price">
                                @error("price")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 ">
                                <label>Qty</label>
                                <input type="number" value="{{$product->qty}}" name="qty" class="form-control"  placeholder="Qty">
                                @error("qty")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>


                            <div class="form-group col-md-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Choose category</option>
                                    @foreach($categories as $item)
                                        <option @if($item->id==$product->category_id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error("category_id")
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
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea name="description" class="form-control" row="5">
                        {{$product->description}}
                    </textarea>
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

