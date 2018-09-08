<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <title>SwimmIQ Activation</title>
  <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
  <link href="{{ asset('css/lib/bootstrap.min.css') }}" rel="stylesheet">
  <link  href="{{ asset('css/lib/swiper.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/lib/jquery.es-drawermenu.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/lib/style.min.css') }}">
  <link  href="{{ asset('css/lib/waves.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
</head>
 <body>
<!-- header Desktop -->
<center>
  <header class="mob-none tab-none">
      <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-3 logo" >
                    <a href="#">
                        <img src="{{ url('public/images/logo.png') }}" />
                    </a>
                </div>
            </div>
        </div>
    </div>
  </header>

  <!-- Registration Activation code starts here -->
  <div class="container" id="main-code">
  <div class="row" id="activation_text">
  <img src="{{ url('public/images/pool.jpg') }}" id="activation_img"/>
  <h3 style="color:  #46A6EA;" id="image_font"><b>Event Created Successfully</b></h3><br>
      <div class="col-xs-12">
      <h4 id="image_text">Thank you for creating Event in SwimmIQ</h4></div>
      <h4 style="color: #FF9900">Event <span style="color: green">{{$event_name}}</span> has been Created Sucessfully.</h4>
</div>
</div>
<!-- footer starts here -->
<footer class="mob-none tab-none">
    <div class="footer-icons">
       <div class="container">
        <div class="clearfix">
              <div class="col-md-6 footer-social-icons pull-right padding-rr">
                <a href="#" target="blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="#" target="blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                <a href="#" target="blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#" target="blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
              </div>
        </div>
    </div>
</div>

  <div class="swimmiq-copyright">
            <div class="container">
                <div class="clearfix">
                    <div class="text-center">
                      <b><p class="pull-right">SWIMMIQ
                   <span style="color:#46A6EA">|</span> VONKDOTH PRODUCT</p></b>
                    </div>
                </div>
            </div>
    </div>
</footer>
</center>
<!-- footer ends here -->

        <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
        <script src="{{ asset('js/lib/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/lib/jquery.interpolate.min.js') }}"></script>
        <script src="{{ asset('js/lib/jquery.coverflow.js') }}"></script>
        <script src="{{ asset('js/lib/waves.min.js') }}"></script>
        <script src="{{ asset('js/lib/reflection.js') }}"></script>
        <script src="{{ asset('js/lib/masonry.pkgd.min.js') }}"></script>
        <script src="{{ asset('js/lib/jquery.es-drawermenu.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
  <script>
    $('.owl-carousel').owlCarousel({
      loop:true,
      margin:5,
      nav:true,
      // autoWidth:true,

      navText: [" <span class='glyphicon glyphicon-chevron-left img-circle'></span>","<span class='glyphicon glyphicon-chevron-right img-circle'></span>"],
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          800:{
             items:2
         },
         1000:{
              items:4
          }
      }
  })
  </script>
<script type="text/javascript">
$(document).ready(function() {
  $('.drawermenu').drawermenu({
    speed:100,
    position:'left'
  });
});
</script>
   </body>
</html>









