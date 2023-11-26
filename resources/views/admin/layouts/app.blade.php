<!DOCTYPE html>
<html lang="en">

<head>
@include("admin.layouts.head")
</head>

<body onload="time()"  class="app sidebar-mini rtl">
<!-- Navbar-->
@include("admin.layouts.nav")
@include("admin.layouts.sidebar")


<section>
    @yield("main")
</section>
<!--
MODAL
-->



</body>
@yield("before_js")
</html>
