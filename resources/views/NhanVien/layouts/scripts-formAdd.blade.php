<!-- Essential javascripts for application to work-->
<script src="admin/jsjquery-3.2.1.min.js"></script>
<script src="admin/jspopper.min.js"></script>
<script src="admin/jsbootstrap.min.js"></script>
<script src="admin/jsmain.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="admin/jsplugins/pace.min.js"></script>


<script>
    var deleteImageButton = document.getElementById('deleteImage');
    var imageInput = document.getElementById('employeeImage');
    var imageContainer = document.getElementById('imageContainer');
    var previewImage = document.getElementById('previewImage');

    // Xử lý khi nút Xóa ảnh được nhấn
    deleteImageButton.addEventListener('click', function () {
        imageInput.value = ''; // Xóa ảnh và làm trống input file
        imageContainer.style.display = 'none'; // Ẩn khung hình và ảnh
        deleteImageButton.style.display = 'none'; // Ẩn nút Xóa ảnh
    });

    // Xử lý khi tải ảnh
    imageInput.addEventListener('change', function () {
        var fileInput = imageInput;

        // Kiểm tra nếu đã chọn tệp ảnh
        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var reader = new FileReader();

            // Đọc và hiển thị ảnh trong trình duyệt
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                imageContainer.style.display = 'block'; // Hiển thị khung hình và ảnh
                deleteImageButton.style.display = 'block'; // Hiện nút Xóa ảnh
            };

            reader.readAsDataURL(file);
        } else {
            previewImage.src = ''; // Xóa hình ảnh nếu không có tệp nào được chọn
            imageContainer.style.display = 'none'; // Ẩn khung hình và ảnh
            deleteImageButton.style.display = 'none'; // Ẩn nút Xóa ảnh
        }
    });

</script>
