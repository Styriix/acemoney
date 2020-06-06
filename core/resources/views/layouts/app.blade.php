@include('layouts.apheader')
<body class="color-1" id="login-page">
@include('layouts.message')
<div class="content-for-template @if(request()->path() == 'login' || request()->path() == 'register') content-template-bg @endif">
  @yield('content')  
</div>

<!--preloader start-->
<div class="preloader">
    <div class="preloader-wrapper">
        <div class="preloader-img">
           <img src="{{asset('assets/images/logo/icon.png') }}" alt="*">
        </div>
    </div>
</div>
<!--preloader end-->

<footer >
    <!--footer area start-->
    <div class="copyright-area">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-6 col-md-7 ">
                    <p class="copyright-text">{{$gnl->title}}- {{$gnl->subtitle}}</p>
                </div>
            </div>
        </div>
    </div>
    <!--footer area end-->
</footer>


    <!--back to top start-->
    <div class="back-to-top">
        <i class="icofont icofont-simple-up"></i>
    </div>
    <!--back to top end-->

        <!--jquery script load-->
        <script src="{{asset('assets/front/js/jquery.js') }}"></script>
        <!--Owl carousel script load-->
        <script src="{{asset('assets/front/js/owl.carousel.min.js') }}"></script>
        <!--Propper script load here-->
        <script src="{{asset('assets/front/js/popper.min.js') }}"></script>
        <!--Bootstrap v4 script load here-->
        <script src="{{asset('assets/front/js/bootstrap.min.js') }}"></script>
        <!--Slick Nav Js File Load-->
        <script src="{{asset('assets/front/js/jquery.slicknav.min.js') }}"></script>
        <!--Scroll Spy File Load-->
        <script src="{{asset('assets/front/js/scrollspy.min.js') }}"></script>
        <!--Wow Js File Load-->
        <script src="{{asset('assets/front/js/wow.min.js') }}"></script>
        <!--Main js file load-->
        <script src="{{asset('assets/front/js/main.js') }}"></script>
    </body>
</html>
