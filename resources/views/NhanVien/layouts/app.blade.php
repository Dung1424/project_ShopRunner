<!DOCTYPE html>
<html lang="en">

<head>
@include("NhanVien.layouts.head")
</head>

<body onload="time()"  class="app sidebar-mini rtl">
<!-- Navbar-->
@include("NhanVien.layouts.nav")


<section>
    @yield("main")
</section>
<!--
MODAL
-->



</body>

</html>
