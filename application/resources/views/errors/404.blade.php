<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!--CSS-->
  <link href="{{ asset('theme/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('theme/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/css/magnific-popup.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/css/owl.carousel.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/css/subscribe-better.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/css/responsive.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/css/preset1.css') }}" rel="stylesheet">

  <!--Google Fonts-->
  <link href='https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700' rel='stylesheet' type='text/css'>

  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->
  <link rel="shortcut icon" href="{{ asset('theme/images/ico/favicon.ico') }}">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('theme/images/ico/apple-touch-icon-144-precomposed.png') }}">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('theme/images/ico/apple-touch-icon-114-precomposed.png') }}">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('theme/images/ico/apple-touch-icon-72-precomposed.png') }}">
  <link rel="apple-touch-icon-precomposed" href="{{ asset('theme/images/ico/apple-touch-icon-57-precomposed.png') }}">
</head><!--/head-->
<body>
	<div class="error-page text-center">
		<div class="container">
			<div class="logo">
				<a href="#" title="Back To Newspress Home Page"><img class="img-responsive" src="{{url('/')}}/images/logo-kecil-2.png" alt="" /></a>
			</div>
			<div class="error-content">
				<img class="img-responsive" src="{{ asset('theme/images/others/error.png') }}"/>
				<h1>Oops, terjadi kesalahan!</h1>
				<p>Halaman yang dituju tidak tersedia pada server.</p>
				<p>Namun jangan khawatir, kami sedang memperbaikinya!</p>
				<p><i class="fa fa-wrench"></i> <i class="fa fa-gears"></i> <i class="fa fa-smile-o"></i></p>
				<a href="{{route('index')}}" class="btn btn-primary">Kembali Ke Website</a>
			</div>
			<div class="copyright">
				<p>Kabupaten Tangerang @ 2016</p>
			</div>
		</div>
	</div>

	<!--/#scripts-->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="js/moment.min.js"></script>
	<script type="text/javascript" src="js/jquery.simpleWeather.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

</body>
</html>
