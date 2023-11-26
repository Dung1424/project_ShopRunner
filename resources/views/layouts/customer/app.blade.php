<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <base href="/">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title","Male-Fashion | Template")</title>
    @yield("before_css")
    @include("layouts.customer.head")
    @yield("after_css")
</head>
<body>

<div id="preloder">
    <div class="loader"></div>
</div>

@include("layouts.customer.header")

<section class="product spad">
    @yield("main")
</section>

@include("layouts.customer.footer")
@include("layouts.customer.icon")
@yield("before_js")
@include("layouts.customer.script")
@yield("after_js")

</body>
</html>
