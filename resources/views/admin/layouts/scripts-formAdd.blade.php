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
<script>
    oTable = $('#sampleTable').dataTable();
    $('#all').click(function (e) {
        $('#sampleTable tbody :checkbox').prop('checked', $(this).is(':checked'));
        e.stopImmediatePropagation();
    });

    //EXCEL
    // $(document).ready(function () {
    //   $('#').DataTable({

    //     dom: 'Bfrtip',
    //     "buttons": [
    //       'excel'
    //     ]
    //   });
    // });


    //Thời Gian
    function time() {
        var today = new Date();
        var weekday = new Array(7);
        weekday[0] = "Chủ Nhật";
        weekday[1] = "Thứ Hai";
        weekday[2] = "Thứ Ba";
        weekday[3] = "Thứ Tư";
        weekday[4] = "Thứ Năm";
        weekday[5] = "Thứ Sáu";
        weekday[6] = "Thứ Bảy";
        var day = weekday[today.getDay()];
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        nowTime = h + " giờ " + m + " phút " + s + " giây";
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        today = day + ', ' + dd + '/' + mm + '/' + yyyy;
        tmp = '<span class="date"> ' + today + ' - ' + nowTime +
            '</span>';
        document.getElementById("clock").innerHTML = tmp;
        clocktime = setTimeout("time()", "1000", "Javascript");

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    }
    //In dữ liệu
    var myApp = new function () {
        this.printTable = function () {
            var tab = document.getElementById('sampleTable');
            var win = window.open('', '', 'height=700,width=700');
            win.document.write(tab.outerHTML);
            win.document.close();
            win.print();
        }
    }
    //     //Sao chép dữ liệu
    //     var copyTextareaBtn = document.querySelector('.js-textareacopybtn');

    // copyTextareaBtn.addEventListener('click', function(event) {
    //   var copyTextarea = document.querySelector('.js-copytextarea');
    //   copyTextarea.focus();
    //   copyTextarea.select();

    //   try {
    //     var successful = document.execCommand('copy');
    //     var msg = successful ? 'successful' : 'unsuccessful';
    //     console.log('Copying text command was ' + msg);
    //   } catch (err) {
    //     console.log('Oops, unable to copy');
    //   }
    // });


    //Modal
    $("#show-emp").on("click", function () {
        $("#ModalUP").modal({ backdrop: false, keyboard: false })
    });
</script>

<!-- Google analytics script-->
<script type="text/javascript">
    if (document.location.hostname == 'pratikborsadiya.in') {
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
    }
</script>
