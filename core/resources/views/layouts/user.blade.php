<!DOCTYPE html>
<html lang="">

@include('layouts.head')

<body >

@include('layouts.preloader')

<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

@include('layouts.header')

@include('layouts.sidebar')
<div id="content" class="content">
@include('layouts.message')
@yield('content')
</div>
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
</div>
@yield('scripts')

<!--jquery script load-->
@include('layouts.scripts')
</body>
</html>
